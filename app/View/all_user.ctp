<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->

<!--<script src="<?php //echo $this->Html->Url('/');?>popupjs/jquery-1.11.0.min.js"></script>

<link rel="stylesheet" href="<?php //echo $this->Html->Url('/');?>popupjs/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php //echo $this->Html->Url('/');?>popupjs/jquery.fancybox.pack.js?v=2.1.5"></script>

<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();

			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
			});

			

		});
	</script>
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}

	</style>-->


										

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
			
			<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Checkin_Time &nbsp; Checkout_Time</th>
			
			<th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Checkin_Latitude &nbsp; Checkout_Latitude</th>
            <th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Checkin_Longitude &nbsp; Checkout_Longitude</th>
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
                
			<!--<img src="<?php //echo $this->Html->Url('/');?>apis/uploads/retailers/thumbnails/<?php //echo $val['p']['user_image'];?>" width="200" height="100" />   &nbsp; <?php //echo $stime2[tim];?> &nbsp;<?php //echo $val['p']['user_id'];?>-->
				</td>
				
                
                <td class="" width="25%">
                
					<?php  echo $val1[checkin][tim];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php  echo $val1[checkout][tim];?>
				</td>

				<td> 
					<?php echo $val1[checkin][latitude];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <?php  echo $val1[checkout][latitude];?>
                 
                    </td>
               <td>
                
                   <?php echo $val1[checkin][longitude];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <?php  echo $val1[checkout][longitude];?>
                <td> 
				<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
					
					
					
					<a class="btn btn-xs btn-danger" title="Delete" href="/btlPromotions/delete/<?php echo  $val['p']['id'];?>" onclick="if (confirm(&quot;Are you sure you wish to delete this?&quot;)) { return true; } return false;">
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