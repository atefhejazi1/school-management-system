{{--
  ╔══════════════════════════════════════════════════════════════════════════════╗
  ║  CREATE / EDIT FORM PAGE TEMPLATE                                            ║
  ║  — Multi-section form layout, all input types, Livewire 3 validation        ║
  ║  — Bootstrap 5 + Emerald Green theme, full RTL/LTR support                 ║
  ╠══════════════════════════════════════════════════════════════════════════════╣
  ║  LIVEWIRE COMPONENT MUST EXPOSE (example for Students):                     ║
  ║    public ?int    $recordId    = null;  (null = create, int = edit)         ║
  ║    public string  $firstName   = '';                                         ║
  ║    public string  $lastName    = '';                                         ║
  ║    public string  $nationalId  = '';                                         ║
  ║    public string  $email       = '';                                         ║
  ║    public string  $phone       = '';                                         ║
  ║    public string  $birthDate   = '';                                         ║
  ║    public string  $gender      = '';                                         ║
  ║    public string  $gradeId     = '';                                         ║
  ║    public string  $address     = '';                                         ║
  ║    public string  $notes       = '';                                         ║
  ║    public bool    $isActive    = true;                                       ║
  ║    public bool    $sendWelcome = false;                                      ║
  ║    public         $photo       = null; (Livewire TemporaryUploadedFile)     ║
  ║    public string  $existingPhoto = '';                                       ║
  ║    — method save()   → validates + creates/updates + redirect or dispatch   ║
  ║    — method removePhoto()                                                    ║
  ║    — #[Validate] attributes OR protected $rules array                       ║
  ╚══════════════════════════════════════════════════════════════════════════════╝
--}}

@extends('layouts.master')

{{-- ════ Breadcrumb title ════ --}}
@section('PageTitle')
    {{-- Dynamically shows "Add" or "Edit" based on whether recordId is set --}}
    {{ $recordId ? trans('main_trans.edit') : trans('main_trans.add_student') }}
@endsection

@section('css')
@endsection

