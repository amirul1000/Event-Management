<a  href="<?php echo site_url('admin/event_staff/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Event_staff'); ?></h5>
<!--Data display of event_staff with id--> 
<?php
	$c = $event_staff;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Events</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Events_model');
									   $dataArr = $this->CI->Events_model->get_events($c['events_id']);
									   echo $dataArr['event_name'];?>
									</td></tr>

<tr><td>Staff Name</td><td><?php echo $c['staff_name']; ?></td></tr>

<tr><td>Role</td><td><?php echo $c['role']; ?></td></tr>

<tr><td>Contact</td><td><?php echo $c['contact']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of event_staff with id//--> 