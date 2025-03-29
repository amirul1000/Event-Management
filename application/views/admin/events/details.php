<a  href="<?php echo site_url('admin/events/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Events'); ?></h5>
<!--Data display of events with id--> 
<?php
	$c = $events;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Event Name</td><td><?php echo $c['event_name']; ?></td></tr>

<tr><td>Event Date</td><td><?php echo $c['event_date']; ?></td></tr>

<tr><td>Venues</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Venues_model');
									   $dataArr = $this->CI->Venues_model->get_venues($c['venues_id']);
									   echo $dataArr['venue_name'];?>
									</td></tr>

<tr><td>Organizers</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Organizers_model');
									   $dataArr = $this->CI->Organizers_model->get_organizers($c['organizers_id']);
									   echo $dataArr['organizer_name'];?>
									</td></tr>

<tr><td>Description</td><td><?php echo $c['description']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of events with id//--> 