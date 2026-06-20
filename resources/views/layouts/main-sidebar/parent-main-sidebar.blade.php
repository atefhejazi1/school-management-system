<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ route('parent.dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{ trans('main_trans.Dashboard') }}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>
        <!-- menu title -->
        <li class="mt-10 mb-10 text-muted ps-4 font-medium menu-title">{{ trans('main_trans.Programname') }} </li>


        <!-- الابناء-->
        <li>
            <a href="{{ route('sons.index') }}"><i class="fas fa-book-open"></i><span
                    class="right-nav-text">{{ trans('Parent_trans.sidebar_children') }}</span></a>
        </li>

        <!-- تقرير الحضور والغياب-->
        <li>
            <a href="{{route('sons.attendances')}}"><i class="fas fa-book-open"></i><span
                    class="right-nav-text">{{ trans('Parent_trans.sidebar_attendance_report') }}</span></a>
        </li>


        <!-- تقرير المالية-->
        <li>
            <a href="{{route('sons.fees')}}"><i class="fas fa-book-open"></i><span
                    class="right-nav-text">{{ trans('Parent_trans.sidebar_financial_report') }}</span></a>
        </li>


        <!-- Settings-->
        <li>
            <a href="{{route('profile.show.parent')}}"><i class="fas fa-id-card-alt"></i><span
                    class="right-nav-text">{{ trans('Parent_trans.sidebar_profile') }}</span></a>
        </li>

    </ul>
</div>
