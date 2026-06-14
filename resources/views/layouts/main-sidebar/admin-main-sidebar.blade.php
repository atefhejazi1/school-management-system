<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ══════════════════════════════════════════
   ADMIN SIDEBAR — Complete Redesign
   ══════════════════════════════════════════ */

/* Override the template's side-menu-fixed */
.side-menu-fixed {
    width: 265px !important;
    background: linear-gradient(180deg, #0f172a 0%, #1a2744 100%) !important;
    border: none !important;
    box-shadow: 4px 0 24px rgba(0,0,0,0.4) !important;
    display: flex !important;
    flex-direction: column !important;
    overflow: hidden !important;
}

/* ── Brand Section ── */
.sb-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px 18px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    background: rgba(0,0,0,0.2);
    flex-shrink: 0;
}

.sb-brand-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: white;
    box-shadow: 0 4px 12px rgba(59,130,246,0.4);
    flex-shrink: 0;
}

.sb-brand-text { flex: 1; min-width: 0; }
.sb-brand-name {
    font-family: 'Cairo', sans-serif;
    font-size: 14px; font-weight: 800;
    color: #f1f5f9;
    display: block; line-height: 1.3;
}
.sb-brand-sub {
    font-family: 'Cairo', sans-serif;
    font-size: 10px; color: #64748b; font-weight: 400;
    display: block;
}

/* ── Scrollable nav body ── */
.sb-scroll {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 10px 0 16px;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.08) transparent;
}

.sb-scroll::-webkit-scrollbar { width: 4px; }
.sb-scroll::-webkit-scrollbar-track { background: transparent; }
.sb-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

/* ── Section labels ── */
.sb-label {
    font-family: 'Cairo', sans-serif;
    font-size: 9.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.4px;
    color: #475569;
    padding: 18px 20px 7px;
    display: block;
}

/* ── Nav list & items ── */
.sb-list { list-style: none; padding: 0; margin: 0; }
.sb-list li { margin: 1px 10px; }

/* Top-level nav link */
.sb-link {
    display: flex !important;
    align-items: center;
    gap: 11px;
    padding: 10px 14px !important;
    border-radius: 10px !important;
    color: #94a3b8 !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    position: relative;
    cursor: pointer;
    background: transparent !important;
    border: none !important;
}

.sb-link:hover {
    background: rgba(255,255,255,0.06) !important;
    color: #e2e8f0 !important;
}

.sb-link.sb-active {
    background: linear-gradient(135deg, #1d4ed8, #2563eb) !important;
    color: white !important;
    box-shadow: 0 4px 14px rgba(37,99,235,0.35), inset -3px 0 0 rgba(255,255,255,0.25) !important;
}

.sb-link.sb-active .sb-icon { color: white !important; }
.sb-link.sb-active .sb-arrow { color: rgba(255,255,255,0.6) !important; }

/* Has-submenu open state */
.sb-link[aria-expanded="true"] {
    background: rgba(255,255,255,0.06) !important;
    color: #e2e8f0 !important;
}

/* ── Icon ── */
.sb-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(255,255,255,0.06);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    color: #64748b;
    flex-shrink: 0;
    transition: all 0.2s ease;
}

.sb-link:hover .sb-icon {
    background: rgba(255,255,255,0.1);
    color: #93c5fd;
}

.sb-link.sb-active .sb-icon {
    background: rgba(255,255,255,0.2);
    color: white;
}

/* ── Label text ── */
.sb-text {
    flex: 1;
    line-height: 1;
}

/* ── Arrow chevron ── */
.sb-arrow {
    font-size: 10px;
    color: #475569;
    transition: transform 0.25s ease;
    margin-right: auto;
}

.sb-link[aria-expanded="true"] .sb-arrow {
    transform: rotate(-90deg);
    color: #93c5fd;
}

/* ── Submenu ── */
.sb-submenu {
    list-style: none;
    padding: 4px 0;
    margin: 3px 10px 4px 0;
    background: rgba(0,0,0,0.2);
    border-radius: 10px;
    border-right: 2px solid rgba(59,130,246,0.25);
    overflow: hidden;
}

