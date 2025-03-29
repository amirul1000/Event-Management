<a  href="<?php echo site_url('admin/event_staff/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Event_staff'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/event_staff/save/'.$event_staff['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Events" class="col-md-4 control-label">Events</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Events_model'); 
             $dataArr = $this->CI->Events_model->get_all_events(); 
          ?> 
          <select name="events_id"  id="events_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($event_staff['events_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['event_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Staff Name" class="col-md-4 control-label">Staff Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="staff_name" value="<?php echo ($this->input->post('staff_name') ? $this->input->post('staff_name') : $event_staff['staff_name']); ?>" class="form-control" id="staff_name" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Role" class="col-md-4 control-label">Role</label> 
          <div class="col-md-8"> 
           <input type="text" name="role" value="<?php echo ($this->input->post('role') ? $this->input->post('role') : $event_staff['role']); ?>" class="form-control" id="role" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Contact" class="col-md-4 control-label">Contact</label> 
          <div class="col-md-8"> 
           <input type="text" name="contact" value="<?php echo ($this->input->post('contact') ? $this->input->post('contact') : $event_staff['contact']); ?>" class="form-control" id="contact" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($event_staff['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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