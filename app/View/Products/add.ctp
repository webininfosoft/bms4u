<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">
<script src="<?php echo $this->html->url('/');?>js/ace-extra.min.js"></script>
<script src="<?php echo $this->html->url('/');?>js/jquery.hotkeys.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>js/bootstrap-wysiwyg.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>js/ace-elements.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>js/ace.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>js/jquery.min.js" ></script>
<script src="<?php echo $this->html->url('/');?>assets/js/bootstrap.min.js" ></script>

  <script type="text/javascript">
			jQuery(function($){
	
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			//console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	}

	//$('#editor1').ace_wysiwyg();//this will create the default editor will all buttons

	//but we want to change a few buttons colors for the third style
	$('#editor1').ace_wysiwyg({
		toolbar:
		[
			'font',
			null,
			'fontSize',
			null,
			{name:'bold', className:'btn-info'},
			{name:'italic', className:'btn-info'},
			{name:'strikethrough', className:'btn-info'},
			{name:'underline', className:'btn-info'},
			null,
			{name:'insertunorderedlist', className:'btn-success'},
			{name:'insertorderedlist', className:'btn-success'},
			
			
			null,
			{name:'justifyleft', className:'btn-primary'},
			{name:'justifycenter', className:'btn-primary'},
			{name:'justifyright', className:'btn-primary'},
			
			null,
			{name:'createLink', className:'btn-pink'},
			
			null,
			{name:'insertImage', className:'btn-success'},
			null,
			'foreColor',
			null,
			
			
		],
		'wysiwyg': {
			fileUploadError: showErrorAlert
		}
	}).prev().addClass('wysiwyg-style2');

	
	/**
	//make the editor have all the available height
	$(window).on('resize.editor', function() {
		var offset = $('#editor1').parent().offset();
		var winHeight =  $(this).height();
		
		$('#editor1').css({'height':winHeight - offset.top - 10, 'max-height': 'none'});
	}).triggerHandler('resize.editor');
	*/
	

	$('#editor2').css({'height':'200px'}).ace_wysiwyg({
		toolbar_place: function(toolbar) {
			return $(this).closest('.widget-box')
			       .find('.widget-header').prepend(toolbar)
				   .find('.wysiwyg-toolbar').addClass('inline');
		},
		toolbar:
		[
			'bold',
			{name:'italic' , title:'Change Title!', icon: 'ace-icon fa fa-leaf'},
			'strikethrough',
			null,
			'insertunorderedlist',
			'insertorderedlist',
			null,
			'justifyleft',
			'justifycenter',
			'justifyright'
		],
		speech_button: false
	});
	
	


	$('[data-toggle="buttons"] .btn').on('click', function(e){
		var target = $(this).find('input[type=radio]');
		var which = parseInt(target.val());
		var toolbar = $('#editor1').prev().get(0);
		if(which >= 1 && which <= 4) {
			toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g , '');
			if(which == 1) $(toolbar).addClass('wysiwyg-style1');
			else if(which == 2) $(toolbar).addClass('wysiwyg-style2');
			if(which == 4) {
				$(toolbar).find('.btn-group > .btn').addClass('btn-white btn-round');
			} else $(toolbar).find('.btn-group > .btn-white').removeClass('btn-white btn-round');
		}
	});


	

	//RESIZE IMAGE
	
	//Add Image Resize Functionality to Chrome and Safari
	//webkit browsers don't have image resize functionality when content is editable
	//so let's add something using jQuery UI resizable
	//another option would be opening a dialog for user to enter dimensions.
	if ( typeof jQuery.ui !== 'undefined' && ace.vars['webkit'] ) {
		
		var lastResizableImg = null;
		function destroyResizable() {
			if(lastResizableImg == null) return;
			lastResizableImg.resizable( "destroy" );
			lastResizableImg.removeData('resizable');
			lastResizableImg = null;
		}

		var enableImageResize = function() {
			$('.wysiwyg-editor')
			.on('mousedown', function(e) {
				var target = $(e.target);
				if( e.target instanceof HTMLImageElement ) {
					if( !target.data('resizable') ) {
						target.resizable({
							aspectRatio: e.target.width / e.target.height,
						});
						target.data('resizable', true);
						
						if( lastResizableImg != null ) {
							//disable previous resizable image
							lastResizableImg.resizable( "destroy" );
							lastResizableImg.removeData('resizable');
						}
						lastResizableImg = target;
					}
				}
			})
			.on('click', function(e) {
				if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
					destroyResizable();
				}
			})
			.on('keydown', function() {
				destroyResizable();
			});
	    }

		enableImageResize();

		/**
		//or we can load the jQuery UI dynamically only if needed
		if (typeof jQuery.ui !== 'undefined') enableImageResize();
		else {//load jQuery UI if not loaded
			$.getScript($path_assets+"/js/jquery-ui.custom.min.js", function(data, textStatus, jqxhr) {
				enableImageResize()
			});
		}
		*/
	}


});
		</script> 
        
        <script>
