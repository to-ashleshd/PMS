
<!-- Menu bar-->
<div class="navbar navbar-fixed-top" style="position:relative;">
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
		 <li><a href="<?php echo site_url('clientadmin/dashboard'); ?>">Dashboard</a></li>
		 <?php 
		 if ($this->session->userdata('pms_employee_id')) {
		 if($this->session->userdata('pms_employee_id')=='1')
		 {
		 ?>
            <li><a href="javascript:void(0)">Employee</a>
            <ul>
              <li><a href="<?php echo site_url('clientadmin/addemployee'); ?>">Add Employee</a></li>
              <li><a href="<?php echo site_url('employee'); ?>">Employee List</a></li>
			  <li><a href="<?php echo site_url('employee/addrelationship'); ?>">Add Employee Relationsip</a></li>
			  <li><a href="<?php echo site_url('employee/relationship'); ?>">Employee Relationsip List</a></li>
            </ul>
          </li>
		  <?php }
		  	}
		   ?>
		   
		<?php  if($this->session->userdata('pms_employee_id')!='1')
		 {
		 ?>
        <li><a href="javascript:void(0)">My KRA</a>
            <ul>
			<?php
			if(isset($time_period_list))
			{
				if(!empty($time_period_list))
				{
					foreach($time_period_list as $key=>$val)
					{
						?>
						<li>
						<a href="javascript:void(0)">PA <?php echo $val['time_period_from'].'-'.$val['time_period_to']; ?></a>
						 <?php
								 if($val['status']=='0')
									{
							?>
						  <ul>
							  <li><a href="<?php echo site_url('apraisee/addkra').'/'.$val['time_period_id']; ?>">My KRA</a></li>
							  <li><a href="<?php echo site_url('apraisee/addpms').'/'.$val['time_period_id']; ?>">My PMS</a></li>
							  <li><a href="<?php echo site_url('apraisee/addidp').'/'.$val['time_period_id']; ?>">My IDP</a></li>
				  		 </ul>
						<?php
									}
						else
						{
						?>
						 <ul>
						  <li><a href="<?php echo site_url('apraisee/addkra').'/'.$val['time_period_id']; ?>">My KRA</a></li>
						 <!-- <li><a href="<?php //echo site_url('apraisee/addidp').'/'.$val['time_period_id']; ?>">My IDP</a></li>-->
				  		</ul>
						<?php
								}
								?>
						</li>
						<?php
								
					}
					
				}
			}
			?>
            </ul>
          </li>
		  <?php } ?>
		   <?php
		   if($is_employee_apraiser=='Y')
		   {
			   ?>
			<li><a href="<?php echo site_url('apraiser'); ?>">My Team KRA</a></li>
			<?php
			}
			?>
		<!--<li><a href="<?php //echo site_url('clientadmin/revieweremployeelist'); ?>">Reviewer KRA</a></li>-->
	
		
          <li><a href="<?php echo site_url('clientadmin/newreports') ?>">Report</a> </li>
		
			<?php if( $this->session->userdata('login_type') == 'admin' ) : ?>
          <li><a href="javascript:void(0)">Setting</a>
            <ul>
              <li><a href="<?php echo site_url(); ?>clientadmin/generalsettings">General Setting</a></li>
              <li><a href="<?php echo site_url(); ?>clientadmin/environmentsettings">Environment Setting</a></li>
              <li><a href="ca_adminrole.php">Administrator and Roles</a></li>
              <li><a href="<?php echo site_url('localisation'); ?>">Localisation</a></li>
              <li><a href="ca_customization_upgrade.php" >Customization and Upgrade</a>
            </ul>
          </li>
		  <?php endif; ?>  
          <li><a href="javascript:void(0)">My Account</a>
            <ul>
              <li> <a href="#">Change Password</a> </li>
              <li> <a href="#<?php //echo site_url('clientadmin/profile'); ?>">Profile</a> </li>
            </ul>
          </li>
         <!-- <li><a href="javascript:void(0)">Help</a>-->
            <!--<ul>
		  <li><a href="add_level.php">Add Level</a></li>
              <li><a href="add_question.php">Add Question</a></li>
              <li><a href="services_list.php">Services List</a></li>
		  </ul>-->
         <!-- </li>-->
        </ul>
      </div>
    </div>
  </div>
</div>
