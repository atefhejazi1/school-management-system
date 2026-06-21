<style>
/* ══════════════════════════════════════════
   SIDEBAR — Shared Dark Navy / Emerald Theme
   Used by every guard (admin/student/teacher/parent).
   All directions use CSS logical properties
   so the sidebar mirrors in LTR/RTL automatically.
══════════════════════════════════════════ */

/* ── Scrollable nav body ── */
.sb-scroll {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 8px 0 16px;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,.08) transparent;
}
.sb-scroll::-webkit-scrollbar { width: 4px; }
.sb-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 2px; }

/* ── Brand ── */
.sb-brand {
    display: flex; align-items: center; gap: 11px;
    padding: 18px 16px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    background: rgba(0,0,0,.18);
    flex-shrink: 0;
    text-decoration: none;
}
.sb-brand-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: linear-gradient(135deg, var(--em-600, #059669), var(--em-800, #065f46));
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: white;
    box-shadow: 0 4px 12px rgba(5,150,105,.45);
    flex-shrink: 0;
}
.sb-brand-name {
    font-family: 'Cairo', sans-serif;
    font-size: 13.5px; font-weight: 800;
    color: #f1f5f9; display: block; line-height: 1.25;
}
.sb-brand-sub {
    font-family: 'Cairo', sans-serif;
    font-size: 9.5px; color: #475569; display: block; font-weight: 400;
}

/* ── Section label ── */
.sb-label {
    font-family: 'Cairo', sans-serif;
    font-size: 9px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1.6px;
    color: #334155;
    padding: 16px 18px 6px;
    display: block;
}

/* ── Nav list ── */
.sb-list { list-style: none; padding: 0; margin: 0; }
.sb-list li { margin: 1px 8px; }

/* ── Nav link ── */
.sb-link {
    display: flex !important; align-items: center; gap: 10px;
    padding: 9px 12px !important;
    border-radius: 10px !important;
    color: #94a3b8 !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 13px !important; font-weight: 500 !important;
    text-decoration: none !important;
    transition: all .2s ease !important;
    cursor: pointer;
    background: transparent !important;
    border: none !important;
    width: 100%;
    text-align: start !important;
}
.sb-link:hover {
    background: rgba(255,255,255,.06) !important;
    color: #e2e8f0 !important;
}
.sb-link.sb-active {
    background: linear-gradient(135deg, var(--em-800, #065f46), var(--em-600, #059669)) !important;
    color: white !important;
    box-shadow: 0 4px 14px rgba(5,150,105,.3), inset 0 0 0 1px rgba(255,255,255,.1) !important;
}
.sb-link.sb-active .sb-icon { background: rgba(255,255,255,.18) !important; color: white !important; }
.sb-link[aria-expanded="true"] {
    background: rgba(255,255,255,.06) !important;
    color: #e2e8f0 !important;
}

/* ── Icon box ── */
.sb-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: rgba(255,255,255,.06);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; color: #64748b;
    flex-shrink: 0;
    transition: all .2s;
}
.sb-link:hover .sb-icon { background: rgba(255,255,255,.1); color: var(--em-400, #34d399); }

/* ── Text label ── */
.sb-text { flex: 1; line-height: 1; }

/* ── Arrow chevron — logical transform for RTL/LTR ── */
.sb-arrow {
    font-size: 10px; color: #475569;
    transition: transform .25s ease;
    margin-inline-start: auto;
}
.sb-link[aria-expanded="true"] .sb-arrow {
    transform: rotate(-90deg);
    color: var(--em-400, #34d399);
}

/* ── Submenu ── */
.sb-submenu {
    list-style: none; padding: 3px 0;
    margin: 2px 8px 3px 0;
    background: rgba(0,0,0,.18);
    border-radius: 10px;
    border-inline-start: 2px solid rgba(5,150,105,.3);
    overflow: hidden;
}
[dir="ltr"] .sb-submenu { margin: 2px 0 3px 8px; }

.sb-submenu li { margin: 1px 5px; }
.sb-submenu a {
    display: flex !important; align-items: center; gap: 8px;
    padding: 8px 13px !important;
    border-radius: 7px !important;
    color: #64748b !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 12px !important; font-weight: 500 !important;
    text-decoration: none !important;
    transition: all .18s ease !important;
}
.sb-submenu a:hover { color: var(--em-400, #34d399) !important; background: rgba(5,150,105,.08) !important; }
.sb-submenu a.sub-active { color: var(--em-400, #34d399) !important; font-weight: 700 !important; }
.sb-submenu a::before {
    content: ''; width: 5px; height: 5px;
    border-radius: 50%; background: #334155;
    flex-shrink: 0; transition: background .2s;
}
.sb-submenu a:hover::before,
.sb-submenu a.sub-active::before { background: var(--em-500, #10b981); }

/* ── Sidebar footer ── */
.sb-footer {
    padding: 12px 14px;
    border-top: 1px solid rgba(255,255,255,.06);
    background: rgba(0,0,0,.18);
    flex-shrink: 0;
}
.sb-user { display: flex; align-items: center; gap: 9px; }
.sb-avatar {
    width: 34px; height: 34px; border-radius: 9px;
    background: linear-gradient(135deg, var(--em-600, #059669), var(--em-800, #065f46));
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: white; font-weight: 800;
    font-family: 'Cairo', sans-serif; flex-shrink: 0;
}
.sb-user-info { flex: 1; min-width: 0; }
.sb-user-name {
    font-family: 'Cairo', sans-serif;
    font-size: 11.5px; font-weight: 700; color: #e2e8f0;
    display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sb-user-role {
    font-family: 'Cairo', sans-serif;
    font-size: 9.5px; color: #475569; display: block;
}
.sb-logout {
    width: 30px; height: 30px; border-radius: 8px;
    background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.18);
    display: flex; align-items: center; justify-content: center;
    color: #ef4444; font-size: 13px; cursor: pointer;
    transition: all .2s; flex-shrink: 0;
}
.sb-logout:hover { background: rgba(239,68,68,.22); color: #ef4444; }

/* ── BS5 offcanvas close button (mobile) ── */
.offcanvas-header { display: none; }
@media (max-width: 991.98px) {
    .offcanvas-header {
        display: flex;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255,255,255,.06);
        background: rgba(0,0,0,.18);
        align-items: center;
        justify-content: space-between;
    }
    .offcanvas-header .btn-close {
        filter: invert(1) brightness(2);
        opacity: .6;
    }
    .offcanvas-header .btn-close:hover { opacity: 1; }
}
</style>
