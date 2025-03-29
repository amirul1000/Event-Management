<a  href="<?php echo site_url('admin/tickets/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Tickets'); ?></h5>
<!--Data display of tickets with id--> 
<?php
	$c = $tickets;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Events</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Events_model');
									   $dataArr = $this->CI->Events_model->get_events($c['events_id']);
									   echo $dataArr['event_name'];?>
									</td></tr>

<tr><td>Attendees</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Attendees_model');
									   $dataArr = $this->CI->Attendees_model->get_attendees($c['attendees_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Ticket Type</td><td><?php echo $c['ticket_type']; ?></td></tr>

<tr><td>Price</td><td><?php echo $c['price']; ?></td></tr>

<tr><td>Purchase Date</td><td><?php echo $c['purchase_date']; ?></td></tr>

<tr><td>Created At</td><td><?php echo $c['created_at']; ?></td></tr>

<tr><td>Updated At</td><td><?php echo $c['updated_at']; ?></td></tr>


</table>
<!--End of Data display of tickets with id//--> 