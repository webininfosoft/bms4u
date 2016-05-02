<script>
function confirmChanges()
{
	var userType = $('#user_type').val();
	if(userType)
	{
		var confirmation = confirm('Are you sure you want to make these changes');
		if(confirmation)
			$('#authenticationForm').submit();
	}
	else
		alert('Please Select User Role');
	
}
function loadPermissions(userTypeId)
{
	if(userTypeId)
	{	
		$('.check').prop('disabled',true);
		location.href="<?php echo $this->html->url('/');?>Authentications/mobileApp/"+userTypeId;
	}
}
</script>
<div id="content" class="span10">
	<div class="box span12" style="margin-left:0;display:<?php echo $message?'block':'none'?>">
		<div class="box-header well">
			<h2><?php echo $message;?></h2>
			<div class="box-icon">				
				<a href="#" class="btn btn-close btn-round" onclick="$(this).parent().parent().parent().fadeOut('500'); return false;">Hide</a>
			</div>		
		</div>
	</div>
	
	<form action="" method="post" id="authenticationForm">
	<div class="box span12" style="margin-left:0;">
		<div class="box-header well">
			<header><h3 style="color: #1F1F20;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;">Set Privilidges
				<span style="float:right;margin-right:10px;">
					<select name="user_type_id" id="user_type" onchange="loadPermissions(this.value);return false;">
						<option value=''>----Select User Role----</option>
						<?php while(list($key,$val)=each($userTypes)){ ?>
							<option value="<?php echo $val['Designation']['id'];?>" <?php echo $val['Designation']['id']==$user_type_id?'selected':''?>><?php echo $val['Designation']['designation'];?></option>
						<?php } ?>
					</select>
				
					<input type="button" value="Save" style="width:75px;height: 30px;padding: 2px;" class="btn btn-large btn-success" onclick="confirmChanges();return false;">
				</span>
            </h3>
			</header>
		</div>
		<div class="box-content">
			<input type="checkbox" id="checkall"/>Check All<br/>
			<table width="100%" cellspacing="1" id="table_format" class='authtable' align="left" style="">
					<tr align="left">		    						
						<th>Module</th>
						<th>Add</th>
						<th>View</th>
						
					</tr>	
				<?php while(list($key,$val)=each($modules)) 
				{
					$id=$val['company_module']['module_id'];
					
				?>
					<tr align="left">	
						<td><?php echo ucwords(strtolower($val['modules']['module_name']));?></td>
						<td><input type="checkbox" name="perm[<?php echo $key;?>][perm_add]"  <?php echo $permissions[$id]['perm_add']?'checked':'' ?> class="check"></td>	
						<td><input type="checkbox" name="perm[<?php echo $key;?>][perm_view]"  <?php echo $permissions[$id]['perm_view']?'checked':'' ?> class="check"></td>
											
					</tr>
				<?php } ?>
			</table>			
		</div>
	</div>
	</form>
</div>		
<script>
$('#checkall').change(function() {

    if ($(this).is(':checked')) {
        $('div input').prop('checked',true);
    } else {

        $('div input').removeAttr('checked');
    }
});

$('.check ').click(function() {

    if ($(this).is(':checked')) {
        $(this).prop('checked',true);
    } else {

        $(this).removeAttr('checked');
    }
});
</script>	