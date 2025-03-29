<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css"> 
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Events'); ?></h3>
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
<!--Data display of events-->    
<table   cellspacing="3" cellpadding="3" class="table" align="center">
    <tr>
		<th>Event Name</th>
<th>Event Date</th>
<th>Venues</th>
<th>Organizers</th>
<th>Description</th>

    </tr>
	<?php foreach($events as $c){ ?>
    <tr>
		<td><?php echo $c['event_name']; ?></td>
<td><?php echo $c['event_date']; ?></td>
<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Venues_model');
									   $dataArr = $this->CI->Venues_model->get_venues($c['venues_id']);
									   echo $dataArr['venue_name'];?>
									</td>
<td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Organizers_model');
									   $dataArr = $this->CI->Organizers_model->get_organizers($c['organizers_id']);
									   echo $dataArr['organizer_name'];?>
									</td>
<td><?php echo $c['description']; ?></td>

    </tr>
	<?php } ?>
</table>
<!--End of Data display of events//--> 