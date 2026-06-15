{{--
  ╔══════════════════════════════════════════════════════════════════════════════╗
  ║  SHOW / DETAIL / PROFILE PAGE TEMPLATE                                       ║
  ║  — Emerald profile hero, quick-stats bar, info grid, related table          ║
  ║  — Bootstrap 5 + Emerald Green theme, full RTL/LTR support                 ║
  ╠══════════════════════════════════════════════════════════════════════════════╣
  ║  Controller / Livewire must pass:                                            ║
  ║    $record       — the model (e.g. Student)                                  ║
  ║    $attendances  — related records (paginated or collection)                 ║
  ║    $grades       — related grade records                                     ║
  ╚══════════════════════════════════════════════════════════════════════════════╝
--}}

@extends('layouts.master')

@section('PageTitle')
    {{ $record->name ?? trans('main_trans.profile_overview') }}
@endsection

@section('css')
@endsection

@section('content')

    {{-- ── Page Header ── --}}
    @include('layouts.partials.page-header', [
        'ph_icon'     => 'fas fa-id-card',
        'ph_title'    => trans('main_trans.profile_overview'),
        'ph_subtitle' => $record->name ?? '',
        'ph_back_url' => route('admin.students.index'),
        'ph_extra_buttons' => [
            [
                'label' => trans('main_trans.edit'),
                'icon'  => 'fas fa-pen-to-square',
                'url'   => route('admin.students.edit', $record->id),
                'class' => 'btn-emerald-outline',
            ],
        ],
    ])

    <div class="row g-4">

        {{-- ══════════════════════════════════════════
             LEFT COLUMN: Profile hero + Quick info
        ══════════════════════════════════════════ --}}
        <div class="col-lg-4">

            {{-- ── Profile Hero Card ── --}}
            <div class="admin-card mb-4" style="overflow:hidden;padding:0;">

                {{-- Hero banner --}}
                <div class="profile-hero">
                    <div class="d-flex align-items-center gap-3 position-relative" style="z-index:1;">

                        {{-- Avatar --}}
                        <div class="profile-avatar">
                            @if($record->image)
                                <img src="{{ asset('storage/' . $record->image) }}"
                                     alt="{{ $record->name }}">
                            @else
                                {{ mb_strtoupper(mb_substr($record->name, 0, 1)) }}
                            @endif
                        </div>

                        {{-- Name + role --}}
                        <div class="flex-grow-1">
                            <h2 class="profile-hero-name">{{ $record->name }}</h2>
                            <p class="profile-hero-sub">
                                {{ $record->grade->name ?? '—' }}
                                @if($record->section)
                                    &mdash; {{ $record->section->name }}
                                @endif
                            </p>
                            <div class="mt-2">
                                @if($record->is_active)
                                    <span class="pill pill-success">
                                        <i class="fas fa-circle" style="font-size:6px;"></i>
                                        {{ trans('main_trans.active') }}
                                    </span>
                                @else
                                    <span class="pill pill-danger">
                                        <i class="fas fa-circle" style="font-size:6px;"></i>
                                        {{ trans('main_trans.inactive') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Quick Stats Bar --}}
                <div class="profile-stats-bar">

                    <div class="profile-stat-item">
                        <div class="profile-stat-value">
                            {{ $attendanceRate ?? '—' }}
                            @if($attendanceRate)<small style="font-size:.75rem;font-weight:600;">%</small>@endif
                        </div>
                        <div class="profile-stat-label">{{ trans('main_trans.Attendance') }}</div>
                    </div>

                    <div class="profile-stat-item">
                        <div class="profile-stat-value">{{ $gradeAverage ?? '—' }}</div>
                        <div class="profile-stat-label">{{ trans('main_trans.Exams') }}</div>
                    </div>

                    <div class="profile-stat-item">
                        <div class="profile-stat-value">{{ $totalFees ?? '—' }}</div>
                        <div class="profile-stat-label">{{ trans('main_trans.fees_title') }}</div>
                    </div>

                </div>

            </div>{{-- /.admin-card (profile) --}}

            {{-- ── Personal Info Card ── --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-title">
                        <i class="fas fa-user"></i>
                        {{ trans('main_trans.personal_info') }}
                    </div>
                </div>
                <div class="p-4">

                    <div class="info-item">
                        <div class="info-label">{{ trans('main_trans.national_id') }}</div>
                        <div class="info-value">{{ $record->national_id ?? '—' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">{{ trans('main_trans.birth_date_label') }}</div>
                        <div class="info-value">
                            {{ $record->birth_date
                                ? \Carbon\Carbon::parse($record->birth_date)->format('d / m / Y')
                                : '—' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">{{ trans('main_trans.gender_label') }}</div>
                        <div class="info-value">
                            @if($record->gender === 'male')
                                <span class="pill pill-info">
                                    <i class="fas fa-mars" style="font-size:.75rem;"></i>
                                    {{ trans('main_trans.male') }}
                                </span>
                            @elseif($record->gender === 'female')
                                <span class="pill" style="background:#fdf2f8;color:#9d174d;border:1px solid #f9a8d4;">
                                    <i class="fas fa-venus" style="font-size:.75rem;"></i>
                                    {{ trans('main_trans.female') }}
                                </span>
                            @else
                                <span class="info-value empty">—</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">{{ trans('main_trans.Grades') }}</div>
                        <div class="info-value">{{ $record->grade->name ?? '—' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">{{ trans('main_trans.created_at_label') }}</div>
                        <div class="info-value">
                            {{ $record->created_at
                                ? $record->created_at->format('d / m / Y')
                                : '—' }}
                        </div>
                    </div>

                </div>
            </div>{{-- /.admin-card (personal info) --}}

        </div>{{-- /.col-lg-4 --}}

        {{-- ══════════════════════════════════════════
             RIGHT COLUMN: Contact + Tabbed related data
        ══════════════════════════════════════════ --}}
        <div class="col-lg-8">

            {{-- ── Contact Info Card ── --}}
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <div class="admin-card-title">
                        <i class="fas fa-address-card"></i>
                        {{ trans('main_trans.contact_info') }}
                    </div>
                    <a href="{{ route('admin.students.edit', $record->id) }}"
                       class="btn-icon btn-icon-warning"
                       title="{{ trans('main_trans.edit') }}">
                        <i class="fas fa-pen-to-square"></i>
                    </a>
                </div>
                <div class="p-4">
                    <div class="row g-3">

                        <div class="col-sm-6">
                            <div class="info-label">{{ trans('main_trans.email_label') }}</div>
                            <div class="info-value">
                                @if($record->email)
                                    <a href="mailto:{{ $record->email }}"
                                       class="text-decoration-none"
                                       style="color:var(--em-600);font-size:.9rem;font-weight:600;">
                                        {{ $record->email }}
                                    </a>
                                @else
                                    <span class="info-value empty">—</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">{{ trans('main_trans.phone_label') }}</div>
                            <div class="info-value">
                                @if($record->phone)
                                    <a href="tel:{{ $record->phone }}"
                                       class="text-decoration-none"
                                       style="color:var(--em-600);font-size:.9rem;font-weight:600;">
                                        {{ $record->phone }}
                                    </a>
                                @else
                                    <span class="info-value empty">—</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-label">{{ trans('main_trans.address_label') }}</div>
                            <div class="info-value">{{ $record->address ?? '—' }}</div>
                        </div>

                        @if($record->notes)
                            <div class="col-12">
                                <div class="info-label">{{ trans('main_trans.notes_label') }}</div>
                                <div class="info-value"
                                     style="white-space:pre-line;font-size:.87rem;line-height:1.7;">
                                    {{ $record->notes }}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>{{-- /.admin-card (contact) --}}

            {{-- ── Tabbed Related Data Card ── --}}
            <div class="admin-card"
                 x-data="{ activeTab: 'attendance' }">

                <div class="admin-card-header">
                    <div class="admin-card-title">
                        <i class="fas fa-table-list"></i>
                        {{ trans('main_trans.related_records') }}
                    </div>

                    {{-- Tab switcher --}}
                    <div class="profile-tabs">
                        <button type="button"
                                class="profile-tab-btn"
                                :class="{ active: activeTab === 'attendance' }"
                                @click="activeTab = 'attendance'">
                            <i class="fas fa-calendar-check me-1"></i>
                            {{ trans('main_trans.Attendance') }}
                        </button>
                        <button type="button"
                                class="profile-tab-btn"
                                :class="{ active: activeTab === 'grades' }"
                                @click="activeTab = 'grades'">
                            <i class="fas fa-star-half-stroke me-1"></i>
                            {{ trans('main_trans.Exams') }}
                        </button>
                        <button type="button"
                                class="profile-tab-btn"
                                :class="{ active: activeTab === 'fees' }"
                                @click="activeTab = 'fees'">
                            <i class="fas fa-money-bill-wave me-1"></i>
                            {{ trans('main_trans.fees_title') }}
                        </button>
                    </div>
                </div>

                {{-- ── Attendance Tab ── --}}
                <div x-show="activeTab === 'attendance'" x-transition>
                    @if(($attendances ?? collect())->isEmpty())
                        @include('layouts.partials.empty-state', [
                            'type'    => 'no_data',
                            'icon'    => 'fas fa-calendar-xmark',
                        ])
                    @else
                        <div class="table-responsive">
                            <table class="table admin-table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('main_trans.row_num') }}</th>
                                        <th>{{ trans('main_trans.Attendance') }}</th>
                                        <th class="text-center">{{ trans('main_trans.status') }}</th>
                                        <th>{{ trans('main_trans.notes_label') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $att)
                                    <tr>
                                        <td class="text-muted fw-semibold" style="font-size:.78rem;">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td style="font-size:.85rem;">
                                            {{ \Carbon\Carbon::parse($att->date)->format('d / m / Y') }}
                                        </td>
                                        <td class="text-center">
                                            @if($att->status === 'present')
                                                <span class="pill pill-success">
                                                    <i class="fas fa-check" style="font-size:.7rem;"></i>
                                                    حاضر
                                                </span>
                                            @elseif($att->status === 'absent')
                                                <span class="pill pill-danger">
                                                    <i class="fas fa-xmark" style="font-size:.7rem;"></i>
                                                    غائب
                                                </span>
                                            @else
                                                <span class="pill pill-warning">
                                                    <i class="fas fa-clock" style="font-size:.7rem;"></i>
                                                    متأخر
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-muted" style="font-size:.83rem;">
                                            {{ $att->notes ?? '—' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- ── Grades Tab ── --}}
                <div x-show="activeTab === 'grades'" x-transition x-cloak>
                    @if(($gradeResults ?? collect())->isEmpty())
                        @include('layouts.partials.empty-state', [
                            'type' => 'no_data',
                            'icon' => 'fas fa-star',
                        ])
                    @else
                        <div class="table-responsive">
                            <table class="table admin-table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('main_trans.subjects') }}</th>
                                        <th class="text-center">{{ trans('main_trans.Exams') }}</th>
                                        <th class="text-center">{{ trans('main_trans.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gradeResults as $result)
                                    <tr>
                                        <td style="font-size:.88rem;font-weight:600;">
                                            {{ $result->subject->name ?? '—' }}
                                        </td>
                                        <td class="text-center">
                                            <span style="font-size:1rem;font-weight:800;color:#0f172a;">
                                                {{ $result->score ?? '—' }}
                                            </span>
                                            @if($result->max_score)
                                                <span class="text-muted" style="font-size:.75rem;">
                                                    / {{ $result->max_score }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php $pct = $result->max_score ? ($result->score / $result->max_score) * 100 : 0; @endphp
                                            @if($pct >= 85)
                                                <span class="pill pill-success">ممتاز</span>
                                            @elseif($pct >= 70)
                                                <span class="pill pill-info">جيد</span>
                                            @elseif($pct >= 50)
                                                <span class="pill pill-warning">مقبول</span>
                                            @else
                                                <span class="pill pill-danger">راسب</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- ── Fees Tab ── --}}
                <div x-show="activeTab === 'fees'" x-transition x-cloak>
                    @if(($feeInvoices ?? collect())->isEmpty())
                        @include('layouts.partials.empty-state', [
                            'type' => 'no_data',
                            'icon' => 'fas fa-file-invoice-dollar',
                        ])
                    @else
                        <div class="table-responsive">
                            <table class="table admin-table">
                                <thead>
                                    <tr>
                                        <th>{{ trans('main_trans.invoices') }}</th>
                                        <th class="text-end">{{ trans('main_trans.fees_title') }}</th>
                                        <th class="text-center">{{ trans('main_trans.status') }}</th>
                                        <th>{{ trans('main_trans.created_at_label') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feeInvoices as $invoice)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold" style="font-size:.88rem;">
                                                #{{ $invoice->id }}
                                            </div>
                                            <div class="text-muted" style="font-size:.75rem;">
                                                {{ $invoice->description ?? '' }}
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold" style="font-size:.9rem;">
                                            {{ number_format($invoice->amount, 2) }}
                                        </td>
                                        <td class="text-center">
                                            @if($invoice->is_paid)
                                                <span class="pill pill-success">مدفوع</span>
                                            @else
                                                <span class="pill pill-danger">غير مدفوع</span>
                                            @endif
                                        </td>
                                        <td class="text-muted" style="font-size:.82rem;">
                                            {{ $invoice->created_at->format('d / m / Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>{{-- /.admin-card (tabbed) --}}

        </div>{{-- /.col-lg-8 --}}

    </div>{{-- /.row --}}

@endsection

@section('js')
{{--
  Alpine.js tab switching (x-data / x-show) is handled inline.
  x-cloak hides non-active tabs until Alpine initializes.
  Add [x-cloak] { display: none !important; } to your CSS if not already present.
--}}
<style>[x-cloak] { display: none !important; }</style>
@endsection
