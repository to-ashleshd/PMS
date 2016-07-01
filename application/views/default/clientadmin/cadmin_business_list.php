<table id="dt_colVis_emailtemplate" class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>id</th>
      <th>Title / Subject</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $business_list_data as $key=>$val ): ?>
    <tr>
      <td><?php echo $val->business_id; ?></td>
      <td><?php echo $val->business_subject; ?></td>

      <td><?php echo ( $val->is_active == '1' ? 'Active' : 'Suspend'); ?></td>
      <td style="width:150px;">
	  	<a class="editbusiness btn btn-mini" href="javascript:void(0);" id='edit_<?php echo $val->business_id; ?>'><i class="icon-pencil" title="Edit"></i></a>  
		<?php if($val->is_active == '1' ) : ?>
			<a class="suspendbusiness btn btn-mini" href="javascript:void(0);" id='suspend_<?php echo $val->business_id; ?>'><i class="icsw16-acces-denied-sign" title="Suspend"></i></a>
		<?php else: ?>
			<a class="activebusiness" href="javascript:void(0);" id='active_<?php echo $val->business_id; ?>'><i class="icon-plus-sign"></i></a>
		<?php endif; ?>
		</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>