<?php 
		echo $this->Html->script('jquery.dataTables.min');
		echo $this->Html->script('jquery.dataTables.bootstrap');
?>


<?php 
	if($this->Session->flash('delete')){
  echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>Branches has been Deleted</strong></div>";}?><div class="row">
   <a href="<?php echo $this->Html->Url('/');?>Branches/export/"  style="float:right; margin-right:10px;"> <button class="btn btn-info">
											Export
											<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
										</button>

										</a>
	<div class="col-xs-12">
     
			<div class="table-header">
				List of Branches   
               
            </div>	

			<div>
			<table id="Branch" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
			<thead>

				<tr role="row">
					<th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 59px;">
						<label>
							<input type="checkbox" class="ace">
							<span class="lbl"></span>
						</label>
					</th>
					<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 164px;" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Branch</th>
					
					<th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 164px;" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Edit</th>
                    <th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 164px;" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Delete</th>
                    
                    
				</tr>
			</thead>
			<tbody role="alert" aria-live="polite" aria-relevant="all">
      
					<?php foreach($BranchResults as $val) { ?>
               
					<tr class="odd">
						<td class="center">
							<label>
								<input type="checkbox" class="ace">
								<span class="lbl"></span>
							</label>
						</td>

						<td class="sorting_1">
							<?php echo $val['branches']['first_name'];?>
						</td>
						<td> 
						<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
							<button class="btn btn-xs btn-info">
								<a href="<?php echo $this->Html->Url('/');?>Branches/add/<?php echo $val['branches']['id'];?>">
									<i class="ace-icon fa fa-pencil bigger-120"></i>
								</a>
							</button>
						</div>
                        <?php echo $this->html->link('Edit', array('action'=>'add', $val['branches']['id'])); ?>
						 </td>
                         <td> 
						<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
							<button class="btn btn-xs btn-info">
								<a href="<?php echo $this->Html->Url('/');?>Branches/delete/<?php echo $val['branches']['id'];?>">
									<i class="ace-icon fa fa-pencil bigger-120"></i>
								</a>
							</button>
                            
						</div>
                        
                        <?php echo $this->html->link('Delete', array('action'=>'delete', $val['branches']['id'])); ?> 
						 </td>
                       
						</tr>
				<?php } ?>
				</tbody>
				</table>
            
			</div>
	</div>
</div>
<script type="text/javascript">
			jQuery(function($) {
				
				var oTable1 = $('#Branch').dataTable( {} );
				
				
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
