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

				function myFunction() {
				document.getElementById("myDIV").style.display = "none";
				}

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
		<?php echo $key ; ?>
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
			
			<!--th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Delete</th -->
		</tr>
	</thead>
	
	<tbody role="alert" aria-live="polite" aria-relevant="all">
   
	<?php 
		
             
				 
			 while (list($key1,$val1)=each($val))
			 {
		?>
    		<tr class="odd">
				<td class="center">
					<label>
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>
                      
                <td class="sorting_1">  
					<?php echo $val1[checkin][name];?><br/>
					<?php echo $val1[checkin][phone];?>
                </td>
                
                <td class="sorting_1">
					<a href="<?php echo $this->Html->Url('/');?>apis/uploads/retailers/<?php echo $val1['checkin']['img'];?>"  class="fancybox" > 
					<img src="<?php echo $this->Html->Url('/');?>apis/uploads/retailers/<?php echo $val1['checkin']['img'];?>"  width="200" height="100" /> 
					</a>
				</td>
				
                
                <td class="" width="25%">
                	<?php  echo $val1[checkin][tim];?> <?php echo "<br/>";?>
					<a class="fancybox fancybox.iframe" href="<?php echo $this->Html->Url('/');?>users/mapAttendanceView/<?php echo $key1;?>/<?php  echo $val1[checkin][latitude];?>/<?php  echo $val1[checkin][longitude];?>">View On Map</a>
       			</td>

                  <td class="" width="25%">
					<?php  echo $val1[checkout][tim];?> <?php echo "<br/>";?>
					<a class="fancybox fancybox.iframe" href="<?php echo $this->Html->Url('/');?>users/mapAttendanceView/<?php echo $key1;?>/<?php  echo $val1[checkout][latitude];?>/<?php  echo $val1[checkout][longitude];?>">View On Map</a>
				  </td>

               <!-- <td>
					<div class="visible-md visible-lg hidden-sm hidden-xs btn-group" id="myDIV" >
					<a class="btn btn-xs btn-danger" title="Delete" href="#" onclick="if (confirm(&quot;Are you sure you wish to delete this?&quot;)) { return true; } return false;">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>
					</div>
				</td>-->
			</tr>
                
		<?php }
?>
			</tbody>
		</table>	
	
<?php	}
			 
	?>