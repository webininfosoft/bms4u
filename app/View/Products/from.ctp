<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<h4 class="header green clearfix">
			Add Products
			<span class="block pull-right">
			</span>
		</h4>
		<form class="form-horizontal" role="form">
								<!-- #section:elements.form -->
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Name </label>

									<div class="col-sm-9">
										<input type="text" id="form-field-1" placeholder="Username" class="col-xs-10 col-sm-5" />
									</div>
								</div>
								

		<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Discription</label>

									<div class="col-sm-9">
										<div class="wysiwyg-editor" id="editor1"></div>
									</div>
								</div>
		<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Image</label>

									<div class="col-sm-9">
										<input type="file" id="form-field-1" placeholder="Username" class="col-xs-10 col-sm-5" />
									</div>
								</div>
		<div class="clearfix form-actions">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-info" type="button">
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
