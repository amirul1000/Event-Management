<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Tickets'); ?></h3>
Date: <?php echo date("Y-m-d");?>
<hr>
<!--*************************************************
*********mpdf header footer page no******************
****************************************************-->
<htmlpageheader name="firstpage" class="hide">
</htmlpageheader>

<htmlpageheader name="otherpages" class="hide">
    <span class="float_left"></span>
    <span  class="padding_5"> &nbsp; &nbsp; &nbsp;
     &nbsp; &nbsp; &nbsp;</span>
    <span class="float_right"></span>         
</htmlpageheader>      
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" /> 
   
<htmlpagefooter name="myfooter"  class="hide">                          
     <div align="center">
               <br><span class="padding_10">Page {PAGENO} of {nbpg}</span> 
     </div>
</htmlpagefooter>    

<sethtmlpagefooter name="myfooter" value="on" />
<!--*************************************************
*********#////mpdf header footer page no******************
****************************************************-->
<!--Data display of tickets-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
    <tr>
		<th>Events</th>
<th>Attendees</th>
<th>Ticket Type</th>
<th>Price</th>
<th>Purchase Date</th>

    </tr>
	<?php foreach($tickets as $c){ ?>
    <tr>
		<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Events_model');
									   $dataArr = $this->CI->Events_model->get_events($c['events_id']);
									   echo $dataArr['event_name'];?>
									</td>
<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Attendees_model');
									   $dataArr = $this->CI->Attendees_model->get_attendees($c['attendees_id']);
									   echo $dataArr['name'];?>
									</td>
<td><?php echo $c['ticket_type']; ?></td>
<td><?php echo $c['price']; ?></td>
<td><?php echo $c['purchase_date']; ?></td>

    </tr>
	<?php } ?>
</table>
<!--End of Data display of tickets//--> 