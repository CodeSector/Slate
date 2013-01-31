<?php

class Controller_Base extends \Controller {

	public $title = '';
	public $theme = null;
	public $is_admin = false;
	public $asset_groups = null;
	public $menu = null;

	public function before() {
		// Initialize the theme instance and set the default template
		$this->theme = \Theme::instance();
		$this->theme->set_template( 'template' )
			->set( 'title', $this->title )
			->set( 'asset_groups', $this->asset_groups )
			->set( 'is_admin', $this->is_admin );

		// Add bootstrap and jQuery to Assets as they are globally required
		$this->theme->asset->css( 'bootstrap.css' );
		$this->theme->asset->css( 'bootstrap-responsive.css' );
		$this->theme->asset->css( 'style.css' );

		$this->theme->asset->js( 'jquery.min.js' );
		$this->theme->asset->js( 'bootstrap.js' );

		// Assign current_user to the instance so controllers can use it, then set a global for all views
		$this->current_user = Auth::check() ? Model_User::find_by_username( Auth::get_screen_name() ) : null;
		View::set_global( 'current_user', $this->current_user );

		if ( $this->current_user ) {
			$this->theme->set_partial( 'navigation', 'navigation' );
		}

		parent::before();
	}

	public function after( $response ) {
		// If no response object was returned by the action,
		if ( empty( $response )) // or  ! $response instanceof Response
			$response = \Response::forge( \Theme::instance()->render() ); // render the defined template

		return parent::after($response);
	}

}