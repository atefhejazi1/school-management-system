{{--
  ╔══════════════════════════════════════════════════════════╗
  ║  PAGE HEADER — Reusable inner-page title bar             ║
  ╚══════════════════════════════════════════════════════════╝

  Props (passed via @include):
    $ph_icon          (string)  FA icon class, e.g. 'fas fa-users'      default: 'fas fa-file'
    $ph_title         (string)  Page title (required)
    $ph_subtitle      (string)  Optional subtitle / description
    $ph_action_label  (string)  Primary button label   (optional)
    $ph_action_url    (string)  Primary button URL     (optional, used when no event)
    $ph_action_event  (string)  Livewire dispatch event (optional, takes priority over URL)
    $ph_back_url      (string)  "Back" button URL      (optional, for Create/Edit/Show pages)
    $ph_extra_buttons (array)   Additional buttons:    (optional)
                                [['label'=>'', 'icon'=>'', 'url'=>'', 'event'=>'', 'class'=>'btn-emerald-outline']]

  Usage — Index page:
    @include('layouts.partials.page-header', [
        'ph_icon'         => 'fas fa-user-graduate',
        'ph_title'        => trans('main_trans.list_students'),
        'ph_subtitle'     => trans('main_trans.students_subtitle'),
        'ph_action_label' => trans('main_trans.add_new'),
        'ph_action_event' => 'openCreateModal',
    ])

  Usage — Create/Edit page with back button:
    @include('layouts.partials.page-header', [
        'ph_icon'         => 'fas fa-user-plus',
        'ph_title'        => trans('main_trans.add_student'),
        'ph_back_url'     => route('admin.students.index'),
    ])
--}}

@php
    $ph_icon         = $ph_icon         ?? 'fas fa-file';
    $ph_title        = $ph_title        ?? '';
    $ph_subtitle     = $ph_subtitle     ?? null;
    $ph_action_label = $ph_action_label ?? null;
    $ph_action_url   = $ph_action_url   ?? null;
    $ph_action_event = $ph_action_event ?? null;
    $ph_back_url     = $ph_back_url     ?? null;
    $ph_extra_buttons = $ph_extra_buttons ?? [];
@endphp

<div class="ph-wrap">

    {{-- ── Left side: icon + title + subtitle ── --}}
    <div class="ph-title-group">
        <div class="ph-icon-wrap">
            <i class="{{ $ph_icon }}"></i>
        </div>
        <div>
            <h1 class="ph-title">{{ $ph_title }}</h1>
            @if($ph_subtitle)
                <p class="ph-subtitle">{{ $ph_subtitle }}</p>
            @endif
        </div>
    </div>

    {{-- ── Right side: action buttons ── --}}
    <div class="ph-actions">

        {{-- Back button (for form / show pages) --}}
        @if($ph_back_url)
            <a href="{{ $ph_back_url }}" class="btn btn-emerald-outline btn-sm">
                <i class="fas fa-arrow-left me-2"></i>
                {{ trans('main_trans.back') }}
            </a>
        @endif

        {{-- Extra buttons (e.g. Export, Print) --}}
        @foreach($ph_extra_buttons as $eb)
            @if($eb['event'] ?? null)
                <button type="button"
                        class="btn {{ $eb['class'] ?? 'btn-emerald-outline' }} btn-sm"
                        wire:click="$dispatch('{{ $eb['event'] }}')">
                    @if($eb['icon'] ?? null)<i class="{{ $eb['icon'] }} me-2"></i>@endif
                    {{ $eb['label'] ?? '' }}
                </button>
            @elseif($eb['url'] ?? null)
                <a href="{{ $eb['url'] }}"
                   class="btn {{ $eb['class'] ?? 'btn-emerald-outline' }} btn-sm">
                    @if($eb['icon'] ?? null)<i class="{{ $eb['icon'] }} me-2"></i>@endif
                    {{ $eb['label'] ?? '' }}
                </a>
            @endif
        @endforeach

        {{-- Primary action button --}}
        @if($ph_action_label)
            @if($ph_action_event)
                <button type="button"
                        class="btn btn-emerald btn-sm"
                        wire:click="$dispatch('{{ $ph_action_event }}')">
                    <i class="fas fa-plus me-2"></i>
                    {{ $ph_action_label }}
                </button>
            @elseif($ph_action_url)
                <a href="{{ $ph_action_url }}" class="btn btn-emerald btn-sm">
                    <i class="fas fa-plus me-2"></i>
                    {{ $ph_action_label }}
                </a>
            @endif
        @endif

    </div>

</div>
