<a  href="<?php echo site_url('admin/tickets/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Tickets'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/tickets/save/'.$tickets['id'],array("class"=>"form-horizontal")); ?>
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
            <option value="<?=$dataArr[$i]['id']?>" <?php if($tickets['events_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['event_name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Attendees" class="col-md-4 control-label">Attendees</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Attendees_model'); 
             $dataArr = $this->CI->Attendees_model->get_all_attendees(); 
          ?> 
          <select name="attendees_id"  id="attendees_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($tickets['attendees_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                        <label for="Ticket Type" class="col-md-4 control-label">Ticket Type</label> 
          <div class="col-md-8"> 
           <?php 
             $enumArr = $this->customlib->getEnumFieldValues('tickets','ticket_type'); 
           ?> 
           <select name="ticket_type"  id="ticket_type"  class="form-control"/> 
             <option value="">--Select--</option> 
             <?php 
              for($i=0;$i<count($enumArr);$i++) 
              { 
             ?> 
             <option value="<?=$enumArr[$i]?>" <?php if($tickets['ticket_type']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php 
              } 
             ?> 
           </select> 
          </div> 
            </div>
<div class="form-group"> 
          <label for="Price" class="col-md-4 control-label">Price</label> 
          <div class="col-md-8"> 
           <input type="text" name="price" value="<?php echo ($this->input->post('price') ? $this->input->post('price') : $tickets['price']); ?>" class="form-control" id="price" /> 
          </div> 
           </div>
<div class="form-group"> 
                                       <label for="Purchase Date" class="col-md-4 control-label">Purchase Date</label> 
          <div class="col-md-8"> 
           <input type="text" name="purchase_date"  id="purchase_date"  value="<?php echo ($this->input->post('purchase_date') ? $this->input->post('purchase_date') : $tickets['purchase_date']); ?>" class="form-control-static datepicker"/> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($tickets['id'])){?>Save<?php }else{?>Update<?php } ?></button>
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