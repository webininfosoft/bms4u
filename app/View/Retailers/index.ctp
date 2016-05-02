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

<?php 
	if($this->Session->flash('bad')){
  echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>The Retailers has been deleted</strong><br></div>";}?>
 <a href="<?php echo $this->Html->Url('/');?>Retailers/export/"  style="float:right; margin-right:10px;"> 
 <button class="btn btn-info">Export<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
</button>
</a>

	<div class="col-xs-12">

	<div class="table-header">
		Results for "List of Sites"
	</div>	
	<table id="designation" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
	<thead>
   <th class=" sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label=""><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
   <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Site Name</th>
   <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Created By</th>
   <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Site Images</th>
   <th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Actions</th>
	</thead><tbody role="alert" aria-live="polite" aria-relevant="all">
   <?php foreach($Retailer as $val) {

	?>
			<tr>
				<td>
					<label><input type="checkbox" class="ace"><span class="lbl"></span></label>
				</td>

				<td class="sorting_1">
					<?php echo $val['retailers']['shop_name'];?><br/>
					<b>Contact Person:</b>&nbsp;<?php echo $val['retailers']['owner_name'];?>
					<p><b>Location:</b>&nbsp;<?php echo $val['retailers']['address'];?><br/>
					<b>Phone:</b>&nbsp;<?php echo $val['retailers']['phone'];?>
					<b>Email:</b>&nbsp;<?php echo $val['retailers']['email'];?></p>
				</td>
				
				<td class="sorting_1">
					<?php echo $val['user_profiles']['first_name']." ".$val['user_profiles']['last_name'];?>
					<p><?php echo $val['user_profiles']['phone'];?></p>
				
				</td>
				<td class="sorting_1"><?php ?>
				<?php if($val['retailers']['owner_image']!='') 
				{
				 echo "<a href='".$this->html->url('/')."apis/uploads/retailers/".$val['retailers']['owner_image']."'  class='fancybox' ><img src='".$this->html->url('/')."apis/uploads/retailers/thumbnails/".$val['retailers']['owner_image']."' height='100' width='100'/></a>";
						 
				}
				?>
				&nbsp; &nbsp; &nbsp; &nbsp;
				<?php if($val['retailers']['shop_image']!=''){
						  echo   "<a href='".$this->Html->Url('/')."apis/uploads/retailers/".$val['retailers']['shop_image']."'  class='fancybox' ><img src='".$this->Html->Url('/')."apis/uploads/retailers/thumbnails/".$val['retailers']['shop_image']."' height='100' width='100'/></a>";
					}?>
				
				</td>
				<td> 
				
						<a href="<?php echo $this->Html->Url('/');?>Retailers/dailyVisits/<?php echo $val['retailers']['sync_id'];?>"><button class="btn btn-info" id="">Daily Visits</button></a>,&nbsp;

						
						<a class="fancybox fancybox.iframe" href="<?php echo $this->Html->Url('/');?>Retailers/map_view/<?php echo $val['retailers']['id'];?>"><button class="btn btn-success" >View On Map</button></a>

						<a class="btn btn-xs btn-info" title="Edit" href="<?php echo $this->Html->Url('/');?>Retailers/add/<?php echo $val['retailers']['id'];?>"><i class="ace-icon fa fa-pencil bigger-120"></i></a>
						<?php //echo $this->html->link('Edit', array('action'=>'add', $val['Designation']['id'])); ?>
						<a class="btn btn-xs btn-danger" title="Delete" href="<?php echo $this->Html->Url('/');?>Retailers/delete/<?php echo $val['retailers']['id'];?>" onclick='if (confirm("Are you sure you wish to delete this?")) { return true; } return false;'>
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>
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

			});
</script>
