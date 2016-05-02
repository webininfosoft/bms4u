<?php 
		echo $this->Html->script('jquery.dataTables.min');
		echo $this->Html->script('jquery.dataTables.bootstrap');
?>
<?php 
	if($this->Session->flash('delete')){
  echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>Designation has been Deleted</strong></div>";
  }
  
  if($this->Session->flash('Succsess')){
  echo   "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong>&nbsp;<i class='ace-icon fa fa-times'></i>&nbsp;Please asign a Parent for Retailer.</strong></div>";
  }
  
  ?>
  
	<div class="col-xs-12">

	<div class="table-header">
		Results for "List of Designations"
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
			<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 164px;" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Designation</th>
		
            <th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 164px;" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Action</th>
		</tr>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all">
    
			<?php 
			//print_r($designationResults);
			foreach($designationResults as $val) { 
			//echo '<pre>';
			// print_r($val);
			 //echo '</pre>';
			 ?>
		
			<tr class="odd">
				<td class="center">
					<label>
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>

				<td class="sorting_1">
					<?php echo $val['Designation']['designation'];?>
				</td>
				<td> 
				
					
						<a class="btn btn-xs btn-info" title="Edit" href="<?php echo $this->Html->Url('/');?>Designations/add/<?php echo $val['Designation']['id'];?>">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
                            
						</a>
				<?php //echo $this->html->link('Edit', array('action'=>'add', $val['Designation']['id'])); ?>
              
						<a class="btn btn-xs btn-danger" title="Delete" href="<?php echo $this->Html->Url('/');?>Designations/delete/<?php echo $val['Designation']['id'];?>" onclick='if (confirm("Are you sure you wish to delete this?")) { return true; } return false;'>
							<i class="ace-icon fa fa-trash-o bigger-120"></i>
						</a>
              
                </td>
                
				</tr>
		<?php } ?>
		</tbody>
		</table>	
		
</div>
</div>
<script type="text/javascript">
			jQuery(function($) {
				var oTable1 = $('#designation').dataTable();
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
