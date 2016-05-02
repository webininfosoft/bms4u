<script src="<?php echo $this->Html->Url('/');?>popupjs/jquery-1.11.0.min.js"></script>

<link rel="stylesheet" href="<?php echo $this->Html->Url('/');?>popupjs/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $this->Html->Url('/');?>popupjs/jquery.fancybox.pack.js?v=2.1.5"></script>

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

	</style>


<?php 
		echo $this->Html->script('jquery.dataTables.min');
		echo $this->Html->script('jquery.dataTables.bootstrap');
?>


 <a href="<?php echo $this->Html->Url('/');?>BtlPromotions/export/"  style="float:right; margin-right:10px;"> <button class="btn btn-info">
											Export
											<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
										</button>

										</a>
<div class="row">

	<div class="col-xs-12">

	<div class="table-header">
		Results for "List of BTL Promotions"
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
			<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Remarks</th>
			
			<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Address</th>
			
			<th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Snapshot</th>
            <th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">User Details</th>
            <th  class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Delete</th>
		</tr>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all">
   

	<?php foreach($arrBtlPromotionDetail as $val) {?>
			<tr class="odd">
				<td class="center">
					<label>
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>

				<td class="sorting_1">
					<a href=""><?php echo $val['p']['remarks'];?></a>
				</td>
				<td class="" width="25%">
					<a href=""><?php echo $val['p']['address'];?></a>
				</td>

				<td> 
					<a href="<?php echo $this->Html->Url('/');?>apis/uploads/merchant/<?php echo $val['p']['encodeimage'];?>"  class="fancybox" > <img src="<?php echo $this->Html->Url('/');?>apis/uploads/merchant/<?php echo $val['p']['encodeimage'];?>" width="250" height="130" /></a>
                 
                    </td>
               <td>
                <p> Name:<br /> <?php echo  $val['b']['first_name'] ."\n". $val['b']['last_name'];  ?></p>
                <p> Designation: <br /><?php echo  $val['d']['designation']; ?></p>
                   
                <td> 
				<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
					
					
					
					<a class="btn btn-xs btn-danger" title="Delete" href="/btlPromotions/delete/<?php echo  $val['p']['id'];?>" onclick="if (confirm(&quot;Are you sure you wish to delete this?&quot;)) { return true; } return false;">
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>

					 <a class="fancybox fancybox.iframe" href="<?php echo $this->Html->Url('/');?>btlPromotions/mapView/<?php echo $val['p']['id'];?>"><button class="btn btn-success" >View On Map</button></a>

				</div>


 </td>
				</tr>
                
		<?php } ?>
        
		</tbody>
		</table>	
		
</div>
<p style="font-size:14px; color:#F00"><?php echo $this->Session->flash(); ?></p>
</div>
<script type="text/javascript">
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
