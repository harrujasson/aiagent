<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @if(Auth::user()->role == "1")

                <li id="dashboard" class="">
                    <a href="{{route('admin.dashboard')}}" class="waves-effect">
                        <i class="ti ti-layout-dashboard"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li id="myprofile" class="">
                    <a href="{{route('admin.profile')}}" class="waves-effect">
                        <i class="bx bx-user-pin"></i>
                        <span key="t-dashboards">My Profile</span>
                    </a>
                </li>
                <li id="staff" class="">
                    <a href="{{route('admin.staff.manage')}}" class="waves-effect">
                        <i class="fas fa-users"></i>
                        <span key="t-dashboards">Staff</span>
                    </a>
                </li>
                <li id="task" class="">
                    <a href="{{route('admin.task.manage')}}" class="waves-effect">
                        <i class="ti ti-list-check"></i>
                        <span key="t-dashboards">Tasks</span>
                    </a>
                </li>





                <li id="log" class="">
                    <a href="{{route('admin.log.manage')}}" class="waves-effect">
                        <i class="bx bx-pie-chart"></i>
                        <span key="t-dashboards">Logs</span>
                    </a>
                </li>
                <li id="setting" class="">
                    <a href="{{route('admin.setting.common')}}" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span key="t-dashboards">General Settings</span>
                    </a>
                </li>

                @elseif(Auth::user()->role == "2" && strtolower((string) Auth::user()->role_type) === 'manager')
                <li id="myprofile" class="">
                    <a href="{{route('admin.profile')}}" class="waves-effect">
                        <i class="bx bx-user-pin"></i>
                        <span key="t-dashboards">My Profile</span>
                    </a>
                </li>
                <li id="task" class="">
                    <a href="{{route('admin.task.manage')}}" class="waves-effect">
                        <i class="ti ti-list-check"></i>
                        <span key="t-dashboards">Tasks</span>
                    </a>
                </li>
                @elseif(Auth::user()->role == "2" && strtolower((string) Auth::user()->role_type) === 'staff')

                <li id="dashboard" class="">
                    <a href="{{route('staff.dashboard')}}" class="waves-effect">
                        <i class="ti ti-layout-dashboard"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li id="myprofile" class="">
                    <a href="{{route('staff.profile')}}" class="waves-effect">
                        <i class="bx bx-user-pin"></i>
                        <span key="t-dashboards">My Profile</span>
                    </a>
                </li>
                <li id="task" class="">
                    <a href="{{route('staff.task.manage')}}" class="waves-effect">
                        <i class="ti ti-list-check"></i>
                        <span key="t-dashboards">My Tasks</span>
                    </a>
                </li>
            @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
