<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ \Session::get('app.title') }} :: @yield('title')</title>
        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset(Session::get('app.favicon')) }}" type="image/x-icon" />
        <!-- template bootstrap -->
        <link href="{{ asset('public/assets/css/template.min.css') }}" rel='stylesheet prefetch'>
        <!-- roboto -->
        <link href="{{ asset('public/assets/css/roboto.css') }}" rel='stylesheet'>
        <!-- material-design -->
        <link href="{{ asset('public/assets/css/material-design.css') }}" rel='stylesheet'>
        <!-- small-n-flat -->
        <link href="{{ asset('public/assets/css/small-n-flat.css') }}" rel='stylesheet'>
        <!-- font-awesome -->
        <link href="{{ asset('public/assets/css/font-awesome.min.css') }}" rel='stylesheet'>
        <!-- jquery-ui -->
        <link href="{{ asset('public/assets/css/jquery-ui.min.css') }}" rel='stylesheet'>
        <!-- datatable -->
        <link href="{{ asset('public/assets/css/dataTables.min.css') }}" rel='stylesheet'>
        <!-- select2 -->
        <link href="{{ asset('public/assets/css/select2.min.css') }}"  rel='stylesheet'>
        <!-- custom style -->
        <link href="{{ asset('public/assets/css/style.css') }}" rel='stylesheet'>
        <!-- Page styles --> 
        @stack('styles')


        <!-- Jquery  -->
        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    </head>
    <body class="cm-no-transition cm-1-navbar loader-process">
        @include('backend.common.info')

        <div class="loader">
            <div>
                <span>G</span>
                <span>O</span>
                <span></span>
                <span>K</span>
                <span>I</span>
                <span>I</span>
                <span>W</span>
                {{-- <span></span> --}}
                {{-- <span>K</span>
                <span>E</span>
                <span>R</span>
                <span>N</span>
                <span>E</span>
                <span>L</span> --}}
            </div>
        </div>

        <!-- Starts of Sidebar -->
        <div id="cm-menu">
            <nav class="cm-navbar cm-navbar-primary">
                <div class="cm-flex"><a href="javascript:void(0)">
                    <img src="{{ asset(\Session::get('app.logo') ?? 'd/your-logo.png') }}" width="210" height="50">
                </a></div>
                <div class="btn btn-primary md-menu-white" data-toggle="cm-menu"></div>
            </nav>
            <div id="cm-menu-content">
                <div id="cm-menu-items-wrapper">
                    <div id="cm-menu-scroller">
                        <ul class="cm-menu-items">
                            <!-- // ADMIN MENU -->
                            {{-- @if(Auth::user()->hasRole('admin')) --}}
                            <li class="{{ ((Request::is('admin')) ? 'active' : '') }}">
                                <a href="{{ url('admin') }}" class="sf-dashboard">
                                    {{ trans('app.dashboard') }}
                                </a>
                            </li>

                            @if(issetAccess(auth()->user()->user_role_id)->location['read'] || issetAccess(auth()->user()->user_role_id)->location['write'])
                            <li class="cm-submenu {{ (Request::segment(2)=='location' ? 'open' : '') }}">
                                <a class="sf-carton">{{ trans('app.department') }} <span class="caret"></span></a>
                                <ul>
                                    @if (issetAccess(auth()->user()->user_role_id)->location['write'])
                                    <li class="{{ (Request::is('admin/location/create') ? 'active' : '') }}">
                                        <a href="{{ url('admin/location/create') }}">{{ trans('app.add_department') }}</a>
                                    </li>
                                    @endif

                                    @if (issetAccess(auth()->user()->user_role_id)->location['read'])
                                    <li class="{{ (Request::is('admin/location') ? 'active' : '') }}">
                                        <a href="{{ url('admin/location') }}">{{ trans('app.department_list') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li> 
                            @endif

                            {{-- Section --}}
                            @if(issetAccess(auth()->user()->user_role_id)->section['read'] || issetAccess(auth()->user()->user_role_id)->section['write'])
                            <li class="cm-submenu {{ (Request::segment(2)=='section' ? 'open' : '') }}">
                                <a class="sf-carton">{{ trans('Section') }} <span class="caret"></span></a>
                                <ul>
                                    @if (issetAccess(auth()->user()->user_role_id)->section['write'])
                                    <li class="{{ (Request::is('admin/section/create') ? 'active' : '') }}">
                                        <a href="{{ url('admin/section/create') }}">{{ trans('Add Section') }}</a>
                                    </li>
                                    @endif

                                    @if (issetAccess(auth()->user()->user_role_id)->section['read'])
                                    <li class="{{ (Request::is('admin/section') ? 'active' : '') }}">
                                        <a href="{{ url('admin/section') }}">{{ trans('Section List') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li> 
                            @endif

                            {{-- Counter --}}
                            @if(issetAccess(auth()->user()->user_role_id)->counter['read'] || issetAccess(auth()->user()->user_role_id)->counter['write'])
                            <li class="cm-submenu {{ (Request::segment(2)=='counter' ? 'open' : '') }}">
                                <a class="sf-star">{{ trans('app.counter') }} <span class="caret"></span></a>
                                <ul>
                                    @if(issetAccess(auth()->user()->user_role_id)->counter['write'])
                                    <li class="{{ (Request::is('admin/counter/create') ? 'active' : '') }}">
                                        <a href="{{ url('admin/counter/create') }}">{{ trans('app.add_counter') }}</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->counter['read'])
                                    <li class="{{ (Request::is('admin/counter') ? 'active' : '') }}">
                                        <a href="{{ url('admin/counter') }}">{{ trans('app.counter_list') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif 

                            {{-- user type --}}
                            @if(issetAccess(auth()->user()->user_role_id)->user_type['read'] || issetAccess(auth()->user()->user_role_id)->user_type['write'])
                            <li class="cm-submenu {{ (Request::segment(2)=='user-type' ? 'open' : '') }}">
                                <a class="sf-profile-group">{{ trans('User Type') }} <span class="caret"></span></a>
                                <ul>
                                    @if(issetAccess(auth()->user()->user_role_id)->user_type['write'])
                                    <li class="{{ (Request::is('admin/user-type/create') ? 'active' : '') }}">
                                        <a href="{{ url('admin/user-type/create') }}">{{ trans('New User Type') }}</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->counter['read'])
                                    <li class="{{ (Request::is('admin/user-type') ? 'active' : '') }}">
                                        <a href="{{ url('admin/user-type') }}">{{ trans('User type List') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            {{-- user --}}
                            @if(issetAccess(auth()->user()->user_role_id)->users['read'] || issetAccess(auth()->user()->user_role_id)->user['write'])
                            <li class="cm-submenu {{ (Request::segment(2)=='user' ? 'open' : '') }}">
                                <a class="sf-profile-group">{{ trans('app.users') }} <span class="caret"></span></a>
                                <ul>
                                    @if(issetAccess(auth()->user()->user_role_id)->users['write'])
                                    <li class="{{ (Request::is('admin/user/create') ? 'active' : '') }}">
                                        <a href="{{ url('admin/user/create') }}">{{ trans('app.add_user') }}</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->users['read'])
                                    <li class="{{ (Request::is('admin/user') ? 'active' : '') }}">
                                        <a href="{{ url('admin/user') }}">{{ trans('app.user_list') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li> 
                            @endif

                            {{-- SMS --}}
                            @if(issetAccess(auth()->user()->user_role_id)->sms['read'] || issetAccess(auth()->user()->user_role_id)->sms['write'])
                            <li class="cm-submenu {{ (Request::segment(2)=='sms' ? 'open' : '') }}">
                                <a class="sf-bubbles">{{ trans('app.sms') }} <span class="caret"></span></a>
                                <ul>
                                    @if(issetAccess(auth()->user()->user_role_id)->sms['write'])
                                    <li class="{{ (Request::is('admin/sms/new') ? 'active' : '') }}">
                                        <a href="{{ url('admin/sms/new') }}">{{ trans('app.new_sms') }}</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->sms['read'])
                                    <li class="{{ (Request::is('admin/sms/list') ? 'active' : '') }}">
                                        <a href="{{ url('admin/sms/list') }}">{{ trans('app.sms_history') }}</a>
                                    </li>
                                    @endif
                                    {{-- <li class="bg-danger {{ (Request::is('admin/sms/setting') ? 'active' : '') }}">
                                        <a href="{{ url('admin/sms/setting') }}">{{ trans('app.sms_setting') }}</a>
                                    </li> --}}
                                </ul>
                            </li> 
                            @endif

                            {{-- token --}}
                            <li class="cm-submenu {{ (Request::segment(2)=='token' ? 'open' : '') }}">
                                <a class="sf-user-id">{{ trans('app.token') }} <span class="caret"></span></a>
                                <ul>
                                    @if(issetAccess(auth()->user()->user_role_id)->token['auto_token'])
                                    <li class="{{ (Request::is('admin/token/list') ? 'active' : '') }}">
                                        <a href="{{ url('admin/token/auto') }}">{{ trans('app.auto_token') }}</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->token['manual_token'])
                                    <li class="{{ (Request::is('admin/token/create') ? 'active' : '') }}">
                                        <a href="{{ url('admin/token/create') }}">{{ trans('app.manual_token') }}</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->token['active_token']['all_token'] || issetAccess(auth()->user()->user_role_id)->token['active_token']['own_token'])
                                    <li class="{{ (Request::is('admin/token/current') ? 'active' : '') }}">
                                        <a href="{{ url('admin/token/current') }}">{{ trans('app.active') }} / {{ trans('app.todays_token') }} <i class="fa fa-dot-circle-o" style="color:#03d003"></i></a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->token['token_report']['read'] || issetAccess(auth()->user()->user_role_id)->token['token_report']['write'])
                                    <li class="{{ (Request::is('admin/token/report') ? 'active' : '') }}">
                                        <a href="{{ url('admin/token/report') }}">{{ trans('app.token_report') }}</a>
                                    </li> 
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->token['performance_report'])
                                    <li class="{{ (Request::is('admin/token/performance') ? 'active' : '') }}">
                                        <a href="{{ url('admin/token/performance') }}">{{ trans('app.performance_report') }}</a>
                                    </li> 
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->token['auto_token_setting'])
                                    <li class="bg-danger {{ (Request::is('admin/token/setting') ? 'active' : '') }}">
                                        <a href="{{ url('admin/token/setting') }}">{{ trans('app.auto_token_setting') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>  
                            {{-- @endif --}}

                            <!-------------------------------------------------------->
                            <!-- OFFICER MENU                                       -->
                            <!-------------------------------------------------------->
                            {{-- @if(Auth::user()->hasRole('officer'))  
                            <li class="{{ ((Request::is('officer')) ? 'active' : '') }}">
                                <a href="{{ url('officer') }}" class="sf-dashboard">
                                    {{ trans('app.dashboard') }} 
                                </a>
                            </li>
 

                            <li class="cm-submenu {{ (Request::segment(2)=='token' ? 'open' : '') }}">
                                <a class="sf-user-id">{{ trans('app.token') }} <span class="caret"></span></a>
                                <ul> 
                                    <li class="{{ (Request::is('officer/token/current') ? 'active' : '') }}">
                                        <a href="{{ url('officer/token/current') }}">{{ trans('app.active') }} / {{ trans('app.todays_token') }} <i class="fa fa-dot-circle-o" style="color:#03d003"></i></a>
                                    </li>
                                    <li class="{{ (Request::is('officer/token') ? 'active' : '') }}">
                                        <a href="{{ url('officer/token') }}">{{ trans('app.token_list') }}</a>
                                    </li> 
                                </ul>
                            </li>  
                            @endif --}}

                            <!-------------------------------------------------------->
                            <!-- RECEPTIONIST MENU                               -->
                            <!-------------------------------------------------------->
                            {{-- @if(Auth::user()->hasRole('receptionist'))  
                            <li class="cm-submenu {{ ((Request::is('receptionist') || Request::segment(2)=='token') ? 'open' : '') }}">
                                <a class="sf-user-id">{{ trans('app.token') }} <span class="caret"></span></a>
                                <ul>
                                    <li class="{{ (Request::is('receptionist/token/list') ? 'active' : '') }}">
                                        <a href="{{ url('receptionist/token/auto') }}">{{ trans('app.auto_token') }}</a>
                                    </li>
                                    <li class="{{ (Request::is('receptionist/token/create') ? 'active' : '') }}">
                                        <a href="{{ url('receptionist/token/create') }}">{{ trans('app.manual_token') }}</a>
                                    </li>
                                    <li class="{{ (Request::is('receptionist/token/current') ? 'active' : '') }}">
                                        <a href="{{ url('receptionist/token/current') }}">{{ trans('app.active') }} / {{ trans('app.todays_token') }} <i class="fa fa-dot-circle-o" style="color:#03d003"></i></a>
                                    </li> 
                                </ul>
                            </li> 
                            @endif --}}

 
                            <!-------------------------------------------------------->
                            <!-- COMMON MENU                                        -->
                            <!-------------------------------------------------------->
                            @if(issetAccess(auth()->user()->user_role_id)->display)
                            <li class="cm-submenu {{ (Request::segment(2)=='display' ? 'open' : '') }}">
                                <a target="_blank" class="sf-device-tablet">
                                    {{ trans('app.display') }} 
                                    <span class="caret"></span>
                                </a>
                                <ul>
                                    <li class="{{ (session()->get('app.display')==1 ? 'active' : '') }}">
                                        <a href="{{ url('common/location') }}">{{ trans('app.display_1') }}</a>
                                    </li> 
                                    <li class="{{ (session()->get('app.display')==2 ? 'active' : '') }}">
                                        <a href="{{ url('common/display?type=2') }}" target="_blank">{{ trans('app.display_2') }}</a>
                                    </li> 
                                    <li class="{{ (session()->get('app.display')==3 ? 'active' : '') }}">
                                        <a href="{{ url('common/display?type=3') }}" target="_blank">{{ trans('app.display_3') }}</a>
                                    </li> 
                                    <li class="{{ (session()->get('app.display')==4 ? 'active' : '') }}">
                                        <a href="{{ url('common/display?type=4') }}" target="_blank">{{ trans('app.display_4') }}</a>
                                    </li> 
                                    {{-- <li class="{{ (session()->get('app.display')==5 ? 'active' : '') }}">
                                        <a href="{{ url('common/location') }}">{{ trans('Display 9') }}</a>
                                    </li>    --}}

                                    @if (session()->has('custom_displays'))
                                    @foreach(session()->get('custom_displays') as $key => $name)
                                    <li>
                                        <a href="{{ url('common/display?type=6&custom='.$key) }}" target="_blank">{{ trans('app.custom_display') }} - {{ $name }}</a>
                                    </li>
                                    @endforeach
                                    @endif 
                                </ul>
                            </li> 
                            @endif

                            {{-- Message --}}
                            @if(issetAccess(auth()->user()->user_role_id)->message)
                            <li class="cm-submenu {{ (Request::segment(2)=='message' ? 'open' : '') }}">
                                <a class="sf-envelope-letter">{{ trans('app.message') }} <span class="caret"></span></a>
                                <ul>
                                    <li class="{{ (Request::is('common/message') ? 'active' : '') }}">
                                        <a href="{{ url('common/message') }}">{{ trans('app.new_message') }}</a>
                                    </li>
                                    <li class="{{ (Request::is('common/message/inbox') ? 'active' : '') }}">
                                        <a href="{{ url('common/message/inbox') }}">{{ trans('app.inbox') }}</a>
                                    </li>
                                    <li class="{{ (Request::is('common/message/sent') ? 'active' : '') }}">
                                        <a href="{{ url('common/message/sent') }}">{{ trans('app.sent') }}</a>
                                    </li>
                                </ul>
                            </li> 
                            @endif

                            {{-- Settings --}}
                            <li class="cm-submenu {{ (Request::segment(2)=='setting' ? 'open' : '') }}">
                                <a class="sf-cog">{{ trans('app.setting') }} <span class="caret"></span></a>
                                <ul>
                                    @if(issetAccess(auth()->user()->user_role_id)->setting['app_setting'])
                                    <li class="{{ (Request::is('admin/setting') ? 'active' : '') }}">
                                        <a href="{{ url('admin/setting') }}">{{ trans('app.app_setting') }}</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->setting['subsription'])
                                    <li class="{{ (Request::is('admin/subscription') ? 'active' : '') }}">
                                        <a href="{{ url('admin/subscription') }}">Subscription</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->setting['display_setting'])
                                    <li class="{{ (Request::is('admin/setting/display') ? 'active' : '') }}">
                                        <a href="{{ url('admin/setting/display') }}">{{ trans('app.display_setting') }}</a>
                                    </li>
                                    @endif

                                    @if(issetAccess(auth()->user()->user_role_id)->setting['profile_information'])
                                    <li class="{{ (Request::is('common/setting/*') ? 'active' : '') }}">
                                        <a href="{{ url('common/setting/profile') }}">{{ trans('app.profile_information') }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            
                            <li class="{{ (Request::is('qrcode') ? 'active' : '') }}">
                                <a href="{{ url('qrcode') }}" class="sf-star">QR CODE</a>
                            </li>

                            <li class="{{ ((Request::is('logout')) ? 'active' : '') }}">
                                <a href="{{ url('logout') }}" class="sf-lock">
                                    {{ trans('app.signout') }}
                                </a>
                            </li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ends of Sidebar -->


        <!-- Starts of Header/Menu --> 
        <header id="cm-header">
            <nav class="cm-navbar cm-navbar-primary">
                <div class="btn btn-primary md-menu-white hidden-md hidden-lg" data-toggle="cm-menu"></div>
                <div class="cm-flex">
                    <h1 class="clearfix">{{ \Session::get('app.title') }}</h1> 
                </div> 

                <!-- Buy Now -->
                @yield('info.buy-now')

                @if(issetAccess(auth()->user()->user_role_id)->display)
                <div class="dropdown pull-right">
                    <button class="btn btn-primary md-desktop-windows-white" data-toggle="dropdown"></button>
                    <div class="popover cm-popover bottom">
                        <div class="arrow"></div>
                        <div class="popover-content">
                            <div class="list-group"> 
                                <a href="{{ url('common/display?type=1') }}" target="_blank" class="{{session()->get('app.display')==1?'active':null}} list-group-item">
                                    <h4 class="list-group-item-heading"></i> {{ trans('app.display_1') }}</h4>
                                </a>
                                <a href="{{ url('common/display?type=2') }}" target="_blank" class="{{session()->get('app.display')==2?'active':null}} list-group-item">
                                    <h4 class="list-group-item-heading"></i> {{ trans('app.display_2') }}</h4>
                                </a>
                                <a href="{{ url('common/display?type=3') }}" target="_blank" class="{{session()->get('app.display')==3?'active':null}} list-group-item">
                                    <h4 class="list-group-item-heading"></i> {{ trans('app.display_3') }}</h4>
                                </a>
                                <a href="{{ url('common/display?type=4') }}" target="_blank" class="{{session()->get('app.display')==4?'active':null}} list-group-item">
                                    <h4 class="list-group-item-heading"></i> {{ trans('app.display_4') }}</h4>
                                </a>
                                {{-- <a href="{{ url('common/display?type=5') }}" target="_blank" class="{{session()->get('app.display')==5?'active':null}} list-group-item">
                                    <h4 class="list-group-item-heading"></i> {{ trans('app.display_5') }}</h4>
                                </a> --}}
                                @if (session()->has('custom_displays'))
                                @foreach(session()->get('custom_displays') as $key => $name)
                                <a href="{{ url('common/display?type=6&custom='.$key) }}" target="_blank" class="list-group-item">
                                    <h4 class="list-group-item-heading"></i> {{ trans('app.custom_display') }} - {{ $name }}</h4>
                                </a> 
                                @endforeach
                                @endif 
                            </div>
                        </div>
                    </div>
                </div> 
                @endif

                @if(issetAccess(auth()->user()->user_role_id)->message)
                <div class="dropdown pull-right">
                    <a href="{{ url('common/message/inbox') }}" class="btn btn-primary md-local-post-office-white"> <span class="label label-danger" id="message-notify">0</span> </a> 
                </div>
                @endif

                <div class="dropdown pull-right">
                    <button class="btn btn-primary md-language-white" data-toggle="dropdown"> <span class="label label-danger">{{ Session::get('locale')? Session::get('locale'):'en' }}</span></button>
                    <div class="popover cm-popover bottom">
                        <div class="arrow"></div>
                        <div class="popover-content">
                            <div class="list-group"> 
                                <a href="javascript:void(0)" data-locale="en" class="select-lang list-group-item {{ ((Session::get('locale')=='en' || !Session::has('locale'))?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> English</h4>
                                </a>
                                <a href="javascript:void(0)" data-locale="ar" class="select-lang list-group-item {{ (Session::get('locale')=='ar'?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> العَرَبِيَّة'</h4>
                                </a> 
                                <a href="javascript:void(0)" data-locale="tr" class="select-lang list-group-item {{ (Session::get('locale')=='tr'?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> Türkçe</h4>
                                </a> 
                                <a href="javascript:void(0)" data-locale="bn" class="select-lang list-group-item {{ (Session::get('locale')=='bn'?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> বাংলা</h4>
                                </a> 
                                <a href="javascript:void(0)" data-locale="es" class="select-lang list-group-item {{ (Session::get('locale')=='es'?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> Español</h4>
                                </a> 
                                <a href="javascript:void(0)" data-locale="fr" class="select-lang list-group-item {{ (Session::get('locale')=='fr'?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> Français</h4>
                                </a> 
                                <a href="javascript:void(0)" data-locale="pt" class="select-lang list-group-item {{ (Session::get('locale')=='pt'?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> Português</h4>
                                </a> 
                                <a href="javascript:void(0)" data-locale="te" class="select-lang list-group-item {{ (Session::get('locale')=='te'?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> తెలుగు</h4>
                                </a> 
                                <a href="javascript:void(0)" data-locale="th" class="select-lang list-group-item {{ (Session::get('locale')=='th'?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> ภาษาไทย</h4>
                                </a> 
                                <a href="javascript:void(0)" data-locale="vi" class="select-lang list-group-item {{ ((Session::get('locale')=='vi')?'active':'') }}">
                                    <h4 class="list-group-item-heading"></i> Tiếng Việt</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> 
                @if($user = Auth::user()) 
                <div class="dropdown pull-right">
                    <button class="btn btn-primary md-account-circle-white" data-toggle="dropdown"></button>
                    <ul class="dropdown-menu">
                        <li class="disabled text-center">
                            <img src="{{ !empty($user->photo)?asset($user->photo):asset('public/assets/img/icons/no_user.jpg') }}" width="140" height="105">
                        </li>
                        <li class="disabled text-center">
                            <a style="cursor:default;"><strong>{{ $user->firstname .' '. $user->lastname }}</strong> 
                            </a>
                            <span class="label label-success">{{ auth()->user()->userRole()->name ?? '' }}</span>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('common/setting/profile') }}"><i class="fa fa-user"></i> {{ trans('app.profile_information') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('logout') }}"><i class="fa fa-sign-out"></i> {{ trans('app.signout') }}</a>
                        </li>
                    </ul>
                </div>
                @endif
            </nav>
        </header>
        <!-- Ends of Header/Menu -->


        <div id="global"> 

            <div class="container-fluid"> 
                <!-- Starts of Message -->
                @yield('info.message')
                <!-- Ends of Message --> 

                <!-- Starts of Content -->
                @yield('content')
                <!-- Ends of Contents --> 
            </div>

            <!-- Starts of Copyright -->
                
            <footer class="cm-footer text-right">
                <span class="hidden-xs">Owned By <a href="https://softafrique.net/" class="text-decoration-none" target="_blank">Softafrique LLC</a></span>
                {{-- <span class="pull-left text-center">@yield('info.powered-by') @yield('info.version')</span>  --}}
                <span class="pull-left text-center">Powered By Gokiiw</span> 
            </footer>
            <!-- Ends of Copyright -->
        </div>


        <!-- All js -->
        <!-- bootstrp -->
        <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script> 
        <!-- select2 -->
        <script src="{{ asset('public/assets/js/select2.min.js') }}"></script>
        <!-- juery-ui -->
        <script src="{{ asset('public/assets/js/jquery-ui.min.js') }}"></script> 
        <!-- jquery.mousewheel.min -->
        <script src="{{ asset('public/assets/js/jquery.mousewheel.min.js') }}"></script>
        <!-- jquery.cookie.min -->
        <script src="{{ asset('public/assets/js/jquery.cookie.min.js') }}"></script>
        <!-- fastclick -->
        <script src="{{ asset('public/assets/js/fastclick.min.js') }}"></script>
        <!-- template -->
        <script src="{{ asset('public/assets/js/template.js') }}"></script>
        <!-- datatable -->
        <script src="{{ asset('public/assets/js/dataTables.min.js') }}"></script>
        <!-- custom script -->
        <script src="{{ asset('public/assets/js/script.js') }}"></script>
        
        <!-- Sweet Alert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        @if (session()->has('info'))
        <script>
            swal("", "{{session('info')}}", "info");
        </script>
        @endif

        <!-- Page Script -->
        @stack('scripts')
        
        <script type="text/javascript">
        (function() {
          //notification
            notify();
            setInterval(function(){
                notify();
            }, 30000);

            function notify()
            {
                $.ajax({
                   type:'GET',
                   url:'{{ URL::to("common/message/notify") }}',
                   data:'_token = <?php echo csrf_token() ?>',
                   success:function(data){
                      $("#message-notify").html(data);
                   }
                });
            }
         
            //language switch
            $(".select-lang").on('click', function() { 
                $.ajax({
                   type:'GET',
                   url: '{{ url("common/language") }}',
                   data: {
                      'locale' : $(this).data("locale"), 
                      '_token' : '<?php echo csrf_token() ?>'
                   },
                   success:function(data){
                      history.go(0);
                   }, error: function() {
                    alert('failed');
                   }
                });       
            });
            
        })();
        </script>
    </body>
</html>

 