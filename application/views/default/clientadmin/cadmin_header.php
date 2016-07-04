<!DOCTYPE HTML>
<html lang="en-US">

    <head>

        <meta charset="UTF-8">
		<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="no-store">
<META HTTP-EQUIV="EXPIRES" CONTENT="0">
        <title><?php echo $site_name; ?></title>
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="icon" type="image/ico" href="favicon.ico">
        
    <!-- common stylesheets-->
        <!-- bootstrap framework css -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/bootstrap/css/bootstrap-responsive.min.css">
        <!-- iconSweet2 icon pack (16x16) -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/icsw2_16/icsw2_16.css">
		 <!-- iconSweet2 icon pack (32) -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/icsw2_32/icsw2_32.css">	
        <!-- splashy icon pack -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/splashy/splashy.css">
        <!-- flag icons -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/img/flags/flags.css">
        <!-- power tooltips -->
		<link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/powertip/jquery.powertip.css">
        <!-- google web fonts -->
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Abel">
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">

    <!-- aditional stylesheets -->
	 <!-- 2 col multiselect -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/multi-select/css/multi-select.css">
        <!-- smart wizard -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/smart-wizard/styles/smart_wizard.css">
 <!-- datatables -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/datatables/css/datatables_beoro.css">

        <!-- main stylesheet -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/css/beoro.css">
	<!-- enchanced select box, tag handler -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/select2/select2.css">
        <!-- datepicker -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-datepicker/css/datepicker.css">
			       
				     <!-- aditional stylesheets -->
        <!-- colorbox -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/colorbox/colorbox.css">
        <!--fullcalendar -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/fullcalendar/fullcalendar_beoro.css">
				   
				   
        <!-- switch buttons -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/lib/ibutton/css/jquery.ibutton.css">
        <!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/css/ie8.css"><![endif]-->
        <!--[if IE 9]><link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/css/ie9.css"><![endif]-->
            
        <!--[if lt IE 9]>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/ie/html5shiv.min.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/ie/respond.min.js"></script>
            <script src="<?php echo base_url("assets/clientadmin"); ?>/js/lib/flot-charts/excanvas.min.js"></script>
        <![endif]-->
		<!--- for localisation errors --->
		 <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/css/localisation.css">
		
		<style type="text/css">
.container_chkbox { border:2px solid #ccc; width:300px; height: 100px; overflow-y: scroll; padding: 0 9px;}
</style>
		
		<!-- tree plugin -->
            <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/dynatree/skin/ui.dynatree.css">
			
		 <!-- jQuery UI theme -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jquery-ui/css/Aristo/Aristo.css">
  <!-- 2 col multiselect -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/multi-select/css/multi-select.css">
  <!-- enchanced select box, tag handler -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/select2/select2.css">
  <!-- datepicker -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-datepicker/css/datepicker.css">
  <!-- timepicker -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-timepicker/css/timepicker.css">
  <!-- colorpicker -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/bootstrap-colorpicker/css/colorpicker.css">
  <!-- switch buttons -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/ibutton/css/jquery.ibutton.css">
  <!-- UI Spinners -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/jqamp-ui-spinner/css/jqamp-ui-spinner.css">
  <!-- multiupload -->
  <link rel="stylesheet" href="<?php echo base_url("assets/clientadmin"); ?>/js/lib/plupload/js/jquery.plupload.queue/css/plupload-beoro.css">

	   
    </head>
    <body class="bg_d">
    <!-- main wrapper (without footer) -->    
        <div class="main-wrapper">
<!-- Call Header -->
<?php $this->load->view('default/clientadmin/cadmin_topheader') ; ?>
<?php echo $topmenu; ?>
<?php //$this->load->view('default/clientadmin/cadmin_topmenu') ; ?>
<?php $this->load->view('default/clientadmin/cadmin_breadcrumb') ; ?>
<script type="text/javascript" >
function hide_message(id)
	{
		setTimeout(function(){ $("#"+id).html(''); }, 3000);
	}

</script>
 