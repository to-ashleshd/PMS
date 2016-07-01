<aside id="sidebar" class="sidebar c-overflow">
    <div class="profile-menu">
        <a href="">
            <div class="profile-pic">
                <img src="<?php echo base_url('assets/material/img'); ?>/profile-pics/1.jpg" alt="">
            </div>

            <div class="profile-info">
                Malinda Hollaway

                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>

        <ul class="main-menu">
            <li>
                <a href="profile-about.html"><i class="zmdi zmdi-account"></i> View Profile</a>
            </li>
            <li>
                <a href=""><i class="zmdi zmdi-input-antenna"></i> Privacy Settings</a>
            </li>
            <li>
                <a href=""><i class="zmdi zmdi-settings"></i> Settings</a>
            </li>
            <li>
                <a href=""><i class="zmdi zmdi-time-restore"></i> Logout</a>
            </li>
        </ul>
    </div>

    <ul class="main-menu">
        <li><a href="index.html"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
        <li class="sub-menu">
            <a href=""><i class="zmdi zmdi-key zmdi-hc-fw"></i> My KRA</a>
            <ul>
                <li class="sub-menu">
                    <a href="textual-menu.html">PA 2015-2016</a>
                    <ul>
                        <li><a href="#">My KRA</a></li>
                        <li><a href="#">My PMS</a></li>
                        <li><a href="#">My IDP</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="textual-menu.html">PA 2016-2017</a>
                    <ul>
                        <li><a href="#">My KRA</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="sub-menu">
            <a href=""><i class="zmdi zmdi-account zmdi-hc-fw"></i> My Account</a>

            <ul>
                <li><a href="<?php echo base_url("materialv1/changepassword")?>">Change Password</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </li>                   

    </ul>
</aside>
