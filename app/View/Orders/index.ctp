<?php 
		echo $this->Html->script('jquery.dataTables.min');
		echo $this->Html->script('jquery.dataTables.bootstrap');
?>


 <a href="<?php echo $this->Html->Url('/');?>Orders/export/"  style="float:right; margin-right:10px;"> <button class="btn btn-info">
											Export
											<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
										</button>

										</a>
	<div class="col-xs-12">

	<div class="table-header">
		Results for "List of Orders"
	</div>	
	<table id="designation" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
	<thead>
   <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 10px; margin-bottom:50px;">
				<label>
					<input type="checkbox" class="ace">
					<span class="lbl"></span>
				</label>
			</th>
			<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Order ID</th>
            <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Retailers Name</th>
                        <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">FOS Name</th>

			<th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Order Date</th>
            <th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Price</th>
            <th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">Discount</th>
            <th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1"  aria-sort="descending" aria-label="Domain: activate to sort column ascending">View</th>
		
</thead>
<tbody role="alert" aria-live="polite" aria-relevant="all">

<?php foreach($arrOrders as $val) {?>

				<tr class="odd">
                <td>
					<label><input type="checkbox" class="ace"><span class="lbl"></span></label>
				</td>
                <td class="sorting_1"><?php echo $val['o']['id']; ?></td>
                <td><?php echo $val['up']['shop_name']; ?></td>
                <td><?php echo $val['o']['fosname']."(".$val['o']['fosdesg'].")"; ?></td>
                <td><?php  echo $val['o']['date_time']; ?></td>
                <td><?php echo $val['o']['net_amount']; ?></td>
                <td><?php echo $val['o']['discount'];?></td>
                <td> 
				<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
					<button class="btn btn-xs btn-info">
						<a href="<?php echo $this->Html->Url('/');?>Orders/viewAllOrderDeatils/<?php echo $val['o']['id'];?>">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
					</button>
				</div>
				<?php echo $this->html->link('View Detail', array('action'=>'viewallorderdeatil', $val['o']['id'])); ?>
                </td>
				</tr>
           <?php } ?>
</tbody></table>
</div>
<p style="font-size:14px; color:#F00"><?php echo $this->Session->flash(); ?></p>


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
