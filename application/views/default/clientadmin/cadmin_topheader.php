
        <!-- header -->
            <header>
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span1">
                            <div class="main-logo"><a href="<?php echo site_url("clientadmin/dashboard"); ?>"><img src="<?php echo base_url("uploads"); ?>/<?php echo $this->session->userdata('logo'); ?>" alt="<?php echo $site_name; ?>" title="<?php echo $site_name; ?>"></a></div>
                        </div>
						<div class="span5">
							 <div class="user-info"><h4><?php echo PROJECT_TITLE; ?></h4></div>
						</div>
						
						<div style="width:450px; float:right">
                        <div  style="width:150px; float:left;">
                            <nav class="nav-icons">
                               <!-- <ul>
                                    <li><a href="<?php //echo site_url("clientadmin"); ?>" class="ptip_ne" title="Dashboard"><i class="icsw16-home"></i></a></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li class="active"></li>
                                    <li><a href="#" class="ptip_ne" title="Settings"><i class="icsw16-cog"></i></a></li>
                                </ul>-->
                             </nav>
                        </div>
                        <div  style="width:250px; float:left;">
                            <div class="user-box">
                                <div class="user-box-inner">
                                    <img src="<?php echo base_url("assets/clientadmin"); ?>/img/avatars/avatar.png" alt="" class="user-avatar img-avatar">
                                    <div class="user-info">
                                        Welcome,<strong><?php echo $this->session->userdata('username'); ?> </strong>
                                          <ul class="unstyled">
                                        <!--    <li><a href="<?php echo site_url('clientadmin/profile'); ?>">Settings</a></li>
                                            <li>&middot;</li>-->
                                            <li><a href="<?php echo site_url('clientadmin/logout'); ?>">Logout</a></li>
                                        </ul>
                                  </div>
                                </div>
                            </div>
                        </div>
						
						</div>
						
                    </div>
                </div>
            </header>