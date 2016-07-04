<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $site_name; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- Le styles -->
<link href="<?php echo base_url("assets/sweetdream/"); ?>/css/style.css" rel="stylesheet">
<link href="<?php echo base_url("assets/sweetdream/"); ?>/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/jquery-ui-1.8.16.custom.css" media="screen"  />
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/fullcalendar.css" media="screen"  />
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/chosen.css" media="screen"  />
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/jquery.jgrowl.css">

<!--
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/datepicker.css" >
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/colorpicker.css">
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/glisse.css?1.css">
-->

<!--
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/js/elfinder/css/elfinder.css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/jquery.tagsinput.css" />
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/demo_table.css" >
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/js/export/css/TableTools.css" >
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/css/pwdmeter"); ?>/style.css" type="text/css">

-->

<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/validationEngine.jquery.css">
<!--- for pasoword-->
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/jquery.stepy.css" />
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/icon/font-awesome.css">
<link rel="stylesheet" href="<?php echo base_url("assets/sweetdream/"); ?>/css/bootstrap-responsive.css">

<link rel="stylesheet" type="text/css" media="screen" title="silver-theme" href="<?php echo base_url("assets/sweetdream/"); ?>/css/color/silver.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="metro-theme" href="<?php echo base_url("assets/sweetdream/"); ?>/css/color/metro.css" />
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!--[if lte IE 8]><script type="text/javascript" src="/js/excanvas.min.js"></script><![endif]-->
<!-- Le fav and touch icons -->
<link rel="SHORTCUT ICON" href="<?php echo base_url("assets/user/images/default"); ?>/favicon.ico">
<!-- jQuery framework -->

</head>
<body style="vertical-align:baseline;">

<!--Header Start-->
<style>
#aviewmutualfriends{
display:inline;
padding:0px;
}

.confirm{
     font-size: 11px;
    font-weight: 100;
     padding: 2px 4px;
	 left: 10px;
	 background-color: #61A4F0;
	 background-image: -moz-linear-gradient(center top , #61A4F0, #2C63C2);
	 background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #FFFFFF;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	display:inline;
}

.header { width:980px; margin:auto; box-shadow:none; }
#prof_dropdown { position:relative; }
#outerheader {background: linear-gradient(to bottom, #F4F4F4 1%, #CACACA 100%) repeat scroll 0 0 transparent;
    border-bottom: 1px solid #979797;
	box-shadow: 0 3px 16px rgba(0, 0, 0, 0.35);
    height: 60px;
	border-bottom:1px solid #979797;
	}

.name-user {
    max-width: 150px;
    overflow: hidden;
    width: 150px;
}
.dropdown-menu a { white-space:normal; line-height:normal; padding:1px 10px; }
</style>
<div id="outerheader" class="header" style="width:100%; position:fixed; z-index:500">
<div class="header"  style="position:static; z-index:500;" >
  <!--  <a href="dashboard.html" class="logo"><h1>SWEET DREAMS</h1></a>-->
  <span class="logo" > <img src="<?php echo base_url("uploads"); ?>/<?php echo $logo; ?>"  alt="Enrich" title="<?php echo $site_name; ?>" start="margin-top:2px;"> </span>
 
 <div class="heading_main" style="font-family: 'Open Sans Condensed', sans-serif; font-size:22px; width:400px; float:right; height:45px;vertical-align:middle;margin-top:17px;">Performance Management System</div>
   
  
</div>


</div>
<!-- Spacer for fixed height -->
<div style="width:100%; height:60px;">&nbsp;</div>
<!-- End Spacer for fixed height -->

<!--Header END-->

<style>
img.cssMenu li:hover 		
{ 
	display:block;
}
 .ui-autocomplete {
 background-color:#ffffff;
}
 .ui-autocompleteoverlay {
background-color:#3A73CC;
}
.ui-autocomplete li:hover{
background-color:#3A73CC;
display:inline-block;
}
.ui-menu .ui-menu-item ui-state-focus,
.ui-menu .ui-menu-item ui-state-active {
background-color:#3A73CC;
};

/*! jQuery UI - v1.10.1 - 2013-02-26
* http://jqueryui.com
* Includes: jquery.ui.core.css, jquery.ui.autocomplete.css, jquery.ui.menu.css
* To view and modify this theme, visit http://jqueryui.com/themeroller/?ffDefault=Trebuchet%20MS%2CTahoma%2CVerdana%2CArial%2Csans-serif&fwDefault=bold&fsDefault=1.1em&cornerRadius=4px&bgColorHeader=f6a828&bgTextureHeader=gloss_wave&bgImgOpacityHeader=35&borderColorHeader=e78f08&fcHeader=ffffff&iconColorHeader=ffffff&bgColorContent=eeeeee&bgTextureContent=highlight_soft&bgImgOpacityContent=100&borderColorContent=dddddd&fcContent=333333&iconColorContent=222222&bgColorDefault=f6f6f6&bgTextureDefault=glass&bgImgOpacityDefault=100&borderColorDefault=cccccc&fcDefault=1c94c4&iconColorDefault=ef8c08&bgColorHover=fdf5ce&bgTextureHover=glass&bgImgOpacityHover=100&borderColorHover=fbcb09&fcHover=c77405&iconColorHover=ef8c08&bgColorActive=ffffff&bgTextureActive=glass&bgImgOpacityActive=65&borderColorActive=fbd850&fcActive=eb8f00&iconColorActive=ef8c08&bgColorHighlight=ffe45c&bgTextureHighlight=highlight_soft&bgImgOpacityHighlight=75&borderColorHighlight=fed22f&fcHighlight=363636&iconColorHighlight=228ef1&bgColorError=b81900&bgTextureError=diagonals_thick&bgImgOpacityError=18&borderColorError=cd0a0a&fcError=ffffff&iconColorError=ffd27a&bgColorOverlay=666666&bgTextureOverlay=diagonals_thick&bgImgOpacityOverlay=20&opacityOverlay=50&bgColorShadow=000000&bgTextureShadow=flat&bgImgOpacityShadow=10&opacityShadow=20&thicknessShadow=5px&offsetTopShadow=-5px&offsetLeftShadow=-5px&cornerRadiusShadow=5px
* Copyright (c) 2013 jQuery Foundation and other contributors Licensed MIT */

/* Layout helpers
----------------------------------*/
.ui-helper-hidden {
	display: none;
}
.ui-helper-hidden-accessible {
	border: 0;
	clip: rect(0 0 0 0);
	height: 1px;
	margin: -1px;
	overflow: hidden;
	padding: 0;
	position: absolute;
	width: 1px;
}
.ui-helper-clearfix:after {
	clear: both;
}

.ui-state-hover,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus {
	/*border: 1px solid #fbcb09;*/
	background: #3A73CC  50% 50% repeat-x;
	font-weight: bold;
	color: #ffffff;
}







/* Misc visuals
----------------------------------*/

/* Corner radius */
.ui-corner-all,
.ui-corner-top,
.ui-corner-left,
.ui-corner-tl {
	border-top-left-radius: 4px;
}
.ui-corner-all,
.ui-corner-top,
.ui-corner-right,
.ui-corner-tr {
	border-top-right-radius: 4px;
}
.ui-corner-all,
.ui-corner-bottom,
.ui-corner-left,
.ui-corner-bl {
	border-bottom-left-radius: 4px;
}
.ui-corner-all,
.ui-corner-bottom,
.ui-corner-right,
.ui-corner-br {
	border-bottom-right-radius: 4px;
}

</style>
