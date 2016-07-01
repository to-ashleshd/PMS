<table id="dt_colVis_emailtemplate" class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>id</th>
      <th>Title / Subject</th>
      <th>Description</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $announcement_list as $key=>$val ): ?>
    <tr>
      <td><?php echo $val->announcement_id; ?></td>
      <td><?php echo $val->announcement_subject; ?></td>
      <td><?php echo $val->announcement_desc; ?></td>
      <td><?php echo ( $val->is_active == '1' ? 'Active' : 'Suspend'); ?></td>
      <td style="width:150px;">
	  	<a class="editannouncement" href="javascript:void(0);" id='edit_<?php echo $val->announcement_id; ?>'>Edit</a> | 
		<?php if($val->is_active == '1' ) : ?>
			<a class="suspendannouncement" href="javascript:void(0);" id='suspend_<?php echo $val->announcement_id; ?>'>Set Suspend</a>
		<?php else: ?>
			<a class="activeannouncement" href="javascript:void(0);" id='active_<?php echo $val->announcement_id; ?>'>Set Active</a>
		<?php endif; ?>
		</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