$(document).ready(function(){
  $("#editor1").keyup(function(){
  	$('#proddesc').val( $(this).text());
  });
});
</script>
        
 

<?php 
if(@$permissions['perm_add'] != 1 || $this->Session->read('user.User.role_id') == 0){ ?>

 <?php if(isset($message)){
 echo   "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'><i class='ace-icon fa fa-times'></i></button><strong><i class=ace-icon fa fa-check></i>$message</strong></div>";}?>

			
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<h4 class="header green clearfix">
			Add Products
			<span class="block pull-right">
			</span>
		</h4>
		<form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
		<input type="hidden" name="data[Product][id]" value="<?php echo $arrProduct['id'];?>" />
								<!-- #section:elements.form -->
                                
                                
                                <div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SKU No. </label>

									<div class="col-sm-9">
										<input type="text" id="form-field-1" placeholder="SKU" value="<?php echo $arrProduct[sku];?>" class="col-xs-10 col-sm-5" name="data[Product][sku]" />
									</div>
								</div>
                                <div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Quantity</label>

									<div class="col-sm-9">
										<input type="text" id="form-field-1" value="<?php echo $arrProduct[qty_in_stock];?>" placeholder="Quantity" class="col-xs-10 col-sm-5" name="data[Product][qty_in_stock]" />
									</div>
								</div>
							
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product Name </label>

									<div class="col-sm-9">
										<input type="text" id="form-field-1" placeholder="Name" class="col-xs-10 col-sm-5" value="<?php echo $arrProduct[name];?>" name="data[Product][name]" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Price </label>

									<div class="col-sm-9">
										<input type="text" id="form-field-1" placeholder="Rs."  value="<?php echo $arrProduct[price];?>" class="col-xs-10 col-sm-5" name="data[Product][price]" />
									</div>
								</div>
								

		<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Discription</label>

									<div class="col-sm-9">
										<div class="wysiwyg-editor" id="editor1"><?php echo $arrProduct[description];?>
										<input type="hidden" id="proddesc" name="data[Product][description]" value="<?php echo $arrProduct['description'];?>" /></div>
									</div>
								</div>
                                	
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Discount</label>

									<div class="col-sm-9">
			<input type="text" id="form-field-1" value="<?php echo $arrProduct['discount'];?>" placeholder="Discount" class="col-xs-10 col-sm-5" name="data[Product][discount]" />
									</div>
								</div>
                                <div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Remark</label>

									<div class="col-sm-9">
										
                                        <textarea cols="40" rows="7" placeholder="Remark" name="data[Product][remark]">
                                        <?php echo $arrProduct['remark'];?>
                                        </textarea>
									</div>
								</div>
		<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Image</label>



									<div class="col-sm-9">
										<input type="file" id="form-field-1" name="data[Product][product_image]" class="col-xs-10 col-sm-5" />
									</div>
      <?php  if($arrProduct['product_image'])
	  {
		echo   " <div>
                  <img src='".$this->html->url('/')."images/upload/product/".$arrProduct['product_image']."' height='150' width='200'>
                  </div>";
	   }
	 ?>
 
		</div>
                                
		<div class="clearfix form-actions">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-info" type="submit">
											<i class="ace-icon fa fa-check bigger-110"></i>
											Submit
										</button>
                                    

										&nbsp; &nbsp; &nbsp;
										<button class="btn" type="reset">
											<i class="ace-icon fa fa-undo bigger-110"></i>
											Reset
										</button>
									</div>
								</div>
							</form>

		<script type="text/javascript">
			var $path_assets = "<?php echo $this->html->url('/');?>assets";//this will be used in loading jQuery UI if needed!
		</script>

		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->

	
                    
						
                             
                   

		


	<?php } 
	else { ?>
		<article class="module width_full" style="width: 75%;float: right;margin: 0px;margin-top:10px;">
		<header><h3 style="color: #1F1F20;text-transform: uppercase;text-shadow: 0 1px 0 #fff;font-size: 13px;margin-left: 10px;">Restricted This Page</h3></header>
					<div style="text-align:center">
						<img src="<?php echo $this->html->url('/img/restriction.jpg')?>" width="300"><br>Sorry, You are not autorized to access this page
					</div>
		</article>			
	<?php } ?>