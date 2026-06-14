<?php

namespace App\Livewire\Admin;

use App\Mail\RegistrationApproved;
use App\Models\SchoolRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class RegistrationRequests extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';

    // Approve modal
    public bool  $showApproveModal = false;
    public ?int  $approvingId      = null;
    public bool  $createAccount    = false;

    // Reject modal
    public bool   $showRejectModal = false;
    public ?int   $rejectingId     = null;
    public string $rejectReason    = '';

    // Details modal
    public bool                  $showDetailsModal = false;
    public ?SchoolRegistration   $detailsRecord    = null;

    protected $queryString = [
        'search'       => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    // ── Approve ──────────────────────────────────────────
    public function openApprove(int $id): void
    {
        $this->approvingId   = $id;
        $this->createAccount = false;
        $this->showApproveModal = true;
    }

    public function confirmApprove(): void
    {
        $reg = SchoolRegistration::findOrFail($this->approvingId);
        $reg->update(['status' => 'approved']);

        if ($this->createAccount) {
            $password = Str::random(10);
            User::create([
                'name'     => $reg->contact_name,
                'email'    => $reg->email,
                'password' => bcrypt($password),
            ]);
            try {
                Mail::to($reg->email)->send(new RegistrationApproved($reg, $password));
            } catch (\Exception) {
                // Mail failure does not roll back the approval
            }
        }

        $this->showApproveModal = false;
        $this->approvingId      = null;
        session()->flash('success', 'تمت الموافقة على طلب تسجيل ' . $reg->school_name . ' بنجاح.');
    }

    // ── Reject ───────────────────────────────────────────
    public function openReject(int $id): void
    {
        $this->rejectingId  = $id;
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    public function confirmReject(): void
    {
        $this->validate(
            ['rejectReason' => 'required|min:5'],
            [
                'rejectReason.required' => 'يرجى كتابة سبب الرفض.',
                'rejectReason.min'      => 'سبب الرفض يجب أن يكون 5 أحرف على الأقل.',
            ]
        );

        $reg = SchoolRegistration::findOrFail($this->rejectingId);
        $reg->update([
            'status'      => 'rejected',
            'admin_notes' => $this->rejectReason,
        ]);

        $this->showRejectModal = false;
        $this->rejectingId     = null;
        session()->flash('success', 'تم رفض طلب ' . $reg->school_name . '.');
    }

    // ── Details ──────────────────────────────────────────
    public function openDetails(int $id): void
    {
        $this->detailsRecord    = SchoolRegistration::findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function render()
    {
        $query = SchoolRegistration::query();

        if ($this->search) {
            $s = $this->search;
            $query->where(fn($q) => $q
                ->where('school_name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")
                ->orWhere('contact_name', 'like', "%{$s}%")
            );
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $registrations = $query->latest()->paginate(15);
        $pendingCount  = SchoolRegistration::pending()->count();

        return view('livewire.admin.registration-requests', compact('registrations', 'pendingCount'));
    }
}
