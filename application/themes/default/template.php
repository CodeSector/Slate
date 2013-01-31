<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
	<?php echo \Theme::instance()->asset->render(); ?>
	<?php if ( isset( $asset_groups ) and !empty( $asset_groups )) echo\Theme::instance()->asset->render( $asset_groups ); ?>
</head>
<body>
<?php if ( isset( $partials['navigation'] )) { echo $partials['navigation']; } ?>
	<div class="container-fluid">
		<?php echo $partials['content'] ?>
	</div>
</body>
</html>