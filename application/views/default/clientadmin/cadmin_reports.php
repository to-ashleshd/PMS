 <!-- main content -->
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span8">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Live Chart</h4>
                            </div>
                            <div class="w-box-content cnt_a">
                                <div id="chart_live" class="chart_b"></div>
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Pie Chart</h4>
                            </div>
                            <div class="w-box-content cnt_b">
                                <div id="chart_pie" class="chart_a"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Stacked Bar Chart</h4>
                            </div>
                            <div class="w-box-content cnt_a">
                                <div id="chart_bar" class="chart_b"></div>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="w-box">
                            <div class="w-box-header cnt_a">
                                <h4>Thresholding the data</h4>
                            </div>
                            <div class="w-box-content cnt_b">
                                <div id="chart_threshold" class="chart_a"></div>
                                <div class="threshold_btns">
                                    <input type="button" class="btn btn-mini" value="Threshold at 10">
                                    <input type="button" class="btn btn-mini" value="Threshold at 0">
                                    <input type="button" class="btn btn-mini" value="Threshold at -2.5">
                                </div>
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
                            <li><a href="<?php echo site_url("clientadmin/dashboard"); ?>">Home</a></li>
                            <li>&middot;</li>
                            <li><a href="#">Contact Us</a></li>
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

        <!-- flot charts -->
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.resize.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.pie.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.orderBars.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.tooltip.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.time.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.stack.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/jquery.flot.threshold.js"></script>

            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/pages/beoro_charts.js"></script>

    </body>
</html>