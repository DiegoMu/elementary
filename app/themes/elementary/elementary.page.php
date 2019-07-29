<!DOCTYPE html>
<html>
<head>
	<title><?=$site_name?></title>
	<?php foreach ($resources['js'] as $js_resource) :?>
	<script type="text/javascript" src="<?=$js_resource?>"></script>
	<?php endforeach; ?>
	<?php foreach ($resources['css'] as $css_resource) :?>
	<link rel="stylesheet" type="text/css" href="<?=$css_resource?>">
	<?php endforeach; ?>
</head>
<body>
	<div class="<?=$container_class?>">
	<?php foreach ($regions as $region) :?>
		<<?=$region['wrapper']?> class="<?=$region['class']?>" id="<?=$region['id']?>" >
			<?php $this->renderRegion($region['content'], $region['template']) ?>
		</<?=$region['wrapper']?>>
	<?php endforeach; ?>
	</div>
</body>
</html>