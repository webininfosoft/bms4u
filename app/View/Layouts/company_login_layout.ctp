<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('ace.min');
		echo $this->Html->css('font-awesome');
		echo $this->Html->css('style');
		
		echo $this->Html->script('jquery-2.0.3');
		echo $this->Html->script('jquery.dataTables.min');
		echo $this->Html->script('jquery.dataTables.bootstrap');
	?>

</head>
<body>
<?php echo $this->element('sidebar_login'); ?>

<!--=========================
      Container ct
==============================-->
      <div class="container">
        <div class="container-in">
		<?php //echo $this->element('header_login'); ?>
	       <!--  List menu  -->
             <nav class="list-ct">
               <ul>
                 <li class="f-child"><a href="#">Home</a></li>
                  <li><a href="#">Dashboard</a></li>
               </ul>
             </nav>
           <!--  List menu ENd  -->
		   
           <!--  Content ct  -->
             <article class="content-ct">
               <?php echo $this->fetch('content'); ?>
			 </article>
           <!--  Content ct ENd  -->
        </div>
      </div>
<!--=========================
      Container ct ENd
==============================-->
</body>
</html>
