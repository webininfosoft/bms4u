<?php 
		echo $this->Html->script('jquery.dataTables.min');
		echo $this->Html->script('jquery.dataTables.bootstrap');
?>
<?php 
	if($this->Session->flash('delete')){
  echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>Broadcast  has been Deleted</strong></div>";}?>
  <a href="<?php echo $this->Html->Url('/');?>Broadcasts/export/"  style="float:right; margin-right:10px;"> <button class="btn btn-info">
											Export
											<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
										</button>

										</a>
 
	<div class="col-xs-12">
     

<span class="input-group-btn" style="margin-right:300px;">
<a href="http://cr.webininfosoft.com/Broadcasts/add">
<button class="btn btn-sm btn-info no-radius" type="submit">
<i class="ace-icon fa fa-share"></i>
Send Messages
</button>
</a>
</span>

	<div class="table-header">
		Results for "List of Messages"
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
			<th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 164px;" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Messages</th>
            <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 164px;" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Date</th>
			
		
            <th  class="sorting_disabled" role="columnheader" tabindex="0" aria-controls="sample-table-2" rowspan="1" colspan="1" style="width: 164px;" aria-sort="descending" aria-label="Domain: activate to sort column ascending">Delete</th>
		</tr>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all">
    
			<?php foreach($BroadcastResult as $val) { ?>
		
			<tr class="odd">
				<td class="center">
					<label>
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>

				<td class="sorting_1">
					<a href=""><?php echo $val['Broadcast']['message'];?></a>
				</td>
                <td>
                <?php echo $val['Broadcast']['date_time']; ?>
                </td>
				
                <td>
                <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                  <button class="btn btn-xs btn-info">
						<a href="<?php echo $this->Html->Url('/');?>Designations/delete/<?php echo $val['Broadcast']['id'];?>">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
						</a>
					</button>
                    </div>
                    <?php echo $this->html->link('Delete', array('action'=>'delete',$val['Broadcast']['id'])); ?>
                </td>
                
				</tr>
		<?php } ?>
		</tbody>
		</table>	
		
</div>
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
