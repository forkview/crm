<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{url('/')}}">TeamBox</a>

    </div>
    <!-- /.navbar-header -->

     {{--Logout info change password--}}

    <ul class="nav navbar-top-links navbar-right">
@if(Auth::user()->department_info->blocked == 0)

      @foreach($links as $link)

          {{-- Including IT notifications --}}
          @include('partials.nav_includes._blocked_for_it')

          {{-- Including DKJ table small --}}
          @include('partials.nav_includes._blocked_for_dkj_small')

          {{-- Including DKJ table big --}}
          @include('partials.nav_includes._blocked_for_dkj_big')

      @endforeach

      {{-- Including multiple departments selector --}}
      @include('partials.nav_includes._multiple_departments')

@endif
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Auth::user()->first_name.' '.Auth::user()->last_name}}
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{URL::to('/password_change')}}"><i class="fa fa-user fa-fw"></i>Zmiana hasła</a>
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
                                      <li>
                                          <a href="{{url($link->link)}}">{{$link->name}}</a>
                                      </li>
                                  @endif
                              @endforeach
                                  </ul>
                              </li>
                              @endforeach
                @endif

            </ul>
        </div>
    </div>

    @if($link->link == 'janky_notification' || 1 == 1)
        @include('partials.nav_includes._canvas_janky')
    @else
    <div id="blok" style="display: none; width: 0px; height: 0px">
        <p><span id="notification_janky_count" style="display: none"></span></p>
    </div>

    @endif
</nav>
