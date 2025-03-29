<a  href="<?php echo site_url('admin/organizers/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Organizers'); ?></h5>
<!--Data display of organizers with id--> 
<?php
	$c = $organizers;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Organizer Name</td><td><?php echo $c['organizer_name']; ?></td></tr>

<tr><td>Email</td><td><?php echo $c['email']; ?></td></tr>

<tr><td>Phone</td><td><?php echo $c['phone']; ?></td></tr>


</table>
<!--End of Data display of organizers with id//--> 