.sb-submenu li { margin: 1px 6px; }

.sb-submenu a {
    display: flex !important;
    align-items: center;
    gap: 8px;
    padding: 8px 14px !important;
    border-radius: 7px !important;
    color: #64748b !important;
    font-family: 'Cairo', sans-serif !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    text-decoration: none !important;
    transition: all 0.18s ease !important;
}

.sb-submenu a:hover {
    color: #93c5fd !important;
    background: rgba(59,130,246,0.1) !important;
}

.sb-submenu a::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    background: #334155;
    flex-shrink: 0;
    transition: background 0.2s;
}

.sb-submenu a:hover::before { background: #3b82f6; }

/* ── Sidebar footer ── */
.sb-footer {
    padding: 14px 16px;
    border-top: 1px solid rgba(255,255,255,0.06);
    background: rgba(0,0,0,0.2);
    flex-shrink: 0;
}

.sb-user {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sb-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: white; font-weight: 700;
    font-family: 'Cairo', sans-serif;
    flex-shrink: 0;
}

.sb-user-info { flex: 1; min-width: 0; }
.sb-user-name {
    font-family: 'Cairo', sans-serif;
    font-size: 12px; font-weight: 700;
    color: #e2e8f0; display: block;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sb-user-role {
    font-family: 'Cairo', sans-serif;
    font-size: 10px; color: #475569; display: block;
}

.sb-logout {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.2);
    display: flex; align-items: center; justify-content: center;
    color: #ef4444; font-size: 13px;
    cursor: pointer; text-decoration: none;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.sb-logout:hover {
    background: rgba(239,68,68,0.2);
    color: #ef4444;
}

/* Override the old scrollbar div */
.scrollbar.side-menu-bg {
    display: contents !important;
}

/* Hide old nav ul */
.nav.navbar-nav.side-menu { display: none !important; }

/* ── Content wrapper margin override ── */
@media (min-width: 992px) {
    .content-wrapper {
        margin-right: 265px !important;
    }
}
</style>

<!-- ══ Brand ══ -->
<div class="sb-brand">
    <div class="sb-brand-icon">
        <i class="fas fa-graduation-cap"></i>
    </div>
    <div class="sb-brand-text">
        <span class="sb-brand-name">إدارة المدارس</span>
        <span class="sb-brand-sub">School Management System</span>
    </div>
</div>

<!-- ══ Scrollable navigation ══ -->
<div class="sb-scroll">

    <!-- Dashboard -->
    <ul class="sb-list">
        <li>
            <a href="{{ url('/dashboard') }}" class="sb-link {{ request()->is('dashboard') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-th-large"></i></span>
                <span class="sb-text">{{ trans('main_trans.Dashboard') }}</span>
            </a>
        </li>
    </ul>

    <!-- ── Academic ── -->
    <span class="sb-label">الشؤون الأكاديمية</span>
    <ul class="sb-list">

        <!-- Grades -->
        <li>
            <a href="#sub-grades" data-toggle="collapse" class="sb-link {{ request()->routeIs('Grades.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('Grades.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-layer-group"></i></span>
                <span class="sb-text">{{ trans('main_trans.Grades') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('Grades.*') ? 'show' : '' }}" id="sub-grades">
                <li><a href="{{ route('Grades.index') }}">{{ trans('main_trans.Grades_list') }}</a></li>
            </ul>
        </li>

        <!-- Classes -->
        <li>
            <a href="#sub-classes" data-toggle="collapse" class="sb-link {{ request()->routeIs('Classrooms.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('Classrooms.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-building"></i></span>
                <span class="sb-text">{{ trans('main_trans.classes') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('Classrooms.*') ? 'show' : '' }}" id="sub-classes">
                <li><a href="{{ route('Classrooms.index') }}">{{ trans('main_trans.List_classes') }}</a></li>
            </ul>
        </li>

        <!-- Sections -->
        <li>
            <a href="#sub-sections" data-toggle="collapse" class="sb-link {{ request()->routeIs('Sections.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('Sections.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-chalkboard"></i></span>
                <span class="sb-text">{{ trans('main_trans.sections') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('Sections.*') ? 'show' : '' }}" id="sub-sections">
                <li><a href="{{ route('Sections.index') }}">{{ trans('main_trans.List_sections') }}</a></li>
            </ul>
        </li>

        <!-- Subjects -->
        <li>
            <a href="#sub-subjects" data-toggle="collapse" class="sb-link {{ request()->routeIs('subjects.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('subjects.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-book-open"></i></span>
                <span class="sb-text">المواد الدراسية</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('subjects.*') ? 'show' : '' }}" id="sub-subjects">
                <li><a href="{{ route('subjects.index') }}">قائمة المواد</a></li>
            </ul>
        </li>

    </ul>

    <!-- ── People ── -->
    <span class="sb-label">المستخدمون</span>
    <ul class="sb-list">

        <!-- Students -->
        <li>
            <a href="#sub-students" data-toggle="collapse" class="sb-link {{ request()->routeIs('Students.*') || request()->routeIs('Promotion.*') || request()->routeIs('Graduated.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('Students.*') || request()->routeIs('Promotion.*') || request()->routeIs('Graduated.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-user-graduate"></i></span>
                <span class="sb-text">{{ trans('main_trans.students') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('Students.*') ? 'show' : '' }}" id="sub-students">
                <li><a href="{{ route('Students.create') }}">{{ trans('main_trans.add_student') }}</a></li>
                <li><a href="{{ route('Students.index') }}">{{ trans('main_trans.list_students') }}</a></li>
                <li><a href="{{ route('Promotion.index') }}">{{ trans('main_trans.Students_Promotions') }}</a></li>
                <li><a href="{{ route('Graduated.index') }}">{{ trans('main_trans.Graduate_students') }}</a></li>
            </ul>
        </li>

        <!-- Teachers -->
        <li>
            <a href="#sub-teachers" data-toggle="collapse" class="sb-link {{ request()->routeIs('Teachers.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('Teachers.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-chalkboard-user"></i></span>
                <span class="sb-text">{{ trans('main_trans.Teachers') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('Teachers.*') ? 'show' : '' }}" id="sub-teachers">
                <li><a href="{{ route('Teachers.index') }}">{{ trans('main_trans.List_Teachers') }}</a></li>
            </ul>
        </li>

        <!-- Parents -->
        <li>
            <a href="#sub-parents" data-toggle="collapse" class="sb-link {{ request()->routeIs('add_parent') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('add_parent') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-user-tie"></i></span>
                <span class="sb-text">{{ trans('main_trans.Parents') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('add_parent') ? 'show' : '' }}" id="sub-parents">
                <li><a href="{{ url('add_parent') }}">{{ trans('main_trans.List_Parents') }}</a></li>
            </ul>
        </li>

    </ul>

    <!-- ── Finance ── -->
    <span class="sb-label">المالية</span>
    <ul class="sb-list">

        <li>
            <a href="#sub-accounts" data-toggle="collapse" class="sb-link {{ request()->routeIs('Fees.*') || request()->routeIs('Fees_Invoices.*') || request()->routeIs('receipt_students.*') || request()->routeIs('ProcessingFee.*') || request()->routeIs('Payment_students.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('Fees.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-coins"></i></span>
                <span class="sb-text">{{ trans('main_trans.Accounts') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('Fees.*') || request()->routeIs('Fees_Invoices.*') ? 'show' : '' }}" id="sub-accounts">
                <li><a href="{{ route('Fees.index') }}">الرسوم الدراسية</a></li>
                <li><a href="{{ route('Fees_Invoices.index') }}">الفواتير</a></li>
                <li><a href="{{ route('receipt_students.index') }}">سندات القبض</a></li>
                <li><a href="{{ route('ProcessingFee.index') }}">استبعاد رسوم</a></li>
                <li><a href="{{ route('Payment_students.index') }}">سندات الصرف</a></li>
            </ul>
        </li>

    </ul>

    <!-- ── Activity & Content ── -->
    <span class="sb-label">النشاط والمحتوى</span>
    <ul class="sb-list">

        <!-- Attendance -->
        <li>
            <a href="#sub-attendance" data-toggle="collapse" class="sb-link {{ request()->routeIs('Attendance.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('Attendance.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-calendar-check"></i></span>
                <span class="sb-text">{{ trans('main_trans.Attendance') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('Attendance.*') ? 'show' : '' }}" id="sub-attendance">
                <li><a href="{{ route('Attendance.index') }}">قائمة الطلاب</a></li>
            </ul>
        </li>

        <!-- Quizzes -->
        <li>
            <a href="#sub-quizzes" data-toggle="collapse" class="sb-link {{ request()->routeIs('Quizzes.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('Quizzes.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-file-pen"></i></span>
                <span class="sb-text">الاختبارات</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('Quizzes.*') ? 'show' : '' }}" id="sub-quizzes">
                <li><a href="{{ route('Quizzes.index') }}">قائمة الاختبارات</a></li>
            </ul>
        </li>

        <!-- Library -->
        <li>
            <a href="#sub-library" data-toggle="collapse" class="sb-link {{ request()->routeIs('library.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('library.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-book"></i></span>
                <span class="sb-text">{{ trans('main_trans.library') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('library.*') ? 'show' : '' }}" id="sub-library">
                <li><a href="{{ route('library.index') }}">قائمة الكتب</a></li>
            </ul>
        </li>

        <!-- Online Classes -->
        <li>
            <a href="#sub-online" data-toggle="collapse" class="sb-link {{ request()->routeIs('online_classes.*') ? 'sb-active' : '' }}" aria-expanded="{{ request()->routeIs('online_classes.*') ? 'true' : 'false' }}">
                <span class="sb-icon"><i class="fas fa-video"></i></span>
                <span class="sb-text">{{ trans('main_trans.Onlineclasses') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu {{ request()->routeIs('online_classes.*') ? 'show' : '' }}" id="sub-online">
                <li><a href="{{ route('online_classes.index') }}">حصص أونلاين — Zoom</a></li>
            </ul>
        </li>

    </ul>

    <!-- ── System ── -->
    <span class="sb-label">النظام</span>
    <ul class="sb-list">

        <li>
            <a href="{{ route('settings.index') }}" class="sb-link {{ request()->routeIs('settings.*') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-gear"></i></span>
                <span class="sb-text">{{ trans('main_trans.Settings') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.registrations.index') }}" class="sb-link {{ request()->routeIs('admin.registrations.*') ? 'sb-active' : '' }}">
                <span class="sb-icon"><i class="fas fa-clipboard-list"></i></span>
                <span class="sb-text">طلبات التسجيل</span>
                @php $__pendingReg = \App\Models\SchoolRegistration::pending()->count(); @endphp
                @if ($__pendingReg > 0)
                    <span style="margin-right:auto; background:#ef4444; color:white; font-size:10px; font-weight:700; padding:2px 7px; border-radius:50px; line-height:1.6;">
                        {{ $__pendingReg }}
                    </span>
                @endif
            </a>
        </li>

        <li>
            <a href="#sub-users" data-toggle="collapse" class="sb-link" aria-expanded="false">
                <span class="sb-icon"><i class="fas fa-users-cog"></i></span>
                <span class="sb-text">{{ trans('main_trans.Users') }}</span>
                <i class="fas fa-chevron-left sb-arrow"></i>
            </a>
            <ul class="collapse sb-submenu" id="sub-users">
                <li><a href="#">إدارة المستخدمين</a></li>
            </ul>
        </li>

    </ul>

</div>

<!-- ══ Sidebar Footer (user info + logout) ══ -->
<div class="sb-footer">
    <div class="sb-user">
        <div class="sb-avatar">
            {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
        </div>
        <div class="sb-user-info">
            <span class="sb-user-name">{{ auth()->user()->name ?? 'المسؤول' }}</span>
            <span class="sb-user-role">مسؤول النظام</span>
        </div>
        <form method="POST" action="{{ route('custom.logout', 'web') }}" style="margin:0">
            @csrf
            <button type="submit" class="sb-logout" title="تسجيل الخروج">
                <i class="fas fa-right-from-bracket"></i>
            </button>
        </form>
    </div>
</div>
