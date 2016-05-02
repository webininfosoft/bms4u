

<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
 <?php
 if(isset($message1)){
 echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>
<strong><i class='ace-icon fa fa-times'></i>$message1</strong></div>";}?>


	<div class="col-xs-12">
	 
	<div class="form-ct" id="ct-form-ct">

		        <form method="post" action="" class="form-m">
				<input type="hidden" name="data[Designation][id]" value="<?php echo $des['Designation']['id']; ?>" />
				<ol>
				<li><label class="small">Designation</label><input type="text" class="small-full"  name="data[Designation][designation]" value="<?php echo $des['Designation']['designation']; ?>" required/>
				</li>
				<li><label class="small">Parent</label>
                <?php 
				if(!empty($des['DesignationsParent'])){
						foreach($des['DesignationsParent'] as $desg){
							$uAllDes[]=$desg['parent_id'];
						}
						
						//print_r($uAllDes);
					}
				?>
				<select name="data[Designation][parent_designation_id]" class="form-control" style="width:54%">
					<option value='0'>----Select Parent----</option>
                
                    <?php 
					
					foreach($designation as $val): 
						//echo $val['Designation']['id'];
					?>
                   <?php if (in_array($val['Designation']['id'],$uAllDes)): ?>
	<option value="<?php echo  $val['Designation']['id']; ?>" selected="selected" ><?php echo $val['Designation']['designation'];?></option>
    <?php else: ?>
    <option value="<?php echo $val['Designation']['id']; ?>"><?php echo $val['Designation']['designation']; ?></option>
					<?php endif; ?>
						<?php endforeach; ?>
                   
				</select>
				</li>					
				   <li><label class="small"></label>
				   <?php if($des['Designation']['id']){?>
				   <input type="submit" class="login" value="Update">
				   <?php }else{?>
				   <input type="submit" class="login" value="Submit">
				   <?php }?>
				   
				   </li>
				</ol>
			</form>

	</div>
</div>
</div>