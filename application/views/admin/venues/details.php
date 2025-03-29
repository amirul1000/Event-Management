<a  href="<?php echo site_url('admin/venues/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Venues'); ?></h5>
<!--Data display of venues with id--> 
<?php
	$c = $venues;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Venue Name</td><td><?php echo $c['venue_name']; ?></td></tr>

<tr><td>Location</td><td><?php echo $c['location']; ?></td></tr>

<tr><td>Capacity</td><td><?php echo $c['capacity']; ?></td></tr>


</table>
<!--End of Data display of venues with id//--> 