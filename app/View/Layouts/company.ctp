<!doctype html>
<!--[if lt IE 7 ]> <html class="ie ie6" lang="ru"> <![endif]-->
<!--[if IE 7 ]> <html class="ie ie7" lang="ru"> <![endif]-->
<!--[if IE 8 ]> <html class="ie ie8" lang="ru"> <![endif]-->
<!--[if IE 9 ]> <html class="ie ie9" lang="ru"> <![endif]-->
<!--[if gt IE 9]><!--><html lang="ru"><!--<![endif]-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('style');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
	?>


</head>
<body>
	<div id="header">
		
	</div>
	<div id="container">
		<div id="content">
		
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		
		</div>
	</div>
</body>
</html>
