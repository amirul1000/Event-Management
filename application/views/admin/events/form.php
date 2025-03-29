<a  href="<?php echo site_url('admin/events/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Events'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/events/save/'.$events['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
          <label for="Event Name" class="col-md-4 control-label">Event Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="event_name" value="<?php echo ($this->input->post('event_name') ? $this->input->post('event_name') : $events['event_name']); ?>" class="form-control" id="event_name" /> 
          </div> 
           </div>
<div class="form-group"> 
                                       <label for="Event Date" class="col-md-4 control-label">Event Date</label> 
          <div class="col-md-8"> 
           <input type="text" name="event_date"  id="event_date"  value="<?php echo ($this->input->post('event_date') ? $this->input->post('event_date') : $events['event_date']); ?>" class="form-control-static datepicker"/> 
          </div> 
           </div>
<div class="form-group"> 
                                    <label for="Venues" class="col-md-4 control-label">Venues</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Venues_model'); 
             $dataArr = $this->CI->Venues_model->get_all_venues(); 
          ?> 
          <select name="venues_id"  id="venues_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($events['venues_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['venue_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Organizers" class="col-md-4 control-label">Organizers</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Organizers_model'); 
             $dataArr = $this->CI->Organizers_model->get_all_organizers(); 
          ?> 
          <select name="organizers_id"  id="organizers_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($events['organizers_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['organizer_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                        <label for="Description" class="col-md-4 control-label">Description</label> 
          <div class="col-md-8"> 
           <textarea  name="description"  id="description"  class="form-control" rows="4"/><?php echo ($this->input->post('description') ? $this->input->post('description') : $events['description']); ?></textarea> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($events['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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