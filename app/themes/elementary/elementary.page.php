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
		<div class="row">
		<?php foreach ($regions as $region) :?>
			<<?=$region['wrapper']?> class="<?=$region['class']?>" id="<?=$region['id']?>" >
			<div class="row">
				<div class="col-12">
					<?php $this->renderRegion($region['content'], $region['template']) ?>
				</div>
			</div>
			</<?=$region['wrapper']?>>
		<?php endforeach; ?>
		</div>
	</div>
</body>
</html>