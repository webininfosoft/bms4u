<form class="form-horizontal"  action="" method="post">
<input type="hidden"  value="<?php echo $intCompanyId;?>" name="company_id" id="txtcompanyid"/>
<?php foreach($arrModule as $val) {} ?>
<div class="col-xs-12">

<label>Companies</label>
<select id="cmbCompanies">
<option>Select Company</option>
<?php foreach($arrCompanies as $val) {?>

 <option  <?php if($val['User']['id']==$intcompanyId){?>selected<?php }?> value="<?php echo $val['User']['id'];?>"><?php echo $val['UserProfile']['first_name']." ".$val['UserProfile']['last_name'];?></option>
<?php } ?>
</select>
<br/><br/>
<table id="sample-table-1" class="table table-striped table-bordered table-hover" >
<thead>
	<tr>
		<th class="center">
			<label class="position-relative">
				<input type="checkbox" class="ace checkall" >
				<span class="lbl"></span>
			</label>
		</th>
		<th>Module</th>
		
	</tr>
</thead>

<tbody>
<?php foreach($arrModule as $val) {?>

	<tr>
		<td class="left">
			<label class="position-relative">
				<input type="checkbox" <?php if(in_array($val['Module']['slug'],$arrExistModule)){?>checked<?php }?> class="ace acechecks" name="module_id[]"  value="<?php echo $val['Module']['slug'] ?>">
				<span class="lbl"></span>
			</label>
		</td>
		<td style="text-align:left;">
		 <?php echo ucwords(strtolower($val['Module']['module_name']));?>

		</td>

		
	</tr>
<?php } ?>
</tbody>
</table>


<button type="submit" id="loading-btn" class="width-35 pull-right btn btn-sm btn-primary">
	<i class="ace-icon fa fa-key"></i>
	<span class="bigger-110">Update Modules</span>
</button>
</div>

</form>
