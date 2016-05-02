jQuery(function($) {

	//editables on first profile page
	$.fn.editable.defaults.mode = 'inline';
	$.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
	$.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="ace-icon fa fa-check"></i></button>'+
								'<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';    
	
	//editables 
	
	

	$('#login').editable({
		type: 'slider',
		name : 'login',
		
		slider : {
			 min : 1,
			  max: 50,
			width: 100
			//,nativeUI: true//if true and browser support input[type=range], native browser control will be used
		},
		success: function(response, newValue) {
			if(parseInt(newValue) == 1)
				$(this).html(newValue + " hour ago");
			else $(this).html(newValue + " hours ago");
		}
	});


	
	
	// *** editable avatar *** //
	try {//ie8 throws some harmless exceptions, so let's catch'em

		//first let's add a fake appendChild method for Image element for browsers that have a problem with this
		//because editable plugin calls appendChild, and it causes errors on IE at unpredicted points
		try {
			document.createElement('IMG').appendChild(document.createElement('B'));
		} catch(e) {
			Image.prototype.appendChild = function(el){}
		}

		var last_gritter
		$('#avatar').editable({
			type: 'image',
			name: 'avatar',
			value: null,
			image: {
				//specify ace file input plugin's options here
				btn_choose: 'Change Avatar',
				droppable: true,
				maxSize: 440000,//~100Kb

				//and a few extra ones here
				name: 'avatar',//put the field name here as well, will be used inside the custom plugin
				on_error : function(error_type) {//on_error function will be called when the selected file has a problem
					if(last_gritter) $.gritter.remove(last_gritter);
					if(error_type == 1) {//file format error
						last_gritter = $.gritter.add({
							title: 'File is not an image!',
							text: 'Please choose a jpg|gif|png image!',
							class_name: 'gritter-error gritter-center'
						});
					} else if(error_type == 2) {//file size rror
						last_gritter = $.gritter.add({
							title: 'File too big!',
							text: 'Image size should not exceed 100Kb!',
							class_name: 'gritter-error gritter-center'
						});
					}
					else {//other error
					}
				},
				on_success : function() {
					$.gritter.removeAll();
				}
			},
			url: function(params) {
				// ***UPDATE AVATAR HERE*** //
				
					var submit_url = serverpath + 'users/fileUpload';//please modify submit_url accordingly
					var deferred = null;
					var avatar = '#avatar';

					//if value is empty (""), it means no valid files were selected
					//but it may still be submitted by x-editable plugin
					//because "" (empty string) is different from previous non-empty value whatever it was
					//so we return just here to prevent problems
					var value = $(avatar).next().find('input[type=hidden]:eq(0)').val();
					if(!value || value.length == 0) {
						deferred = new $.Deferred
						deferred.resolve();
						return deferred.promise();
					}

					var $form = $(avatar).next().find('.editableform:eq(0)')
					var file_input = $form.find('input[type=file]:eq(0)');
					var pk = $(avatar).attr('data-pk');//primary key to be sent to server

					var ie_timeout = null


					if( "FormData" in window ) {
						var formData_object = new FormData();//create empty FormData object
						
						//serialize our form (which excludes file inputs)
						$.each($form.serializeArray(), function(i, item) {
							//add them one by one to our FormData 
							formData_object.append(item.name, item.value);							
						});
						//and then add files
						$form.find('input[type=file]').each(function(){
							var field_name = $(this).attr('name');
							var files = $(this).data('ace_input_files');
							if(files && files.length > 0) {
								formData_object.append(field_name, files[0]);
							}
						});

						//append primary key to our formData
						formData_object.append('pk', pk);

						deferred = $.ajax({
									url: submit_url,
								   type: 'POST',
							processData: false,//important
							contentType: false,//important
							   dataType: 'json',//server response type
								   data: formData_object
						})
					}
					else {
						deferred = new $.Deferred

						var temporary_iframe_id = 'temporary-iframe-'+(new Date()).getTime()+'-'+(parseInt(Math.random()*1000));
						var temp_iframe = 
								$('<iframe id="'+temporary_iframe_id+'" name="'+temporary_iframe_id+'" \
								frameborder="0" width="0" height="0" src="about:blank"\
								style="position:absolute; z-index:-1; visibility: hidden;"></iframe>')
								.insertAfter($form);
								
						$form.append('<input type="hidden" name="temporary-iframe-id" value="'+temporary_iframe_id+'" />');
						
						//append primary key (pk) to our form
						$('<input type="hidden" name="pk" />').val(pk).appendTo($form);
						
						temp_iframe.data('deferrer' , deferred);
						//we save the deferred object to the iframe and in our server side response
						//we use "temporary-iframe-id" to access iframe and its deferred object

						$form.attr({
								  action: submit_url,
								  method: 'POST',
								 enctype: 'multipart/form-data',
								  target: temporary_iframe_id //important
						});

						$form.get(0).submit();

						//if we don't receive any response after 30 seconds, declare it as failed!
						ie_timeout = setTimeout(function(){
							ie_timeout = null;
							temp_iframe.attr('src', 'about:blank').remove();
							deferred.reject({'status':'fail', 'message':'Timeout!'});
						} , 30000);
					}


					//deferred callbacks, triggered by both ajax and iframe solution
					deferred
					.done(function(result) {
						//success
						var res = result[0];//the `result` is formatted by your server side response and is arbitrary
						if(res.status == 'OK') $(avatar).get(0).src = res.url;
						else alert(res.message);
					})
					.fail(function(result) {//failure
						//alert("There was an error");
					})
					.always(function() {//called on both success and failure
						if(ie_timeout) clearTimeout(ie_timeout)
						ie_timeout = null;	
					});

					return deferred.promise();
					// ***END OF UPDATE AVATAR HERE*** //
				
				// ***END OF UPDATE AVATAR HERE*** //
			},
			
			success: function(response, newValue) {

			}
		})
	}catch(e) {}
	
	

	//another option is using modals
	$('#avatar2').on('click', function(){
		var modal = 
		'<div class="modal fade">\
		  <div class="modal-dialog">\
		   <div class="modal-content">\
			<div class="modal-header">\
				<button type="button" class="close" data-dismiss="modal">&times;</button>\
				<h4 class="blue">Change Avatar</h4>\
			</div>\
			\
			<form class="no-margin">\
			 <div class="modal-body">\
				<div class="space-4"></div>\
				<div style="width:75%;margin-left:12%;"><input type="file" name="file-input" /></div>\
			 </div>\
			\
			 <div class="modal-footer center">\
				<button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Submit</button>\
				<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
			 </div>\
			</form>\
		  </div>\
		 </div>\
		</div>';
		
		
		var modal = $(modal);
		modal.modal("show").on("hidden", function(){
			modal.remove();
		});

		var working = false;

		var form = modal.find('form:eq(0)');
		var file = form.find('input[type=file]').eq(0);
		file.ace_file_input({
			style:'well',
			btn_choose:'Click to choose new avatar',
			btn_change:null,
			no_icon:'ace-icon fa fa-picture-o',
			thumbnail:'small',
			before_remove: function() {
				//don't remove/reset files while being uploaded
				return !working;
			},
			allowExt: ['jpg', 'jpeg', 'png', 'gif'],
			allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
		});

		form.on('submit', function(){
			if(!file.data('ace_input_files')) return false;
			
			file.ace_file_input('disable');
			form.find('button').attr('disabled', 'disabled');
			form.find('.modal-body').append("<div class='center'><i class='ace-icon fa fa-spinner fa-spin bigger-150 orange'></i></div>");
			
			var deferred = new $.Deferred;
			working = true;
			deferred.done(function() {
				form.find('button').removeAttr('disabled');
				form.find('input[type=file]').ace_file_input('enable');
				form.find('.modal-body > :last-child').remove();
				
				modal.modal("hide");

				var thumb = file.next().find('img').data('thumb');
				if(thumb) $('#avatar2').get(0).src = thumb;

				working = false;
			});
			
			
			setTimeout(function(){
				deferred.resolve();
			} , parseInt(Math.random() * 800 + 800));

			return false;
		});
				
	});

	

	//////////////////////////////
	$('#profile-feed-1').ace_scroll({
		height: '250px',
		mouseWheelLock: true,
		alwaysVisible : true
	});

	$('a[ data-original-title]').tooltip();

	$('.easy-pie-chart.percentage').each(function(){
	var barColor = $(this).data('color') || '#555';
	var trackColor = '#E2E2E2';
	var size = parseInt($(this).data('size')) || 72;
	$(this).easyPieChart({
		barColor: barColor,
		trackColor: trackColor,
		scaleColor: false,
		lineCap: 'butt',
		lineWidth: parseInt(size/10),
		animate:false,
		size: size
	}).css('color', barColor);
	});
  
	///////////////////////////////////////////

	//right & left position
	//show the user info on right or left depending on its position
	$('#user-profile-2 .memberdiv').on('mouseenter touchstart', function(){
		var $this = $(this);
		var $parent = $this.closest('.tab-pane');

		var off1 = $parent.offset();
		var w1 = $parent.width();

		var off2 = $this.offset();
		var w2 = $this.width();

		var place = 'left';
		if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) place = 'right';
		
		$this.find('.popover').removeClass('right left').addClass(place);
	}).on('click', function(e) {
		e.preventDefault();
	});


	///////////////////////////////////////////
	$('#user-profile-3')
	.find('input[type=file]').ace_file_input({
		style:'well',
		btn_choose:'Change avatar',
		btn_change:null,
		no_icon:'ace-icon fa fa-picture-o',
		thumbnail:'large',
		droppable:true,
		
		allowExt: ['jpg', 'jpeg', 'png', 'gif'],
		allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
	})
	.end().find('button[type=reset]').on(ace.click_event, function(){
		$('#user-profile-3 input[type=file]').ace_file_input('reset_input');
	})
	.end().find('.date-picker').datepicker().next().on(ace.click_event, function(){
		$(this).prev().focus();
	})
	$('.input-mask-phone').mask('(999) 999-9999');



	////////////////////
	//change profile
	$('[data-toggle="buttons"] .btn').on('click', function(e){
		var target = $(this).find('input[type=radio]');
		var which = parseInt(target.val());
		$('.user-profile').parent().addClass('hide');
		$('#user-profile-'+which).parent().removeClass('hide');
	});
});
