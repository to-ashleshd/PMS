<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PMS  Add Employee</title>
    <!-- Common CSS -->
    <?php $this->load->view('materialv1/common/common_css'); ?>
       <link href="<?php echo base_url('assets/material'); ?>/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
       <style type="text/css">
           .btn:not(.btn-link) {
                box-shadow: none;
            }
       </style>
</head>
<body>
    <!-- Common Header -->
    <?php $this->load->view('materialv1/common/common_header'); ?>
    <section id="main">
        <!-- Left Sidebar -->
        <?php $this->load->view('materialv1/common/common_left_sidebar'); ?>
        <section id="content">
            <div class="container">
                <div class="card">                        
                    <div class="lv-header-alt clearfix">
                        <h2 class="lvh-label hidden-xs">Some text here</h2>
                        <ul class="lv-actions actions">   
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
                    <div class="card-body card-padding">
                        <table id="data-table-command" class="table table-striped table-vmiddle">
                            <thead>
                                <tr>
                                    <th data-column-id="id" data-type="numeric">ID</th>
                                    <th data-column-id="employeeid">Employee ID</th>
                                    <th data-column-id="employeename">Employee Name</th>
                                    <th data-column-id="designation">Designation</th>
                                    <th data-column-id="departmnet">Department</th>
                                    <th data-column-id="dateofjoining">Date of Joining</th>
                                    <th data-column-id="commands" data-formatter="commands" data-sortable="false" data-align="right" data-header-align="right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php 
									if(isset($employee))
									{
										if(!empty($employee))
										{
											
											foreach($employee as $key=>$val)
											{
										
											?>
									 <tr>
									 		<td><?php echo $key+1; ?></td>
											<td><?php echo $val['employee_id']; ?></td>
                                            <td><?php echo $val['employee_name'] ?></td>
                                            <td><?php echo $val['grade_name']?></td>
                                            <td><?php echo $val['designation_name']?></td>
                                            <td><?php echo $val['department_name']?></td>
											<td><?php echo $val['date_of_joining']?></td>
										<!--	<td><?php //echo $val['dummy_relation']?></td>-->
											
									</tr>
									<?php
											}
										}
									}
									?>
                                
                            </tbody>
                        </table>
                    </div><!--/card-body-->
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
        <!-- Data Table -->
        <script src="<?php echo base_url('assets/material'); ?>/vendors/bootgrid/jquery.bootgrid.updated.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                //Basic Example
                $("#data-table-basic").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                });
                
                //Selection
                $("#data-table-selection").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<button type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> " + 
                                "<button type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-eye\"></span></button>";
                        }
                    }
                });
            });
        </script>


</body>
</html>