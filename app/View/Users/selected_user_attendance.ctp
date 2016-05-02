										

<div class="row">

	<div class="col-xs-12">
<?php while (list($key,$val)=each($finalarrcheckin))
			 {
				 ?>
	<div class="table-header">
		Results for "List of User Attendance" &nbsp;<?php echo $key ; ?>
	</div>	
	<table id="designation" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
	<thead>

		<tr role="row">
			<th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 59px;">
				<label>
					<input type="checkbox" class="ace">
					<span class="lbl"></span>
				</label>
                
			</th>
			<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">User</th>
            <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">User_Image</th>
			
			<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Checkin_Time  </th>
			
            <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Checkout_Time</th>
			
            
			<!--<th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Checkin_Latitude &nbsp; Checkout_Latitude</th>
            <th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Checkin_Longitude &nbsp; Checkout_Longitude</th>-->
            <th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Delete</th>
		</tr>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all">
   

	<?php 
		
             			
				 while (list($key1,$val1)=each($val))
			 {
			/*	  	 while (list($key2,$val2)=each($val1))
			 {
					*/
			
		?>
    
    
			<tr class="odd">
				<td class="center">
					<label>
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>
                      
                      
                    <td class="sorting_1">  
				<?php echo $val1[checkin][name];?>
                </td>
                
                <td class="sorting_1">
			<img src="<?php echo $this->Html->Url('/');?>apis/uploads/retailers/thumbnails/<?php echo $val1['checkin']['img'];?>" width="200" height="100" />
				</td>
				
                
                <td class="" width="25%">
                
					<?php  echo $val1[checkin][tim];?> <?php echo "<br/>";?>
                     <a class="fancybox fancybox.iframe" href="<?php echo $this->Html->Url('/');?>btlPromotions/mapView/<?php echo $key1;?>"><button class="btn btn-success" >View On Map</button></a>
                     
				</td>

                  <td class="" width="25%">
                
					 <?php  echo $val1[checkout][tim];?>
				</td>

            
		<!--		<td> 
					<?php //echo $val1[checkin][latitude];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <?php  //echo $val1[checkout][latitude];?>
                 
                    </td>
               <td>
                
                   <?php //echo $val1[checkin][longitude];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <?php  //echo $val1[checkout][longitude];?> -->
                <td>
				<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
					
					
					
					<a class="btn btn-xs btn-danger" title="Delete" href="/Users/delete/<?php echo  $key1;?>" onclick="if (confirm(&quot;Are you sure you wish to delete this?&quot;)) { return true; } return false;">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>

					 <!--<a class="fancybox fancybox.iframe" href="<?php //echo $this->Html->Url('/');?>btlPromotions/mapView/<?php //echo $val['p']['id'];?>"><button class="btn btn-success" >View On Map</button></a>
-->
				</div>


 </td>
				</tr>
                
		<?php }
				  }
			 
	?>
        
		</tbody>
		</table>	
		
</div>
<!--<p style="font-size:14px; color:#F00"><?php //echo $this->Session->flash(); ?></p>-->
</div>


<!--<script type="text/javascript">
			jQuery(function($) {
				
				var oTable1 = $('#designation').dataTable( {} );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			})
</script>
-->