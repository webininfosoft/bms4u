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

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCX1SGbjQbXFBLjBa-6BQtE6TWZ-Vi6oGI&sensor=false"></script>
<script type="text/javascript">
//<![CDATA[

    var rootpath="<?php echo $this->Html->Url('/');?>";
	var latcenter="<?php echo $latcenter;?>";
    var longcenter="<?php echo $longcenter;?>";
	  
//]]>
</script>
<script>
	
function refreshUser()
{
	var userid=$('#userslist').val();

	if(userid!='0')
		loadUserMap(userid);
	else
	{
		var roleid=$('#parentDesignation').val();

		if(roleid)
		loadUser(roleid)
	}
}


	function loadUser1(data)
	{
	
		var arrDesignation = data.split('&&');



		if(arrDesignation[0]!=0)
		{	
		
			var selectedUser = '<?php echo $selectedUser;?>';	
			//$('#alluserattendance').show();
			$.post(rootpath+"users/allUser",{'designation_id':arrDesignation[0]},function(result){
					//alert(result);																	   
				$('#alluserattendance').html(result);
			 });
			
			//load(arrDesignation[0]);
			 $.post(rootpath+"users/loadUserByroleid1",{'designation_id':arrDesignation[0]},function(result){
				$('.designationTD').html(result).show();
			 });
		}	
		else
			$('.designationTD').html('').hide();
	}

/*


	function loadUser(data)
	{
	
		var arrDesignation = data.split('&&');



		if(arrDesignation[0]!=0)
		{	
			var selectedUser = '<?php //echo $selectedUser;?>';		
			load(arrDesignation[0]);
			 $.post(rootpath+"/users/loadUserByroleid",{'designation_id':arrDesignation[0]},function(result){
				$('.designationTD').html(result).show();
			 });
		}	
		else
			$('.designationTD').html('').hide();
	}
	
	function loadUserMap(userid)
	{
		if(userid!=0)
		{	
			var date=$('.date-picker').val();
			loadmapbyuser(userid,date);
			
		}	
	}
	*/
	
	
	

	
	
</script>



<script>
function  useridonchange()
{
	
 var userid=$('#userslist').val();
 var datefrom=$('#id-date-picker-1').val(); 
 var dateto=$('#id-date-picker-2').val();
 
 if(datefrom=='' && dateto=='')
 {
	alert('Please select a date');
 }
 else
 {
	window.location = rootpath+"users/exportUserAttendance/"+userid +"/"+datefrom+"/"+dateto;
 }
}


function  useridonchange1()
{
	//alert("selected user success");
 var userid1=$('#userslist').val();
 var date1=$('#id-date-picker-1').val(); 
 var date2=$('#id-date-picker-2').val();
 
$.post(rootpath+"users/allUser",{'userid':userid1,'start_date':date1,'end_date':date2},function(result){
					//alert(userid);																	   
				$('#alluserattendance').html(result);
			 });
//window.location = "http://cr.webininfosoft.com/Users/exportUserAttendance/"+userid +date1;
}
function  searchonchange1()
{
	//alert("selected user success");
 var userid1=$('#userslist').val();
 var date1=$('#id-date-picker-1').val(); 
 var date2=$('#id-date-picker-2').val();
 
$.post(rootpath+"users/allUser",{'userid':userid1,'start_date':date1,'end_date':date2},function(result){
					//alert(userid);																	   
				$('#alluserattendance').html(result);
			 });
//window.location = "http://cr.webininfosoft.com/Users/exportUserAttendance/"+userid +date1;
}
</script>
<div class="col-xs-12">
	<div class="col-sm-12">
		<div class="widget-box widget-color-blue">
			<div class="widget-header">
				<h4 class="widget-title">Track Users</h4>

				<span class="widget-toolbar">
					
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</span>
			</div>

			<div class="widget-body">
				<div class="widget-main">
						<div class="row">
							<div class="col-xs-8 col-sm-3">
								<label for="id-date-picker-1">Designation</label>
							</div>
							<div class="col-xs-8 col-sm-3">
								<label for="id-date-picker-2">Select User</label>
							</div>
							<div class="col-xs-8 col-sm-3">
								<label for="id-date-picker-2">Start Date</label>
							</div>
                            <div class="col-xs-8 col-sm-3">
								<label for="id-date-picker-2">End Date</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group">
									<select class="form-control" name='data[User][parent_role_id]'  onchange = 'loadUser1(this.value);' id="parentDesignation">
										<option value='' >----Select Designation----</option>
											<?php while(list($key,$val)=each($arrData)){ ?>
											<option value="<?php echo $val['Designation']['id'];?>"><?php echo $val['Designation']['designation'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group designationTD">
									<select class="form-control" id="userid" onchange = 'useridonchange1();'>
										<option value='' >----Select User----</option>								
									</select>
								</div>
							</div>
							<div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group">
									<input name="start_date" class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy">
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
							</div>
                            
                            <div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group">
									<input name="end_date" class="form-control date-picker" id="id-date-picker-2" type="text" data-date-format="dd-mm-yyyy">
									<span class="input-group-addon">
										<i class="fa fa-calendar bigger-110"></i>
									</span>
								</div>
							</div>
                            
			                       <div class="col-xs-8 col-sm-3">
								<!-- #section:plugins/date-time.datepicker -->
								<div class="input-group">

									<button class="btn btn-info" onclick="searchonchange1();return false;">
											Search
											<i class="ace-icon fa fa-search  align-top bigger-125 icon-on-right"></i>
									</button>

									 <button class="btn btn-info" onclick="useridonchange();">
											Export
											<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
										</button>

								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-8 col-sm-12">
								<div id="map" style=" height: 500px">
								<div class="alert alert-block alert-success">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>
										<p>
											Please Select Designation To get current locations of the users.
										</p>
									</div>
                                    
                                   <div id="alluserattendance">
								   
								   
								   
                                   </div> 
                                    
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
			jQuery(function($) {

				//link
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
				//or change it into a date range picker
				$('.input-daterange').datepicker({autoclose:true});

});
</script>