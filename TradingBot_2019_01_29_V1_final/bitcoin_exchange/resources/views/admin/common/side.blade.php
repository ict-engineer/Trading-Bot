<nav class="pcoded-navbar" pcoded-header-position="relative">
        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
        <div class="pcoded-inner-navbar main-menu">

           <ul class="pcoded-item pcoded-left-item">

                <li  class="{{ (Route::is('admin.dashboard') ? 'active' : '') }}">
                    <a href="{{route('admin.dashboard')}}" data-i18n="nav.form-select.main">
                        <span class="pcoded-micon"><i class="icofont icofont-dashboard"></i></span>
                        <!--<span class="pcoded-mtext">Dashboard</span>-->
                        <span class="pcoded-mtext">Dashboard</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>



                <li>
                    <a href="{{url('admin/getprofile')}}">
                        <i class="fa fa-key"></i>
                        <!--<span class="pcoded-mtext">&nbsp&nbsp&nbspMy Profile</span>-->
                        <span class="pcoded-mtext">&nbsp&nbsp&nbspAdmin</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

           </ul>

        </div>
     </nav>
