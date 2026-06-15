{{--
  Empty State component

  Props (passed via @include):
    $type     (string) — 'no_data' | 'no_results' | 'error' | 'custom'  default: 'no_data'
    $title    (string) — override title text
    $message  (string) — override message text
    $action   (string) — label for the action button (optional)
    $actionEvent (string) — Livewire event to dispatch on action click (optional)
    $actionUrl   (string) — URL for action link (optional, used if no event)
    $icon     (string) — Font Awesome class override e.g. 'fas fa-inbox'

  Usage:
    @include('layouts.partials.empty-state', ['type' => 'no_results'])
    @include('layouts.partials.empty-state', [
        'type'        => 'no_data',
        'action'      => trans('main_trans.add_new'),
        'actionEvent' => 'openCreateModal',
    ])
--}}
@php
    $esType    = $type        ?? 'no_data';
    $esTitle   = $title       ?? null;
    $esMessage = $message     ?? null;
    $esAction  = $action      ?? null;
    $esEvent   = $actionEvent ?? null;
    $esUrl     = $actionUrl   ?? null;

    $presets = [
        'no_data' => [
            'icon'    => 'fas fa-database',
            'iconBg'  => 'rgba(5,150,105,.08)',
            'iconClr' => 'var(--em-500, #10b981)',
            'title'   => trans('main_trans.no_data'),
            'message' => trans('main_trans.no_data_desc'),
        ],
        'no_results' => [
            'icon'    => 'fas fa-magnifying-glass',
            'iconBg'  => 'rgba(99,102,241,.08)',
            'iconClr' => '#6366f1',
            'title'   => trans('main_trans.no_results'),
            'message' => trans('main_trans.no_results_desc'),
        ],
        'error' => [
            'icon'    => 'fas fa-circle-exclamation',
            'iconBg'  => 'rgba(239,68,68,.08)',
            'iconClr' => '#ef4444',
            'title'   => trans('main_trans.toast_error'),
            'message' => trans('main_trans.retry'),
        ],
        'custom' => [
            'icon'    => $icon    ?? 'fas fa-circle-question',
            'iconBg'  => 'rgba(5,150,105,.08)',
            'iconClr' => 'var(--em-500, #10b981)',
            'title'   => '',
            'message' => '',
        ],
    ];

    $cfg = $presets[$esType] ?? $presets['no_data'];

    if ($icon ?? null)    $cfg['icon']    = $icon;
    if ($esTitle)         $cfg['title']   = $esTitle;
    if ($esMessage)       $cfg['message'] = $esMessage;
@endphp

<div class="es-wrap">
    <div class="es-icon-wrap" style="background:{{ $cfg['iconBg'] }}">
        <i class="{{ $cfg['icon'] }}" style="color:{{ $cfg['iconClr'] }}"></i>
    </div>
    <h6 class="es-title">{{ $cfg['title'] }}</h6>
    @if($cfg['message'])
        <p class="es-message">{{ $cfg['message'] }}</p>
    @endif

    @if($esAction)
        @if($esEvent)
            <button type="button"
                    class="btn es-action-btn"
                    wire:click="$dispatch('{{ $esEvent }}')">
                <i class="fas fa-plus me-2"></i>
                {{ $esAction }}
            </button>
        @elseif($esUrl)
            <a href="{{ $esUrl }}" class="btn es-action-btn">
                <i class="fas fa-plus me-2"></i>
                {{ $esAction }}
            </a>
        @else
            <button type="button" class="btn es-action-btn">
                <i class="fas fa-plus me-2"></i>
                {{ $esAction }}
            </button>
        @endif
    @endif
</div>

<style>
.es-wrap {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; text-align: center;
    padding: 56px 24px;
    font-family: 'Cairo', sans-serif;
}
.es-icon-wrap {
    width: 80px; height: 80px; border-radius: 22px;
    display: flex; align-items: center; justify-content: center;
    font-size: 32px;
    margin-bottom: 20px;
}
.es-title {
    font-size: 1rem; font-weight: 800; color: #1e293b;
    margin-bottom: 6px;
}
.es-message {
    font-size: .85rem; color: #94a3b8; margin-bottom: 22px; max-width: 320px;
}
.es-action-btn {
    background: linear-gradient(135deg, var(--em-600,#059669), var(--em-800,#065f46)) !important;
    color: white !important; border: none !important;
    border-radius: 10px !important;
    padding: 9px 22px !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: .88rem !important; font-weight: 700 !important;
    box-shadow: 0 4px 14px rgba(5,150,105,.3) !important;
    transition: opacity .2s !important;
}
.es-action-btn:hover { opacity: .88 !important; color: white !important; }
</style>
