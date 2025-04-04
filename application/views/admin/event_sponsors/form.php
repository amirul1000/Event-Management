<a  href="<?php echo site_url('admin/event_sponsors/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Event_sponsors'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/event_sponsors/save/'.$event_sponsors['id'],array("class"=>"form-horizontal")); ?>
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($event_sponsors['events_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['event_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
          <label for="Sponsor Name" class="col-md-4 control-label">Sponsor Name</label> 
          <div class="col-md-8"> 
           <input type="text" name="sponsor_name" value="<?php echo ($this->input->post('sponsor_name') ? $this->input->post('sponsor_name') : $event_sponsors['sponsor_name']); ?>" class="form-control" id="sponsor_name" /> 
          </div> 
           </div>
<div class="form-group"> 
          <label for="Amount" class="col-md-4 control-label">Amount</label> 
          <div class="col-md-8"> 
           <input type="text" name="amount" value="<?php echo ($this->input->post('amount') ? $this->input->post('amount') : $event_sponsors['amount']); ?>" class="form-control" id="amount" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($event_sponsors['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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