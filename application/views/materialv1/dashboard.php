<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Admin</title>

    <!-- Common CSS -->
    <?php $this->load->view('materialv1/common/common_css'); ?>
</head>

<body>

    <!-- Common Header -->
    <?php $this->load->view('materialv1/common/common_header'); ?>

    <section id="main">

        <!-- Left Sidebar -->
        <?php $this->load->view('materialv1/common/common_left_sidebar'); ?>

        <aside id="chat" class="sidebar c-overflow">

            <div class="chat-search">
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Search People">
                </div>
            </div>

            <div class="listview">
                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left p-relative">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/2.jpg" alt="">
                            <i class="chat-status-busy"></i>
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Jonathan Morris</div>
                            <small class="lv-small">Available</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/1.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lv-title">David Belle</div>
                            <small class="lv-small">Last seen 3 hours ago</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left p-relative">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/3.jpg" alt="">
                            <i class="chat-status-online"></i>
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Fredric Mitchell Jr.</div>
                            <small class="lv-small">Availble</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left p-relative">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/4.jpg" alt="">
                            <i class="chat-status-online"></i>
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Glenn Jecobs</div>
                            <small class="lv-small">Availble</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/5.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Bill Phillips</div>
                            <small class="lv-small">Last seen 3 days ago</small>
                        </div>
                    </div>
                </a>

                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/6.jpg" alt="">
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Wendy Mitchell</div>
                            <small class="lv-small">Last seen 2 minutes ago</small>
                        </div>
                    </div>
                </a>
                <a class="lv-item" href="">
                    <div class="media">
                        <div class="pull-left p-relative">
                            <img class="lv-img-sm" src="<?php echo base_url('assets/material/img'); ?>/profile-pics/7.jpg" alt="">
                            <i class="chat-status-busy"></i>
                        </div>
                        <div class="media-body">
                            <div class="lv-title">Teena Bell Ann</div>
                            <small class="lv-small">Busy</small>
                        </div>
                    </div>
                </a>
            </div>
        </aside>

        <section id="content">
            <div class="container">
                <div class="card">                        
                    <div class="lv-header-alt clearfix">
                        <h2 class="lvh-label hidden-xs">Some text here</h2>

                        <div class="lvh-search">
                            <input type="text" placeholder="Start typing..." class="lvhs-input">

                            <i class="lvh-search-close">&times;</i>
                        </div>

                        <ul class="lv-actions actions">
                            <li>
                                <a href="" class="lvh-search-trigger">
                                    <i class="zmdi zmdi-search"></i>
                                </a>
                            </li>

                            <li>
                                <a href="">
                                    <i class="zmdi zmdi-time"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown" aria-expanded="true">
                                    <i class="zmdi zmdi-sort"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Last Modified</a>
                                    </li>
                                    <li>
                                        <a href="">Last Edited</a>
                                    </li>
                                    <li>
                                        <a href="">Name</a>
                                    </li>
                                    <li>
                                        <a href="">Date</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="">
                                    <i class="zmdi zmdi-info"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown" aria-expanded="true">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh</a>
                                    </li>
                                    <li>
                                        <a href="">Listview Settings</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <Div class="card-body card-padding">
                        <h3>Data attributes</h3>
                        You can use all Bootstrap plugins purely through the markup API without writing a single line of JavaScript. This is Bootstrap's first-class API and should be your first consideration when using a plugin.
                        That said, in some situations it may be desirable to turn this functionality off. Therefore, we also provide the ability to disable the data attribute API by unbinding all events on the document namespaced with data-api. This looks like this:
                    </Div>



                </div><!--/card-->
            </div>
        </section>
    </section>

    <!-- Common Footer -->
    <?php $this->load->view('materialv1/common/common_footer'); ?>


    <!-- Page Loader -->
    <div class="page-loader">
        <div class="preloader pls-blue">
            <svg class="pl-circular" viewBox="25 25 50 50">
            <circle class="plc-path" cx="50" cy="50" r="20" />
            </svg>

            <p>Please wait...</p>
        </div>
    </div>

    <!-- Older IE warning message -->
    <!--[if lt IE 9]>
        <div class="ie-warning">
            <h1 class="c-white">Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="img/browsers/chrome.png" alt="">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="img/browsers/firefox.png" alt="">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="img/browsers/opera.png" alt="">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="img/browsers/safari.png" alt="">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="img/browsers/ie.png" alt="">
                            <div>IE (New)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>   
    <![endif]-->

    <!-- Javascript Libraries -->
    <?php $this->load->view('materialv1/common/common_js'); ?>


</body>
</html>