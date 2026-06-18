<style>
/* ══════════════════════════════════════════
   ADMIN SIDEBAR — Emerald Green Theme
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

{{-- ── Mobile-only offcanvas header (close button) ── --}}
<div class="offcanvas-header">
    <span class="sb-brand-name" id="adminSidebarLabel">{{ trans('main_trans.main_menu') }}</span>
    <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="{{ trans('main_trans.cancel') }}"></button>
</div>

{{-- ── Brand (desktop) ── --}}
<a href="{{ url('/dashboard') }}" class="sb-brand">
    <div class="sb-brand-icon"><i class="fas fa-graduation-cap"></i></div>
    <div>
        <span class="sb-brand-name">{{ trans('main_trans.Programname') }}</span>
        <span class="sb-brand-sub">School Management System</span>
    </div>
</a>

{{-- ── Scrollable nav ── --}}
<div class="sb-scroll">

    {{-- Dashboard --}}
    <ul class="sb-list mt-1">
        <li>
            <a href="{{ url('/dashboard') }}"
               class="sb-link {{ request()->is('dashboard') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-gauge-high"></i></span>
                <span class="sb-text">{{ trans('main_trans.Dashboard') }}</span>
            </a>
        </li>
    </ul>

    {{-- ── Academic Affairs ── --}}
    <span class="sb-label">{{ trans('main_trans.academic_affairs') }}</span>
    <ul class="sb-list">

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-grades"
                    class="sb-link {{ request()->routeIs('Grades.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Grades.*') ? 'true' : 'false' }}"
                    aria-controls="sub-grades">
                <span class="sb-icon"><i class="fas fa-layer-group"></i></span>
                <span class="sb-text">{{ trans('main_trans.Grades') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Grades.*') ? 'show' : '' }}" id="sub-grades">
                <li><a href="{{ route('Grades.index') }}" class="{{ request()->routeIs('Grades.index') ? 'sub-active' : '' }}">{{ trans('main_trans.Grades_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-classes"
                    class="sb-link {{ request()->routeIs('Classrooms.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Classrooms.*') ? 'true' : 'false' }}"
                    aria-controls="sub-classes">
                <span class="sb-icon"><i class="fas fa-building"></i></span>
                <span class="sb-text">{{ trans('main_trans.classes') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Classrooms.*') ? 'show' : '' }}" id="sub-classes">
                <li><a href="{{ route('Classrooms.index') }}" class="{{ request()->routeIs('Classrooms.index') ? 'sub-active' : '' }}">{{ trans('main_trans.List_classes') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-sections"
                    class="sb-link {{ request()->routeIs('Sections.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Sections.*') ? 'true' : 'false' }}"
                    aria-controls="sub-sections">
                <span class="sb-icon"><i class="fas fa-chalkboard"></i></span>
                <span class="sb-text">{{ trans('main_trans.sections') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Sections.*') ? 'show' : '' }}" id="sub-sections">
                <li><a href="{{ route('Sections.index') }}" class="{{ request()->routeIs('Sections.index') ? 'sub-active' : '' }}">{{ trans('main_trans.List_sections') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-subjects"
                    class="sb-link {{ request()->routeIs('subjects.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('subjects.*') ? 'true' : 'false' }}"
                    aria-controls="sub-subjects">
                <span class="sb-icon"><i class="fas fa-book-open"></i></span>
                <span class="sb-text">{{ trans('main_trans.subjects') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('subjects.*') ? 'show' : '' }}" id="sub-subjects">
                <li><a href="{{ route('subjects.index') }}" class="{{ request()->routeIs('subjects.index') ? 'sub-active' : '' }}">{{ trans('main_trans.subjects_list') }}</a></li>
            </ul>
        </li>

    </ul>

    {{-- ── People ── --}}
    <span class="sb-label">{{ trans('main_trans.people') }}</span>
    <ul class="sb-list">

        <li>
            @php $studActive = request()->routeIs('Students.*') || request()->routeIs('Promotion.*') || request()->routeIs('Graduated.*'); @endphp
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-students"
                    class="sb-link {{ $studActive ? 'sb-active' : '' }}"
                    aria-expanded="{{ $studActive ? 'true' : 'false' }}"
                    aria-controls="sub-students">
                <span class="sb-icon"><i class="fas fa-user-graduate"></i></span>
                <span class="sb-text">{{ trans('main_trans.students') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ $studActive ? 'show' : '' }}" id="sub-students">
                <li><a href="{{ route('Students.create') }}" class="{{ request()->routeIs('Students.create') ? 'sub-active' : '' }}">{{ trans('main_trans.add_student') }}</a></li>
                <li><a href="{{ route('Students.index') }}"  class="{{ request()->routeIs('Students.index')  ? 'sub-active' : '' }}">{{ trans('main_trans.list_students') }}</a></li>
                <li><a href="{{ route('Promotion.index') }}" class="{{ request()->routeIs('Promotion.*')     ? 'sub-active' : '' }}">{{ trans('main_trans.Students_Promotions') }}</a></li>
                <li><a href="{{ route('Graduated.index') }}" class="{{ request()->routeIs('Graduated.*')    ? 'sub-active' : '' }}">{{ trans('main_trans.Graduate_students') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-teachers"
                    class="sb-link {{ request()->routeIs('Teachers.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Teachers.*') ? 'true' : 'false' }}"
                    aria-controls="sub-teachers">
                <span class="sb-icon"><i class="fas fa-chalkboard-user"></i></span>
                <span class="sb-text">{{ trans('main_trans.Teachers') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Teachers.*') ? 'show' : '' }}" id="sub-teachers">
                <li><a href="{{ route('Teachers.index') }}" class="{{ request()->routeIs('Teachers.index') ? 'sub-active' : '' }}">{{ trans('main_trans.List_Teachers') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-parents"
                    class="sb-link {{ request()->is('add_parent') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->is('add_parent') ? 'true' : 'false' }}"
                    aria-controls="sub-parents">
                <span class="sb-icon"><i class="fas fa-user-tie"></i></span>
                <span class="sb-text">{{ trans('main_trans.Parents') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->is('add_parent') ? 'show' : '' }}" id="sub-parents">
                <li><a href="{{ url('add_parent') }}" class="{{ request()->is('add_parent') ? 'sub-active' : '' }}">{{ trans('main_trans.List_Parents') }}</a></li>
            </ul>
        </li>

    </ul>

    {{-- ── Finance ── --}}
    <span class="sb-label">{{ trans('main_trans.finance') }}</span>
    <ul class="sb-list">

        <li>
            @php $finActive = request()->routeIs('Fees.*') || request()->routeIs('Fees_Invoices.*') || request()->routeIs('receipt_students.*') || request()->routeIs('ProcessingFee.*') || request()->routeIs('Payment_students.*'); @endphp
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-accounts"
                    class="sb-link {{ $finActive ? 'sb-active' : '' }}"
                    aria-expanded="{{ $finActive ? 'true' : 'false' }}"
                    aria-controls="sub-accounts">
                <span class="sb-icon"><i class="fas fa-coins"></i></span>
                <span class="sb-text">{{ trans('main_trans.Accounts') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ $finActive ? 'show' : '' }}" id="sub-accounts">
                <li><a href="{{ route('Fees.index') }}"             class="{{ request()->routeIs('Fees.index')             ? 'sub-active' : '' }}">{{ trans('main_trans.fees_title') }}</a></li>
                <li><a href="{{ route('Fees_Invoices.index') }}"    class="{{ request()->routeIs('Fees_Invoices.*')        ? 'sub-active' : '' }}">{{ trans('main_trans.invoices') }}</a></li>
                <li><a href="{{ route('receipt_students.index') }}" class="{{ request()->routeIs('receipt_students.*')    ? 'sub-active' : '' }}">{{ trans('main_trans.receipts') }}</a></li>
                <li><a href="{{ route('ProcessingFee.index') }}"    class="{{ request()->routeIs('ProcessingFee.*')       ? 'sub-active' : '' }}">{{ trans('main_trans.fee_exemptions') }}</a></li>
                <li><a href="{{ route('Payment_students.index') }}" class="{{ request()->routeIs('Payment_students.*')   ? 'sub-active' : '' }}">{{ trans('main_trans.payment_orders') }}</a></li>
            </ul>
        </li>

    </ul>

    {{-- ── Activity & Content ── --}}
    <span class="sb-label">{{ trans('main_trans.activity_content') }}</span>
    <ul class="sb-list">

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-attendance"
                    class="sb-link {{ request()->routeIs('Attendance.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Attendance.*') ? 'true' : 'false' }}"
                    aria-controls="sub-attendance">
                <span class="sb-icon"><i class="fas fa-calendar-check"></i></span>
                <span class="sb-text">{{ trans('main_trans.Attendance') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Attendance.*') ? 'show' : '' }}" id="sub-attendance">
                <li><a href="{{ route('Attendance.index') }}" class="{{ request()->routeIs('Attendance.index') ? 'sub-active' : '' }}">{{ trans('main_trans.attendance_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-quizzes"
                    class="sb-link {{ request()->routeIs('Quizzes.*') || request()->routeIs('questions.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('Quizzes.*') ? 'true' : 'false' }}"
                    aria-controls="sub-quizzes">
                <span class="sb-icon"><i class="fas fa-file-pen"></i></span>
                <span class="sb-text">{{ trans('main_trans.quizzes') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('Quizzes.*') ? 'show' : '' }}" id="sub-quizzes">
                <li><a href="{{ route('Quizzes.index') }}" class="{{ request()->routeIs('Quizzes.index') ? 'sub-active' : '' }}">{{ trans('main_trans.quizzes_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-library"
                    class="sb-link {{ request()->routeIs('library.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('library.*') ? 'true' : 'false' }}"
                    aria-controls="sub-library">
                <span class="sb-icon"><i class="fas fa-book"></i></span>
                <span class="sb-text">{{ trans('main_trans.library') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('library.*') ? 'show' : '' }}" id="sub-library">
                <li><a href="{{ route('library.index') }}" class="{{ request()->routeIs('library.index') ? 'sub-active' : '' }}">{{ trans('main_trans.library_list') }}</a></li>
            </ul>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-online"
                    class="sb-link {{ request()->routeIs('online_classes.*') ? 'sb-active' : '' }}"
                    aria-expanded="{{ request()->routeIs('online_classes.*') ? 'true' : 'false' }}"
                    aria-controls="sub-online">
                <span class="sb-icon"><i class="fas fa-video"></i></span>
                <span class="sb-text">{{ trans('main_trans.Onlineclasses') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu {{ request()->routeIs('online_classes.*') ? 'show' : '' }}" id="sub-online">
                <li><a href="{{ route('online_classes.index') }}" class="{{ request()->routeIs('online_classes.index') ? 'sub-active' : '' }}">{{ trans('main_trans.online_zoom') }}</a></li>
            </ul>
        </li>

    </ul>

    {{-- ── System ── --}}
    <span class="sb-label">{{ trans('main_trans.system_section') }}</span>
    <ul class="sb-list">

        <li>
            <a href="{{ route('settings.index') }}"
               class="sb-link {{ request()->routeIs('settings.*') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-gear"></i></span>
                <span class="sb-text">{{ trans('main_trans.Settings') }}</span>
            </a>
        </li>

        <li>
            <button data-bs-toggle="collapse"
                    data-bs-target="#sub-users"
                    class="sb-link"
                    aria-expanded="false"
                    aria-controls="sub-users">
                <span class="sb-icon"><i class="fas fa-users-cog"></i></span>
                <span class="sb-text">{{ trans('main_trans.Users') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </button>
            <ul class="collapse sb-submenu" id="sub-users">
                <li><a href="#">{{ trans('main_trans.users_mgmt') }}</a></li>
            </ul>
        </li>

    </ul>

</div>{{-- /.sb-scroll --}}

{{-- ── Sidebar Footer ── --}}
<div class="sb-footer">
    <div class="sb-user">
        <div class="sb-avatar">
            {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
        </div>
        <div class="sb-user-info">
            <span class="sb-user-name">{{ auth()->user()->name ?? trans('main_trans.role_admin') }}</span>
            <span class="sb-user-role">{{ trans('main_trans.admin_role_label') }}</span>
        </div>
        <form method="POST" action="{{ route('custom.logout', 'web') }}" style="margin:0">
            @csrf
            <button type="submit" class="sb-logout" title="{{ trans('main_trans.logout') }}">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</div>
