 <?php echo $header; ?>
 <!-- main content -->
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span8">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Dashboard</h4>
                                <i class="icsw16-graph icsw16-white pull-right"></i>
                            </div>
                            <div class="w-box-content cnt_a">
                               <div style="height:250px;">
							   </div>
                            </div>
                        </div>
                    </div>
              </div>
            </div>
            <div class="footer_space"></div>
        </div> 


         <?php echo $middle_footer; ?>
   

<?php echo $common_js; ?>
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
<?php echo $last_footer; ?>