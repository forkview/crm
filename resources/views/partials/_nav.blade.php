<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{url('/')}}">CRM Verona</a>

    </div>
    <!-- /.navbar-header -->

     {{--Logout info change password--}}

    <ul class="nav navbar-top-links navbar-right">

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Auth::user()->first_name.' '.Auth::user()->last_name}}
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="password_change"><i class="fa fa-user fa-fw"></i>Zmiana hasła</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a  href="{{ route('logout') }}" onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out fa-fw"></i>
                        Wyglouj</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    </ul>

    <div class="navbar-default sidebar pre-scrollable" role="navigation" style="min-height: 93vh"  id="my_left_menu">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{url('/')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                @if(Auth::user()->department_info->blocked == 0)
                  @foreach($groups->where('id','!=',8) as $group)
                              <li>
                                  <a href="#"><i class="fa fa-files-o fa-fw"></i>{{$group->name}}<span class="fa arrow"></span></a>
                                  <ul class="nav nav-second-level">

                              @foreach($links as $link)
                                  @if($group->id == $link->group_link_id)
                                      @if($link->link == 'show_all_notifications')
                                          <li>
                                                <a href="{{URL::to('/show_all_notifications/1')}}">{{$link->name}}</a>
                                          </li>
                                      @else
                                          <li>
                                              <a href="{{url($link->link)}}">{{$link->name}}</a>
                                          </li>
                                      @endif
                                  @endif
                              @endforeach
                                  </ul>
                              </li>
                              @endforeach
                @endif

            </ul>
        </div>
    </div>
</nav>
