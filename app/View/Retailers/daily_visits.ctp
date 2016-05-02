<script src="<?php echo $this->Html->Url('/');?>popupjs/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->Html->Url('/');?>popupjs/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $this->Html->Url('/');?>popupjs/jquery.fancybox.pack.js?v=2.1.5"></script>

<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();

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
  echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>The retailer_daily_visits has been deleted</strong><br></div>";}?>
 <a href="<?php echo $this->Html->Url('/');?>retailer_daily_visits/export/"  style="float:right; margin-right:10px;"> 
 <button class="btn btn-info">Export<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
</button>
</a>

	<div class="col-xs-12">

	<div class="table-header">
		Results for "List of Retailer Visits"
	</div>	
	<table id="designation" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
	<thead>
   <th class=" sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label=""><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
   <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Date/Time</th>
   <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Retailer Images</th>

	</thead><tbody role="alert" aria-live="polite" aria-relevant="all">
   <?php foreach($Retailer as $val) {

	?>
			<tr>
				<td>
					<label><input type="checkbox" class="ace"><span class="lbl"></span></label>
				</td>
				
                <td class="sorting_1"><?php ?>
			                <?php echo $val['retailer_daily_visits']['created_at']; ?>
<td>
                <?php if($val['retailer_daily_visits']['retailer_visit_image']!=''){
			          echo   "<a href='".$this->Html->Url('/')."apis/uploads/retailers/".$val['retailer_daily_visits']['retailer_visit_image']."'   class='fancybox'><img src='".$this->Html->Url('/')."apis/uploads/retailers/thumbnails/".$val['retailer_daily_visits']['retailer_visit_image']."' height='100' width='100'/></a>";
			}?>
				
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