{{-- ════════════════════════════════════════════════════════
     CONTENT
════════════════════════════════════════════════════════ --}}
@section('content')

    {{-- ── Page Header ── --}}
    @include('layouts.partials.page-header', [
        'ph_icon'     => $recordId ? 'fas fa-pen-to-square' : 'fas fa-user-plus',
        'ph_title'    => $recordId ? trans('main_trans.edit') . ' — ' . ($firstName . ' ' . $lastName)
                                   : trans('main_trans.add_student'),
        'ph_subtitle' => trans('main_trans.students_subtitle'),
        'ph_back_url' => route('admin.students.index'),
    ])

    {{-- ── Form card — wire:submit calls the Livewire save() method ── --}}
    <form wire:submit.prevent="save" novalidate>
    <div class="admin-card">

        {{-- ═══════════════════════════════════════════════════════
             SECTION 1 — Personal Information (3-column grid)
        ═══════════════════════════════════════════════════════ --}}
        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h2 class="form-section-title">{{ trans('main_trans.personal_info') }}</h2>
                    <p class="form-section-subtitle">{{ trans('main_trans.personal_info_desc') }}</p>
                </div>
            </div>

            <div class="row g-4">

                {{-- First Name --}}
                <div class="col-md-4">
                    <label for="firstName" class="form-label">
                        {{ trans('main_trans.first_name') }}
                        <span class="text-danger ms-1">*</span>
                    </label>
                    <input type="text"
                           id="firstName"
                           class="form-control @error('firstName') is-invalid @enderror"
                           wire:model.blur="firstName"
                           placeholder="{{ trans('main_trans.first_name') }}"
                           maxlength="60"
                           required>
                    @error('firstName')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div class="col-md-4">
                    <label for="lastName" class="form-label">
                        {{ trans('main_trans.last_name') }}
                        <span class="text-danger ms-1">*</span>
                    </label>
                    <input type="text"
                           id="lastName"
                           class="form-control @error('lastName') is-invalid @enderror"
                           wire:model.blur="lastName"
                           placeholder="{{ trans('main_trans.last_name') }}"
                           maxlength="60"
                           required>
                    @error('lastName')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- National ID --}}
                <div class="col-md-4">
                    <label for="nationalId" class="form-label">
                        {{ trans('main_trans.national_id') }}
                        <span class="text-danger ms-1">*</span>
                    </label>
                    <input type="text"
                           id="nationalId"
                           class="form-control @error('nationalId') is-invalid @enderror"
                           wire:model.blur="nationalId"
                           placeholder="1234567890"
                           maxlength="20"
                           required>
                    @error('nationalId')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <span class="form-hint">
                        <i class="fas fa-info-circle me-1"></i>
                        {{ trans('main_trans.national_id_hint') }}
                    </span>
                </div>

                {{-- Date of Birth --}}
                <div class="col-md-4">
                    <label for="birthDate" class="form-label">
                        {{ trans('main_trans.birth_date_label') }}
                        <span class="text-danger ms-1">*</span>
                    </label>
                    <input type="date"
                           id="birthDate"
                           class="form-control @error('birthDate') is-invalid @enderror"
                           wire:model.blur="birthDate"
                           max="{{ now()->subYears(4)->format('Y-m-d') }}">
                    @error('birthDate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Gender — Select --}}
                <div class="col-md-4">
                    <label for="gender" class="form-label">
                        {{ trans('main_trans.gender_label') }}
                        <span class="text-danger ms-1">*</span>
                    </label>
                    <select id="gender"
                            class="form-select @error('gender') is-invalid @enderror"
                            wire:model.live="gender">
                        <option value="" disabled selected>
                            {{ trans('main_trans.select_option') }}
                        </option>
                        <option value="male">{{ trans('main_trans.male') }}</option>
                        <option value="female">{{ trans('main_trans.female') }}</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Grade — Select (cascaded by AJAX or Livewire) --}}
                <div class="col-md-4">
                    <label for="gradeId" class="form-label">
                        {{ trans('main_trans.Grades') }}
                        <span class="text-danger ms-1">*</span>
                    </label>
                    <select id="gradeId"
                            class="form-select @error('gradeId') is-invalid @enderror"
                            wire:model.live="gradeId">
                        <option value="" disabled selected>
                            {{ trans('main_trans.select_option') }}
                        </option>
                        @foreach($grades ?? [] as $grade)
                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                        @endforeach
                    </select>
                    @error('gradeId')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>{{-- /.row --}}
        </div>{{-- /.form-section --}}

        {{-- ═══════════════════════════════════════════════════════
             SECTION 2 — Contact Information (2-column grid)
        ═══════════════════════════════════════════════════════ --}}
        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-icon">
                    <i class="fas fa-address-card"></i>
                </div>
                <div>
                    <h2 class="form-section-title">{{ trans('main_trans.contact_info') }}</h2>
                    <p class="form-section-subtitle">{{ trans('main_trans.contact_info_desc') }}</p>
                </div>
            </div>

            <div class="row g-4">

                {{-- Email --}}
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        {{ trans('main_trans.email_label') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:var(--border);">
                            <i class="fas fa-envelope text-muted" style="font-size:.85rem;"></i>
                        </span>
                        <input type="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               wire:model.blur="email"
                               placeholder="student@school.edu"
                               style="border-radius:0 10px 10px 0;">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Phone --}}
                <div class="col-md-6">
                    <label for="phone" class="form-label">
                        {{ trans('main_trans.phone_label') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:var(--border);">
                            <i class="fas fa-phone text-muted" style="font-size:.85rem;"></i>
                        </span>
                        <input type="tel"
                               id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               wire:model.blur="phone"
                               placeholder="+966 5x xxx xxxx"
                               style="border-radius:0 10px 10px 0;">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Address — full width --}}
                <div class="col-12">
                    <label for="address" class="form-label">
                        {{ trans('main_trans.address_label') }}
                    </label>
                    <input type="text"
                           id="address"
                           class="form-control @error('address') is-invalid @enderror"
                           wire:model.blur="address"
                           placeholder="{{ trans('main_trans.address_label') }}"
                           maxlength="200">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>{{-- /.row --}}
        </div>{{-- /.form-section --}}

        {{-- ═══════════════════════════════════════════════════════
             SECTION 3 — Additional Information
             (Textarea, Checkboxes, Radios, File upload)
        ═══════════════════════════════════════════════════════ --}}
        <div class="form-section">
            <div class="form-section-header">
                <div class="form-section-icon">
                    <i class="fas fa-circle-info"></i>
                </div>
                <div>
                    <h2 class="form-section-title">{{ trans('main_trans.additional_info') }}</h2>
                    <p class="form-section-subtitle">{{ trans('main_trans.additional_info_desc') }}</p>
                </div>
            </div>

            <div class="row g-4">

                {{-- Notes — Textarea --}}
                <div class="col-12">
                    <label for="notes" class="form-label">
                        {{ trans('main_trans.notes_label') }}
                    </label>
                    <textarea id="notes"
                              class="form-control @error('notes') is-invalid @enderror"
                              wire:model.blur="notes"
                              rows="4"
                              maxlength="1000"
                              placeholder="{{ trans('main_trans.notes_placeholder') }}"
                              x-data
                              @input="$el.nextElementSibling.textContent = $el.value.length + '/1000'"></textarea>
                    <span class="char-counter">0/1000</span>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Photo Upload — File input with live preview --}}
                <div class="col-md-6">
                    <label class="form-label">{{ trans('main_trans.image_label') }}</label>

                    {{-- Existing photo preview (Edit mode) --}}
                    @if($existingPhoto)
                        <div class="mb-3">
                            <div class="img-preview-wrap">
                                <img src="{{ asset('storage/' . $existingPhoto) }}"
                                     class="img-preview" alt="">
                                <button type="button"
                                        class="img-preview-remove"
                                        wire:click="removePhoto"
                                        title="{{ trans('main_trans.delete_btn') }}">
                                    <i class="fas fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Upload zone --}}
                    <div class="upload-zone @error('photo') border-danger @enderror"
                         x-data="{ preview: null }"
                         @dragover.prevent="$el.classList.add('dragover')"
                         @dragleave.prevent="$el.classList.remove('dragover')"
                         @drop.prevent="$el.classList.remove('dragover')">

                        <input type="file"
                               wire:model="photo"
                               accept="image/jpeg,image/png,image/webp"
                               @change="
                                   const f = $event.target.files[0];
                                   if (f) {
                                       const r = new FileReader();
                                       r.onload = e => preview = e.target.result;
                                       r.readAsDataURL(f);
                                   }
                               ">

                        {{-- Show preview or placeholder icon --}}
                        <template x-if="!preview">
                            <div>
                                <div class="upload-zone-icon">
                                    <i class="fas fa-cloud-arrow-up"></i>
                                </div>
                                <p class="upload-zone-text">{{ trans('main_trans.upload_file') }}</p>
                                <p class="upload-zone-hint">JPG, PNG, WEBP — {{ trans('main_trans.upload_hint') }}</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <img :src="preview" class="img-preview" alt="preview"
                                 style="pointer-events:none;">
                        </template>

                    </div>

                    {{-- Livewire upload progress --}}
                    <div wire:loading wire:target="photo" class="mt-2">
                        <div class="progress" style="height:4px;border-radius:4px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                 style="width:100%"></div>
                        </div>
                    </div>

                    @error('photo')
                        <div class="text-danger mt-1" style="font-size:.8rem;">
                            <i class="fas fa-circle-xmark me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Status + Options column --}}
                <div class="col-md-6">

                    {{-- Status — Toggle switch style --}}
                    <div class="mb-4">
                        <label class="form-label d-block">{{ trans('main_trans.status') }}</label>
                        <div class="d-flex align-items-center gap-3 flex-wrap">

                            {{-- Radio: Active --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('isActive') is-invalid @enderror"
                                       type="radio"
                                       id="statusActive"
                                       wire:model.live="isActive"
                                       value="1">
                                <label class="form-check-label" for="statusActive">
                                    <span class="pill pill-success">
                                        <i class="fas fa-circle" style="font-size:6px;"></i>
                                        {{ trans('main_trans.active') }}
                                    </span>
                                </label>
                            </div>

                            {{-- Radio: Inactive --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       id="statusInactive"
                                       wire:model.live="isActive"
                                       value="0">
                                <label class="form-check-label" for="statusInactive">
                                    <span class="pill pill-danger">
                                        <i class="fas fa-circle" style="font-size:6px;"></i>
                                        {{ trans('main_trans.inactive') }}
                                    </span>
                                </label>
                            </div>

                        </div>
                        @error('isActive')
                            <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Checkboxes — Preferences / Options --}}
                    <div>
                        <label class="form-label d-block">{{ trans('main_trans.options_label') }}</label>

                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="sendWelcome"
                                   wire:model.live="sendWelcome">
                            <label class="form-check-label" for="sendWelcome"
                                   style="font-size:.87rem;font-weight:500;">
                                {{ trans('main_trans.send_welcome_email') }}
                            </label>
                            <span class="form-hint ms-4" style="margin-top:0;">
                                {{ trans('main_trans.send_welcome_email_hint') }}
                            </span>
                        </div>

                        {{-- Add more checkboxes as needed --}}
                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="notifyParent"
                                   wire:model.live="notifyParent">
                            <label class="form-check-label" for="notifyParent"
                                   style="font-size:.87rem;font-weight:500;">
                                {{ trans('main_trans.notify_parent') }}
                            </label>
                        </div>

                    </div>
                </div>

            </div>{{-- /.row --}}
        </div>{{-- /.form-section --}}

        {{-- ═══════════════════════════════════════════════════════
             FORM FOOTER — Submit / Cancel
        ═══════════════════════════════════════════════════════ --}}
        <div class="form-footer">

            {{-- Cancel → back to index --}}
            <a href="{{ route('admin.students.index') }}"
               class="btn btn-emerald-outline">
                <i class="fas fa-xmark me-2"></i>
                {{ trans('main_trans.cancel') }}
            </a>

            {{-- Reset form (optional) --}}
            <button type="button"
                    class="btn btn-outline-secondary"
                    wire:click="$refresh"
                    style="border-radius:10px;font-family:'Cairo',sans-serif;font-weight:600;">
                <i class="fas fa-rotate-left me-2"></i>
                {{ trans('main_trans.reset') }}
            </button>

            {{-- Submit --}}
            <button type="submit"
                    class="btn btn-emerald"
                    wire:loading.attr="disabled"
                    wire:target="save,photo">

                {{-- Default state --}}
                <span wire:loading.remove wire:target="save">
                    <i class="fas fa-{{ $recordId ? 'floppy-disk' : 'plus' }} me-2"></i>
                    {{ $recordId ? trans('main_trans.save_changes') : trans('main_trans.save') }}
                </span>

                {{-- Loading state --}}
                <span wire:loading wire:target="save">
                    <span class="spinner-border spinner-border-sm me-2"
                          role="status" aria-hidden="true"></span>
                    {{ trans('main_trans.saving') }}
                </span>

            </button>

        </div>{{-- /.form-footer --}}

    </div>{{-- /.admin-card --}}
    </form>

@endsection

@section('js')
{{--
  Alpine.js drag-and-drop for the upload zone is handled inline via x-data above.
  No extra JS needed for Livewire 3 validation — errors are reactive automatically.
--}}
@endsection
