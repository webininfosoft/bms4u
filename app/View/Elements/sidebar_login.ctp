<div id="sidebar" class="sidebar responsive">
<script type="text/javascript">
    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
</script>

<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success">
            <i class="ace-icon fa fa-signal"></i>
        </button>

        <button class="btn btn-info">
            <i class="ace-icon fa fa-pencil"></i>
        </button>

        <button class="btn btn-warning">
            <i class="ace-icon fa fa-users"></i>
        </button>

        <button class="btn btn-danger">
            <i class="ace-icon fa fa-cogs"></i>
        </button>
    </div>

    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
    </div>
</div><!-- /.sidebar-shortcuts -->


<ul class="nav nav-list">
<?php while(list($key,$val)=each($arrCompanyModules)){?>

<?php if($val['modules']['submenu']==0){ ?>
 <li class="hover">
        <a href="<?php echo $this->html->url('/'); ?><?php echo $val['modules']['link'];?>"> 
            <i class="menu-icon fa <?php echo $val['modules']['icon'];?>"></i>
            <span class="menu-text"><?php echo ucwords(strtolower($val['modules']['module_name']));?></span></a>
        <b class="arrow"></b>
    </li>
<?php } else { ?>
 <li class="hover">
	 <a href="<?php echo $this->html->url('/'); ?><?php echo $val['modules']['link'];?>" class="dropdown-toggle"> 
            <i class="menu-icon fa <?php echo $val['modules']['icon'];?>"></i>
            <span class="menu-text"><?php echo ucwords(strtolower($val['modules']['module_name']));?></span>
            <b class="arrow fa fa-angle-right"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
	<?php while(list($key1,$val1)=each($val['modules']['submenu'])){
	?>

            <li class="">
		  <a href="<?php echo $this->html->url('/'); ?><?php echo $val1['modules']['link'];?>"> 
                    <i class="menu-icon fa <?php echo $val1['modules']['icon'];?>"></i>
                  <?php echo ucwords(strtolower($val1['modules']['module_name']));?>
                </a>
                <b class="arrow"></b>
            </li>

	    <?php }?>
            
        </ul>
    </li>


<?php } }?>
   
    
</ul><!-- /.nav-list -->

<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>

<script type="text/javascript">
    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
</script>
</div>