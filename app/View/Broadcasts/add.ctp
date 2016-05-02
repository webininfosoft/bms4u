	<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo $this->html->url('/');?>/assets/js/jquery.min.js>"+"<"+"/script>");
		</script>
       <script src="<?php echo  $this->html->url('/');?>assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
       <script src="<?php echo  $this->html->url('/');?>assets/js/jquery.autosize.min.js"></script>

	<script src="<?php echo $this->html->url('/');?>assets/js/ace-elements.min.js"></script>
	<script type="text/javascript">
			jQuery(function($) {
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {}
			 drawPieChart(placeholder, data);
			
		
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
			    
				$('textarea[class*=autosize]').autosize({append: "\n"});
				$('textarea.limited').inputlimiter({
					remText: '%n character%s remaining...',
					limitText: 'max allowed : %n.'
				});
			})
			
		</script>
        <script language="javascript">
$(function(){
   $('#check').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        }
        if(!this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = false;                        
            });
        }
    });
});
</script>
 <script language="javascript" type="text/javascript">  
    var table3Filters = {  
        col_0: "select",  
        col_4: "none",  
        btn: true  
    }  
    var tf03 = new TF("table_format",2,table3Filters);  
    tf03.AddGrid(); 
</script>  
<script>
function loadUser(data){
location.href="<?php echo $this->html->url('/');?>Broadcasts/add/"+$('#parentDesignation').val();
 }
 </script>
		

<?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class='ace-icon fa fa-check'></i>$message</strong></div>";}?>
 <?php
 if(isset($message1)){
 echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button>
<strong><i class='ace-icon fa fa-times'></i>$message1</strong></div>";}?>

<form method="post" action="" > 
<input type="hidden" name="data[Broadcast][date_time]" />
<div class="col-sm-12">
<div class="widget-box">
<div class="widget-header">
<h4 class="widget-title lighter smaller">
<i class="ace-icon fa fa-comment blue"></i>
Write Message
</h4>

</div>

<div class="widget-body">
<div class="widget-main no-padding">



<div class="widget-body">
												<div class="widget-main">
													

													
													<!-- #section:plugins/input.limiter -->
													<div style="padding:10px;">
														<label for="form-field-9">Max Character Limit 4000 word</label>
<textarea  class="form-control limited" id="form-field-9" required="required" name="data[Broadcast][message]"maxlength="4000" rows="5"></textarea>
													</div>

													<!-- /section:plugins/input.limiter -->
													<hr />

													<!-- #section:plugins/input.autosize -->
													
													<!-- /section:plugins/input.autosize -->
												</div>
											</div>

</div><!-- /.widget-main -->
</div><!-- /.widget-body -->
</div><!-- /.widget-box -->
</div>
<div class="col-sm-12">
<div class="widget-box">
<div class="widget-header">

<h4 class="widget-title lighter smaller">
<i class="ace-icon fa fa-comment blue"></i>
Select Users
</h4>

</div>


<div class="widget-body">

<div class="widget-main no-padding">

<!-- #section:pages/dashboard.conversations -->

							
								<div class="input-group">
                                <span style="margin-left:30px;">Filter By Designation</span>
									<select class="form-control" name="" onchange="loadUser(this.value);" id="parentDesignation" style="margin-top:0px; margin-left:30px;">
										<option value="">----Select Designation----</option>
                                        <?php while(list($key,$val)=each($designation)){
										if($val['designations']['id']==$designationid){
										$Selected="Selected";
										}
										else
										$Selected='';
										
										?>
                                        <option <?php echo $Selected;?> value="<?php echo $val['designations']['id'];?>"><?php echo $val['designations']['designation'];?></option>
                                        <?php } ?>
                                        </option>
																						
																			</select>
								</div>
							
                            
                            
                            
                            <div class="dialogs">
<table width="100%" class="table table-striped table-bordered" cellspacing="0" id="table_format" cellpadding="0">
<tr>
<th><input type="checkbox"  name="all" id="check"  for='all'/></th> 
<th>User</th>
<th>Designation</th>
<th>Phone Number</th>

</tr>
<?php 
while(list($key,$val)=each($userlist)) { ?>
<tr> 
<td><input type="checkbox" name="data[Broadcast][gcmids][]"  value="<?php echo $val['u']['gcmid']?>" /></td>
<td><?php echo $val['up']['first_name']."\n\n	". $val['up']['last_name']; ?></td>
<td><?php echo $val['d']['designation'];?></td>
<td><?php echo $val['up']['phone'];?></td>
</tr>

<?php } ?>
</table>
</div>

</div><!-- /.widget-body -->
</div><!-- /.widget-box -->
</div>
</div>
</div>



<span class="input-group-btn">
<center><button class="btn btn-sm btn-info no-radius" style=" margin-top:10px;" type="submit">
<i class="ace-icon fa fa-share"></i>
Send
</button>
</center>
</span>


</div>


</form>
