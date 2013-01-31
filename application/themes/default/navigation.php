<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<a class="brand" href="<?php echo Uri::base(); ?>">Slate</a>

			<div class="nav-collapse collapse">
				<ul class="nav pull-right">
					<?php
						echo Html::item( 'admin', 'Dashboard' );
						echo Html::item( 'settings', 'Settings', 'cog');
					?>
					<li class="divider-vertical"></li>
					<?php
						echo Html::dropdown( Html::icon( 'user').'&nbsp'.$current_user->firstname.' '.$current_user->lastname, array( 'container' => 'li' ))
							->item('user/logout', 'Logout', 'off' );
					?>
				</ul>
			</div>
		</div>
	</div>
</div>

<!--<?php foreach ( glob( APPPATH . 'classes/controller/admin/*.php' ) as $controller ):
		$section_segment = basename( $controller, '.php' );
		$section_title = Inflector::humanize( $section_segment );
?>

	<li class="<?php echo Uri::segment( 2 ) == $section_segment ? 'active' : '' ?>">
		<?php echo Html::anchor( 'admin/' . $section_segment, $section_title ) ?>
	</li>
<?php endforeach; ?>-->