
<ul class="nav" id="side-menu">
    <li class="nav-header">
        <div class="dropdown profile-element"> <span>
                <img alt="image" class="img-circle" src="/img/profile_small.jpg" />
            </span>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="clear"> <span class="block m-t-xs text-muted text-xs block"> <strong class="font-bold">{{ Auth::user()->username }}</strong>
                    <b class="caret"></b></span> </span> </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">Logout</a></li>
            </ul>
        </div>
        <div class="logo-element">
            IN+
        </div>
    </li>
    @include('admin/inc/custom-menu-items', array('items' => $AdminNav->roots()))
</ul>