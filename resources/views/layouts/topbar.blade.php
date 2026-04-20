<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex header-left ">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{url('/')}}" class="logo logo-dark">
                    <span class="logo-sm ">

                    @if(getSettingInfo('logo_sm')!="")
                    <img src="{{ URL::asset('uploads/settings/'.getSettingInfo('logo_sm')) }}" height="22" />
                    
                    @endif
                    </span>
                    <span class="logo-lg">
                    @if(getSettingInfo('logo')!="")
                    <img src="{{ URL::asset('uploads/settings/'.getSettingInfo('logo')) }}" alt="Logo" height="19">
                    @endif
                    </span>
                </a>

                <a href="{{url('/')}}" class="logo logo-light">
                    <span class="logo-sm">
                        @if(getSettingInfo('logo_sm')!="")
                        <img src="{{ URL::asset('uploads/settings/'.getSettingInfo('logo_sm')) }}" height="22" />
                        @endif
                    </span>
                    <span class="logo-lg">
                    @if(getSettingInfo('logo')!="")
                    <img src="{{ URL::asset('uploads/settings/'.getSettingInfo('logo')) }}" alt="Logo" height="19">
                        
                    @endif
                    </span>
                </a>
            </div>

            <button type="button"  class="btn btn-sm px-3 font-size-16 header-item waves-effect " id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
    </div>

    <div class="d-flex header-right">
        
    {{notification_update()}}
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bx bx-bell bx-tada"></i>
                <span class="badge bg-danger rounded-pill">{{getSystemSendNotification(Auth::id(),'1')}}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                aria-labelledby="page-header-notifications-dropdown">
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-0" key="t-notifications"> Notifications </h6>
                        </div>
                    </div>
                </div>
                <div data-simplebar style="max-height: 230px;">
                    @php $list_notification = getSystemSendNotification(Auth::id()); @endphp
                    @if(!empty($list_notification))
                    @foreach($list_notification as $noti)
                    <a href="{{$noti->link}}?notification_status={{$noti->id}}" class="text-reset notification-item">
                        <div class="d-flex">
                            
                            <div class="flex-grow-1">
                                <h6 class="mb-1" key="t-your-order">{{$noti->title}}</h6>
                                <div class="font-size-12 text-muted">
                                    <p class="mb-1" key="t-grammer">{{$noti->description}}</p>
                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">{{timeAgo($noti->created_at)}}</span></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    @endif
                    
                    
                </div>
                
            </div>
        </div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <img class="rounded-circle header-profile-user" src="{{ Auth::user()->picture !="" ? asset( 'uploads/profile/'. Auth::user()->picture) : asset('build/images/users/blank.png') }}"
                    alt="Header Avatar">


                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ucfirst(Auth::user()->name .' '.Auth::user()->last_name )}}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>

            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
</header>




