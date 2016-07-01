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
              <li><a href="<?php echo site_url('employee/addemployee'); ?>">Add Employee</a></li>
              <li><a href="<?php echo site_url('employee'); ?>">Employee List</a></li>
			  <li><a href="<?php echo site_url('employee/addrelationship'); ?>">Add Employee Relationsip</a></li>
			  <li><a href="<?php echo site_url('employee/relationship'); ?>">Employee Relationsip List</a></li>
			  <li><a href="<?php echo site_url('employee/lastpromotion'); ?>">Employee Last Pramotion</a></li>
            </ul>
          </li>
		  <?php }
		  	}
		   ?>
		   
		  <?php
		  if($this->session->userdata('pms_employee_id')!='1')
		 {
		 ?>
        <li><a href="javascript:void(0)">My KRA</a>
            <ul>
			<?php
			if(isset($time_periods))
			{
				if(!empty($time_periods))
				{
					foreach($time_periods as $key=>$val)
					{
						?>
						<li>
						<a href="javascript:void(0)">PA<?php echo $val['time_period_from'].'-'.$val['time_period_to']; ?></a>
						 <?php
							 if($val['status']=='0' || $val['status']=='3')
								{
						?>
						  <ul>
							  <li><a href="<?php echo site_url('apraisee/addkra').'/'.$val['time_period_id']; ?>">My KRA</a></li>
							  <li><a href="<?php echo site_url('apraisee/addpms').'/'.$val['time_period_id']; ?>">My PMS</a></li>
							  <li><a href="<?php echo site_url('apraisee/addidp').'/'.$val['time_period_id']; ?>">My IDP</a></li>
				  		 </ul>
						<?php
								}
							else if($val['status']=='1')
							{
						?>
						 <ul>
						  <li><a href="<?php echo site_url('apraisee/addkra').'/'.$val['time_period_id']; ?>">My KRA</a></li>
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
		  <?php
		  }
		  ?>
		   <?php
				if($is_employee_apraiser=='Y' || $is_employee_reviewer=='Y')
				{
			   ?>
			<li><a href="<?php echo site_url('apraiser'); ?>">My Team</a></li>
			
		
          <!-- <li><a href="<?php //echo site_url('clientadmin/newreports') ?>">Report</a> </li> -->
		  
		  <!-- Report Menu -->
		  <li><a href="javascript:void(0);">Reports</a>
					<ul>
						<!-- Display Report Dynamic -->
						<?php if(isset($time_periods)) : ?>
						<?php if(!empty($time_periods)) : ?>
						<?php foreach($time_periods as $key=>$val) : ?>
							<?php if($val['status']=='0' || $val['status']=='3') : ?>
							<li><a href="javascript:void(0);"> <?php echo $val['time_period_from'].' - '.$val['time_period_to']; ?></a>
								<ul>
									<li><a href="<?php echo site_url('reports/pmsratingreport').'/'.$val['time_period_id']; ?>">PMS Rating Report</a></li>
									<li><a href="<?php echo site_url('reports/promotionrecommendationreport').'/'.$val['time_period_id']; ?>">Promotion Report</a></li>
									<li><a href="<?php echo site_url('apraiser/statusreport').'/'.$val['time_period_id']; ?>">Status Report</a></li>
									<li><a href="<?php echo site_url('reports/bellcurve').'/'.$val['time_period_id']; ?>">Bell Curve Report</a></li>
									<li><a href="<?php echo site_url('reports/idpreport').'/'.$val['time_period_id']; ?>">IDP Report</a></li>
								</ul>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
						<?php endif; ?>
						<?php endif; ?>
						<!-- End Display -->
					</ul>
		  </li>
		  
		  <!-- End Report Menu -->
		  
		<?php
		}
		?>
			<?php if( $this->session->userdata('login_type') == 'admin' ) : ?>
          <li><a href="javascript:void(0)">Setting</a>
            <ul>
              <li><a href="<?php echo site_url(); ?>clientadmin/generalsettings">General Setting</a></li>
              <li><a href="<?php echo site_url(); ?>clientadmin/environmentsettings">Environment Setting</a></li>
               <li><a href="<?php echo site_url('adminroles'); ?>">Administrator and Roles</a></li>
               <li><a href="<?php echo site_url('localisation'); ?>">Localisation</a></li>
			   <li><a href="<?php echo site_url('competencies/competencies'); ?>">Add Competencies</a></li>
			  <?php
			  if($this->session->userdata('pms_employee_id')=='1')
			 {
			 ?>
			   <li><a href="<?php echo site_url('employeepermission'); ?>">Employee ACL Permission</a></li>
			   <?php
			   }
			   ?>
              <!-- <li><a href="ca_customization_upgrade.php" >Customization and Upgrade</a> -->
			  <li><a href="<?php echo site_url('import/importexcel'); ?>">Excel Import </a></li>
			  <li><a href="<?php echo site_url('announcement'); ?>">Announcements</a></li>
            </ul>
          </li>
		  <?php endif; ?>  
          <li><a href="javascript:void(0)">My Account</a>
            <ul>
              <li> <a href="<?php echo site_url('employee/changepassword'); ?>">Change Password</a> </li>
              <li> <a href="<?php echo site_url('employee/profile'); ?>">Profile</a> </li>
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
