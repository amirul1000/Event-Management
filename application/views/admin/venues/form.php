<a  href="<?php echo site_url('admin/venues/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Venues'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/venues/save/'.$venues['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
          <label for="Venue Name" class="col-md-4 control-label">Venue Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="venue_name" value="<?php echo ($this->input->post('venue_name') ? $this->input->post('venue_name') : $venues['venue_name']); ?>" class="form-control" id="venue_name" /> 
          </div> 
           </div>
<div class="form-group"> 
                                        <label for="Location" class="col-md-4 control-label">Location</label> 
          <div class="col-md-8"> 
           <textarea  name="location"  id="location"  class="form-control" rows="4"/><?php echo ($this->input->post('location') ? $this->input->post('location') : $venues['location']); ?></textarea> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Capacity" class="col-md-4 control-label">Capacity</label> 
          <div class="col-md-8"> 
           <input type="text" name="capacity" value="<?php echo ($this->input->post('capacity') ? $this->input->post('capacity') : $venues['capacity']); ?>" class="form-control" id="capacity" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($venues['id'])){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->	
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>  			