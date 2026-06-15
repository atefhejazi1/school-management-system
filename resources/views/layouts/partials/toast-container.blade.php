{{--
  Toast container — Emerald Green theme
  Supported events (dispatch from Livewire or JS):
    - 'toast-show'          { type: 'success|error|warning|info', message: '...' }
    - Session flash:        session('success'), session('error'), session('warning')
  Position: bottom-end (logical, flips in RTL to bottom-start automatically via BS5 RTL)
--}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9100;">

    {{-- JS-triggered toasts land here --}}
    <div id="toastSlot"></div>

    {{-- Laravel session flash toasts --}}
    @foreach(['success','error','warning','info'] as $type)
        @if(session($type))
            <div class="toast align-items-center text-bg-{{ $type === 'error' ? 'danger' : $type }} border-0 shadow"
                 role="alert" aria-live="assertive" aria-atomic="true"
                 data-bs-autohide="true" data-bs-delay="4500"
                 id="sessionToast{{ ucfirst($type) }}">
                <div class="d-flex">
                    <div class="toast-body fw-semibold" style="font-family:'Cairo',sans-serif;font-size:13px;">
                        @php
                            $icon = match($type) {
                                'success' => 'fas fa-circle-check',
                                'error'   => 'fas fa-circle-xmark',
                                'warning' => 'fas fa-triangle-exclamation',
                                default   => 'fas fa-circle-info',
                            };
                        @endphp
                        <i class="{{ $icon }} me-2"></i>
                        {{ session($type) }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast" aria-label="{{ trans('main_trans.cancel') }}"></button>
                </div>
            </div>
        @endif
    @endforeach

</div>

{{-- Toast template (cloned by JS) --}}
<template id="toastTemplate">
    <div class="toast align-items-center border-0 shadow"
         role="alert" aria-live="assertive" aria-atomic="true"
         data-bs-autohide="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body fw-semibold" style="font-family:'Cairo',sans-serif;font-size:13px;">
                <i class="toast-icon me-2"></i>
                <span class="toast-message"></span>
            </div>
            <button type="button" class="btn-close me-2 m-auto"
                    data-bs-dismiss="toast" aria-label="{{ trans('main_trans.cancel') }}"></button>
        </div>
    </div>
</template>

<style>
.toast {
    min-width: 280px;
    border-radius: 12px !important;
    font-family: 'Cairo', sans-serif;
}
.toast .btn-close-white { filter: brightness(0) invert(1); }
/* Success custom color (emerald) */
.toast.toast-success {
    background: var(--em-700, #047857) !important;
    color: white !important;
}
.toast.toast-success .btn-close { filter: brightness(0) invert(1); }
</style>

<script>
(function () {
    // Show session flash toasts after DOM ready
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="sessionToast"]').forEach(function (el) {
            new bootstrap.Toast(el).show();
        });
    });

    // Map type → Bootstrap bg class and icon
    const typeMap = {
        success: { bg: 'toast-success', icon: 'fas fa-circle-check' },
        error:   { bg: 'text-bg-danger', icon: 'fas fa-circle-xmark' },
        warning: { bg: 'text-bg-warning', icon: 'fas fa-triangle-exclamation' },
        info:    { bg: 'text-bg-primary', icon: 'fas fa-circle-info' },
    };

    function showToast(type, message) {
        const map  = typeMap[type] || typeMap.info;
        const tmpl = document.getElementById('toastTemplate');
        if (!tmpl) return;
        const node  = tmpl.content.cloneNode(true);
        const toast = node.querySelector('.toast');
        toast.classList.add(map.bg);
        toast.querySelector('.toast-icon').className    = map.icon + ' me-2 toast-icon';
        toast.querySelector('.toast-message').textContent = message;
        document.getElementById('toastSlot').appendChild(toast);
        new bootstrap.Toast(toast).show();
        // Clean up after hidden
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    }

    // ── Livewire 3 event listener ──
    document.addEventListener('livewire:init', function () {
        Livewire.on('toast-show', function (payload) {
            const ev = Array.isArray(payload) ? payload[0] : payload;
            showToast(ev.type || 'info', ev.message || '');
        });
    });

    // ── Plain JS fallback: window.showToast('success', 'Done!') ──
    window.showToast = showToast;

    // ── jQuery flash events (legacy) ──
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof $ !== 'undefined') {
            $(document).on('showFlash', function (e, data) {
                showToast(data.type || 'info', data.message || '');
            });
        }
    });
})();
</script>
