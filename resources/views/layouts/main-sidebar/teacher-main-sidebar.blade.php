<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/teacher/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{ trans('main_trans.Dashboard') }}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted ps-4 font-medium menu-title">{{ trans('main_trans.Programname') }} </li>

        <!-- الاقسام-->
        <li>
            <a href="{{ route('sections') }}"><i class="fas fa-chalkboard"></i><span
                    class="right-nav-text">{{ trans('Teacher_trans.sidebar_sections') }}</span></a>
        </li>

        <!-- الطلاب-->
        <li>
            <a href="{{ route('student.index') }}"><i class="fas fa-user-graduate"></i><span
                    class="right-nav-text">{{ trans('Teacher_trans.sidebar_students') }}</span></a>
        </li>

        <!-- الاختبارات-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#sections-menu">
                <div class="pull-left"><i class="fas fa-chalkboard"></i><span class="right-nav-text">{{ trans('Teacher_trans.sidebar_quizzes') }}</span>
                </div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="sections-menu" class="collapse" data-parent="#sidebarnav">
                <li><a href="{{ route('quizzes.index') }}">{{ trans('Teacher_trans.sidebar_quizzes_list') }}</a></li>
                <li><a href="#">{{ trans('Teacher_trans.sidebar_questions_list') }}</a></li>
            </ul>

        </li>


        <!-- Online classes-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Onlineclasses-icon">
                <div class="pull-left"><i class="fas fa-video"></i><span
                        class="right-nav-text">{{ trans('main_trans.Onlineclasses') }}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Onlineclasses-icon" class="collapse" data-parent="#sidebarnav">
                <li> <a href="{{ route('online_zoom_classes.index') }}">{{ trans('Teacher_trans.sidebar_online_classes_zoom') }}</a> </li>
            </ul>
        </li>

        <!-- sections-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#sections-menu">
                <div class="pull-left"><i class="fas fa-chalkboard"></i><span class="right-nav-text">{{ trans('Teacher_trans.sidebar_reports') }}</span>
                </div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="sections-menu" class="collapse" data-parent="#sidebarnav">
                <li><a href="{{ route('attendance.report') }}">{{ trans('Teacher_trans.sidebar_attendance_report') }}</a></li>
                <li><a href="#">{{ trans('Teacher_trans.sidebar_exams_report') }}</a></li>
            </ul>

        </li>

      <!-- الملف الشخصي-->
      <li>
        <a href="{{route('profile.show')}}"><i class="fas fa-id-card-alt"></i><span
                class="right-nav-text">{{ trans('Teacher_trans.sidebar_profile') }}</span></a>
    </li>

    </ul>
</div>
