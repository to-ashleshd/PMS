<!DOCTYPE HTML>
<html lang="en-US">
    <head>

        <meta charset="UTF-8">
        <title>Beoro Admin Template</title>
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="icon" type="image/ico" href="favicon.ico">
        
    <!-- common stylesheets-->
        <!-- bootstrap framework css -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/bootstrap/css/bootstrap-responsive.min.css">
        <!-- iconSweet2 icon pack (16x16) -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/icsw2_16/icsw2_16.css">
        <!-- splashy icon pack -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/splashy/splashy.css">
        <!-- flag icons -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/flags/flags.css">
        <!-- power tooltips -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/powertip/jquery.powertip.css">
        <!-- google web fonts -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/http://fonts.googleapis.com/css?family=Abel">
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">

    <!-- aditional stylesheets -->
        <!-- colorbox -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/colorbox/colorbox.css">
        <!--fullcalendar -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/fullcalendar/fullcalendar_beoro.css">


        <!-- main stylesheet -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/css/beoro.css">

        <!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css"><![endif]-->
        <!--[if IE 9]><link rel="stylesheet" href="css/ie9.css"><![endif]-->
            
        <!--[if lt IE 9]>
            <script src="js/ie/html5shiv.min.js"></script>
            <script src="js/ie/respond.min.js"></script>
            <script src="js/lib/flot-charts/excanvas.min.js"></script>
        <![endif]-->

    </head>
    <body class="bg_d">
    <!-- main wrapper (without footer) -->    
        <div class="main-wrapper">
        <!-- top bar -->
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container-fluid">
                        <div class="pull-right top-search">
                            <form action="" >
                                <input type="text" name="q" id="q-main">
                                <button class="btn"><i class="icon-search"></i></button>
                            </form>
                        </div>
                        <div id="fade-menu" class="pull-left">
                            <ul class="clearfix" id="mobile-nav">
                                <li>
                                    <a href="javascript:void(0)">Forms</a>
                                    <ul>
                                        <li>
                                            <a href="form_elements.html">Form elements</a>
                                        </li>
                                        <li>
                                            <a href="form_validation.html">Form validation</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Components</a>
                                    <ul>
                                        <li>
                                            <a href="calendar.html">Calendar</a>
                                        </li>
                                        <li>
                                            <a href="charts.html">Charts</a>
                                        </li>
                                        <li>
                                            <a href="contact_list.html">Contact List</a>
                                        </li>
                                        <li>
                                            <a href="datatables.html">Datatables</a>
                                        </li>
                                        <li>
                                            <a href="file_manager.html">File manager</a>
                                        </li>
                                        <li>
                                            <a href="gallery.html">Gallery</a>
                                        </li>
                                        <li>
                                            <a href="gmaps.html">Google Maps</a>
                                        </li>
                                        <li>
                                            <a href="#">Tables</a>
                                            <ul>
                                                <li><a href="tables_regular.html">Regular Tables</a></li>
                                                <li><a href="table_examples.html">Table examples</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="wizard.html">Wizard</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">UI Elements</a>
                                    <ul>
                                        <li><a href="alerts_buttons.html">Alerts, Buttons</a></li>
                                        <li><a href="grid.html">Grid</a></li>
                                        <li><a href="icons.html">Icons</a></li>
                                        <li>
                                            <a href="notifications.html">Notifications</a>
                                        </li>
                                        <li><a href="tabs_accordions.html">Tabs, Accordions</a></li>
                                        <li><a href="tooltips_popovers.html">Tooltips, Popovers</a></li>
                                        <li><a href="typography.html">Typography</a></li>
                                        <li><a href="widgets.html">Widgets</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Other pages</a>
                                    <ul>
                                        <li><a href="blog_page.html">Blog page</a></li>
                                        <li><a href="error_404.html">Error 404</a></li>
                                        <li><a href="help_faq.html">Help/Faq</a></li>
                                        <li><a href="invoices.html">Invoices</a></li>
                                        <li><a href="login.html">Login Page</a></li>
                                        <li><a href="mailbox.html">Mailbox</a></li>
                                        <li><a href="user_profile.html">User profile</a></li>
                                        <li><a href="settings.html">Site Settings</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Sub-menu</a>
                                    <ul>
                                        <li><a href="#">Section 1</a></li>
                                        <li><a href="#">Section 2</a></li>
                                        <li><a href="#">Section 3</a></li>
                                        <li>
                                            <a href="#">Section 4</a>
                                            <ul>
                                                <li><a href="#">Section 4.1</a></li>
                                                <li><a href="#">Section 4.2</a></li>
                                                <li><a href="#">Section 4.3</a></li>
                                                <li>
                                                    <a href="#">Section 4.4</a>
                                                    <ul>
                                                        <li><a href="#">Section 4.4.1</a></li>
                                                        <li><a href="#">Section 4.4.2</a></li>
                                                        <li><a href="#">Section 4.4.4</a></li>
                                                        <li><a href="#">Section 4.4.5</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Section5</a></li>
                                        <li><a href="#">Section6</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        <!-- header -->
            <header>
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span3">
                            <div class="main-logo"><a href="dashboard.html"><img src="img/beoro_logo.png" alt="Beoro Admin"></a></div>
                        </div>
                        <div class="span5">
                            <nav class="nav-icons">
                                <ul>
                                    <li><a href="javascript:void(0)" class="ptip_s" title="Dashboard"><i class="icsw16-home"></i></a></li>
                                    <li><a href="javascript:void(0)" class="ptip_s" title="Content"><i class="icsw16-create-write"></i></a></li>
                                    <li><a href="javascript:void(0)" class="ptip_s" title="Mailbox"><i class="icsw16-mail"></i><span class="badge badge-info">6</span></a></li>
                                    <li><a href="javascript:void(0)" class="ptip_s" title="Comments"><i class="icsw16-speech-bubbles"></i><span class="badge badge-important">14</span></a></li>
                                    <li class="active"><span class="ptip_s" title="Statistics (active)"><i class="icsw16-graph"></i></span></li>
                                    <li><a href="javascript:void(0)" class="ptip_s" title="Settings"><i class="icsw16-cog"></i></a></li>
                                </ul>
                             </nav>
                        </div>
                        <div class="span4">
                            <div class="user-box">
                                <div class="user-box-inner">
                                    <img src="img/avatars/avatar.png" alt="" class="user-avatar img-avatar">
                                    <div class="user-info">
                                        Welcome, <strong>Jonathan</strong>
                                        <ul class="unstyled">
                                            <li><a href="user_profile.html">Settings</a></li>
                                            <li>&middot;</li>
                                            <li><a href="login.html">Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

        <!-- breadcrumbs -->
            <div class="container-fluid">
                <ul id="breadcrumbs">
                    <li><a href="javascript:void(0)"><i class="icon-home"></i></a></li>
                    <li><a href="javascript:void(0)">Content</a></li>
                    <li><a href="javascript:void(0)">Article: Lorem ipsum dolor...</a></li>
                    <li><a href="javascript:void(0)">Comments</a></li>
                    <li><span>Lorem ipsum dolor sit amet...</span></li>
                </ul>
            </div>
            
        <!-- main content -->
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span8">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Analytics</h4>
                                <i class="icsw16-graph icsw16-white pull-right"></i>
                            </div>
                            <div class="w-box-content cnt_a">
                                <div class="slidewrap">
                                    <ul class="slider" id="sliderName">
                                        <li class="slide" data-slname="Pageviews">  
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div id="ch_pages" class="chart_a"></div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span10 offset1">
                                                    <div class="row-fluid">
                                                        <div class="span4">
                                                            <div class="anlt_box">
                                                                <p class="anlt_heading">Last 24h<span class="up">+12%</span></p>
                                                                <p class="anlt_content">2 131</p>
                                                            </div>
                                                        </div>
                                                        <div class="span4">
                                                            <div class="anlt_box">
                                                                <p class="anlt_heading">Last 7 days<span class="down">-5%</span></p>
                                                                <p class="anlt_content">14 483</p>
                                                            </div>
                                                        </div>
                                                        <div class="span4">
                                                            <div class="anlt_box">
                                                                <p class="anlt_heading">Last Month<span class="up">+14%</span></p>
                                                                <p class="anlt_content">64 250</p>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="slide" data-slname="Users">  
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div id="ch_users" class="chart_a"></div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span10 offset1">
                                                    <div class="row-fluid">
                                                        <div class="span6">
                                                            <div class="anlt_box">
                                                                <p class="anlt_heading">Last 24h<span class="up">+8%</span></p>
                                                                <p class="anlt_content">184</p>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="anlt_box">
                                                                <p class="anlt_heading">Last 7 days<span class="up">+20%</span></p>
                                                                <p class="anlt_content">1468</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="slide" data-slname="Sales">  
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div id="ch_sales" class="chart_a"></div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span10 offset1">
                                                    <div class="row-fluid">
                                                        <div class="span6">
                                                            <div class="anlt_box">
                                                                <p class="anlt_heading">Last 24h<span class="up">+20%</span></p>
                                                                <p class="anlt_content">$1 843</p>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="anlt_box">
                                                                <p class="anlt_heading">Last 7 days<span class="down">-10%</span></p>
                                                                <p class="anlt_content">$11 638</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="w-box w-box-green hideable">
                            <div class="w-box-header">
                                <h4>Todo list</h4>
                                <div class="pull-right">
                                    <span class="label"><span class="jQ-todoAll-count"></span> tasks</span>
                                </div>
                            </div>
                            <div class="w-box-content todo-list">
                                <div class="add_box input-append">
                                    <input class="span10" type="text" placeholder="Add item" id="addTask" /><button class="btn btn-small" type="button"><i class="icon-plus"></i></button>
                                </div>
                                <h4>Personal (<span class="todo-nb"></span>)</h4>
                                <ul class="connectedSortable">
                                    <li class="high-pr"><input type="checkbox" class="todo-check" /> Buy groceries</li>
                                    <li class="low-pr completed"><input type="checkbox" checked class="todo-check" /> Do laundry</li>
                                    <li class="low-pr"><input type="checkbox" class="todo-check" /> Meeting with Macy</li>
                                    <li class="high-pr"><input type="checkbox" class="todo-check" /> Pick up kids</li>
                                </ul>
                                <h4>Work (<span class="todo-nb"></span>)</h4>
                                <ul class="connectedSortable">
                                    <li class="medium-pr"><input type="checkbox" class="todo-check" /> Send press releases</li>
                                    <li class="low-pr"><input type="checkbox" class="todo-check" /> Buy books</li>
                                    <li class="high-pr completed"><input type="checkbox" checked class="todo-check" /> Update main site</li>
                                </ul>
                            </div>
                        </div>
                    </div>  
                </div>
              
            
            </div>
            <div class="footer_space"></div>
        </div> 

    <!-- footer --> 
        <footer>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span5">
                        <div>&copy; Your Company 2012</div>
                    </div>
                    <div class="span7">
                        <ul class="unstyled">
                            <li><a href="#">First link</a></li>
                            <li>&middot;</li>
                            <li><a href="#">Second link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        
    <!-- Common JS -->
        <!-- jQuery framework -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.min.js"></script>
        <!-- bootstrap Framework plugins -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/bootstrap/js/bootstrap.min.js"></script>
        <!-- top menu -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.fademenu.js"></script>
        <!-- top mobile menu -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/selectnav.min.js"></script>
        <!-- actual width/height of hidden DOM elements -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.actual.min.js"></script>
        <!-- jquery easing animations -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/jquery.easing.1.3.min.js"></script>
        <!-- power tooltips -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/powertip/jquery.powertip-1.1.0.min.js"></script>
        <!-- date library -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/moment.min.js"></script>
        <!-- common functions -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/beoro_common.js"></script>


    <!-- Dashboard JS -->
        <!-- jQuery UI -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-ui/jquery-ui-1.9.2.custom.min.js"></script>
        <!-- touch event support for jQuery UI -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-ui/jquery.ui.touch-punch.min.js"></script>
        <!-- colorbox -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/colorbox/jquery.colorbox.min.js"></script>
        <!-- fullcalendar -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/fullcalendar/fullcalendar.min.js"></script>
        <!-- flot charts -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.resize.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.pie.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.orderBars.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.tooltip.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.time.js"></script>
        <!-- responsive carousel -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/carousel/plugin.min.js"></script>
        <!-- responsive image grid -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/wookmark/jquery.imagesloaded.min.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/wookmark/jquery.wookmark.min.js"></script>

            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/pages/beoro_dashboard.js"></script>

    </body>
</html>