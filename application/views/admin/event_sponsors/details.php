<a  href="<?php echo site_url('admin/event_sponsors/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Event_sponsors'); ?></h5>
<!--Data display of event_sponsors with id--> 
<?php
	$c = $event_sponsors;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Events</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Events_model');
									   $dataArr = $this->CI->Events_model->get_events($c['events_id']);
									   echo $dataArr['event_name'];?>
									</td></tr>

<tr><td>Sponsor Name</td><td><?php echo $c['sponsor_name']; ?></td></tr>

<tr><td>Amount</td><td><?php echo $c['amount']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of event_sponsors with id//--> 