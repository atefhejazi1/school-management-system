{{--
  Confirmation Modal — Bootstrap 5 + Livewire 3
  Usage from any Livewire component:
    $this->dispatch('confirm-action', [
        'title'    => 'Delete record?',
        'message'  => 'This cannot be undone.',
        'event'    => 'doDelete',
        'params'   => ['id' => $this->recordId],
        'type'     => 'delete',   // 'delete' | 'warning' | 'default'
    ]);
--}}
<div class="modal fade"
     id="confirmActionModal"
     tabindex="-1"
     aria-labelledby="confirmActionModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content cm-card">

            <div class="cm-icon-wrap" id="cmIconWrap">
                <i class="fas fa-trash cm-icon" id="cmIcon"></i>
            </div>

            <div class="modal-body cm-body">
                <h5 class="cm-title" id="confirmActionModalLabel">
                    {{ trans('main_trans.confirm_action') }}
                </h5>
                <p class="cm-message" id="cmMessage">
                    {{ trans('main_trans.confirm_delete') }}
                </p>
                <p class="cm-sub" id="cmSub"></p>
            </div>

            <div class="modal-footer cm-footer">
                <button type="button" class="btn cm-btn-cancel" data-bs-dismiss="modal">
                    {{ trans('main_trans.cancel') }}
                </button>
                <button type="button" class="btn cm-btn-confirm" id="cmConfirmBtn">
                    {{ trans('main_trans.confirm_btn') }}
                </button>
            </div>

        </div>
    </div>
</div>

<style>
.cm-card {
    border: none !important;
    border-radius: 20px !important;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.18) !important;
    font-family: 'Cairo', sans-serif;
}
.cm-icon-wrap {
    display: flex; align-items: center; justify-content: center;
    padding: 32px 24px 8px;
}
.cm-icon {
    width: 64px; height: 64px; border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; line-height: 64px; text-align: center;
    background: rgba(239,68,68,.1); color: #ef4444;
}
.cm-body { text-align: center; padding: 8px 28px 20px !important; border: none !important; }
.cm-title { font-size: 1.05rem; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
.cm-message { font-size: .88rem; color: #475569; margin-bottom: 4px; }
.cm-sub { font-size: .78rem; color: #94a3b8; margin: 0; }
.cm-footer {
    justify-content: center !important;
    padding: 0 28px 28px !important;
    border: none !important;
    gap: 12px;
}
.cm-btn-cancel {
    border: 1px solid #e2e8f0 !important; color: #64748b !important;
    background: #f8fafc !important; border-radius: 10px !important;
    padding: 9px 24px !important; font-family: 'Cairo', sans-serif !important;
    font-size: .88rem !important; font-weight: 600 !important;
    transition: all .2s !important; min-width: 100px;
}
.cm-btn-cancel:hover { background: #f1f5f9 !important; }
.cm-btn-confirm {
    border-radius: 10px !important; padding: 9px 24px !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: .88rem !important; font-weight: 700 !important;
    min-width: 120px;
    background: #ef4444 !important; color: white !important;
    border: none !important; transition: all .2s !important;
}
.cm-btn-confirm:hover { opacity: .88 !important; }
.cm-confirm-warning .cm-icon { background: rgba(245,158,11,.1); color: #d97706; }
.cm-confirm-warning .cm-btn-confirm { background: #d97706 !important; }
.cm-confirm-default .cm-icon { background: rgba(5,150,105,.1); color: var(--em-600,#059669); }
.cm-confirm-default .cm-btn-confirm { background: var(--em-700,#047857) !important; }
</style>

<script>
{{-- NOTE: bootstrap.Modal is initialized inside DOMContentLoaded so that the
     Bootstrap 5 bundle (loaded at bottom of <body>) is guaranteed to exist. --}}
(function () {
    var _pendingEvent  = null;
    var _pendingParams = {};
    var _componentId   = null;
    var _bsModal       = null;  // set inside DOMContentLoaded

    var typeConfig = {
        delete:  { iconClass: 'fas fa-trash',                cardClass: 'cm-confirm-delete'  },
        warning: { iconClass: 'fas fa-triangle-exclamation', cardClass: 'cm-confirm-warning' },
        'default': { iconClass: 'fas fa-circle-question',    cardClass: 'cm-confirm-default' },
    };

    function openConfirm(payload) {
        if (!_bsModal) return;
        var type = payload.type || 'delete';
        var cfg  = typeConfig[type] || typeConfig['default'];

        var card = document.querySelector('#confirmActionModal .cm-card');
        if (card) {
            card.classList.remove('cm-confirm-delete','cm-confirm-warning','cm-confirm-default');
            card.classList.add(cfg.cardClass);
        }

        var icon = document.getElementById('cmIcon');
        if (icon) icon.className = cfg.iconClass + ' cm-icon';

        var title = document.getElementById('confirmActionModalLabel');
        if (title) title.textContent = payload.title || '{{ trans("main_trans.confirm_action") }}';

        var msg = document.getElementById('cmMessage');
        if (msg) msg.textContent = payload.message || '{{ trans("main_trans.confirm_delete") }}';

        var sub = document.getElementById('cmSub');
        if (sub) sub.textContent = payload.sub || '';

        var btn = document.getElementById('cmConfirmBtn');
        if (btn) btn.textContent = payload.confirmLabel || '{{ trans("main_trans.confirm_btn") }}';

        _pendingEvent  = payload.event  || null;
        _pendingParams = payload.params || {};
        _componentId   = payload.componentId || null;

        _bsModal.show();
    }

    // Initialize after Bootstrap 5 bundle is loaded
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('confirmActionModal');
        if (!modal) return;

        _bsModal = new bootstrap.Modal(modal);

        document.getElementById('cmConfirmBtn').addEventListener('click', function () {
            _bsModal.hide();
            if (_pendingEvent) {
                if (_componentId && typeof Livewire !== 'undefined') {
                    Livewire.find(_componentId)?.dispatch(_pendingEvent, _pendingParams);
                } else if (typeof Livewire !== 'undefined') {
                    Livewire.dispatch(_pendingEvent, _pendingParams);
                }
            }
        });
    });

    // Livewire 3 event
    document.addEventListener('livewire:init', function () {
        Livewire.on('confirm-action', function (payload) {
            var ev = Array.isArray(payload) ? payload[0] : payload;
            openConfirm(ev);
        });
    });

    window.openConfirmModal = openConfirm;
})();
</script>
