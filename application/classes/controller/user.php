<?php

class Controller_User extends \Controller_Base {

	public function action_index() {
		// Check to see if a user is authenticated, if so display profile
		// if not redirect to login
		if ( Auth::check() ) {
			$this->theme->set_partial( 'content', 'user/profile' );
			/*if ( !Auth::member( 1000 ) and !in_array( Request::active()->action, array( 'login', 'logout'))) {
				Session::set_flash( 'error', e( 'Insufficient permissions to access the administration panel' ));
				Response::redirect( '/' );
			}*/
		} else {
			if ( !in_array( Request::active()->action, array( 'login' )))
				Response::redirect( 'user/login' );
		}
	}

	public function action_login() {
		// If the user is already logged in, direct to profile
		Auth::check() and Response::redirect( '' );
		$val = Validation::forge();

		if ( Input::method() == 'POST' ) {
			$val->add( 'email', 'Email or Username' )
				->add_rule( 'required' );
			$val->add( 'password', 'Password' )
				->add_rule( 'required' );

			var_dump( $val->run() );
			if ( $val->run() ) {
				$auth = Auth::instance();

				// check the credentials. This assumes that you have the previous table created
				if ( Auth::check() or $auth->login( Input::post( 'email' ), Input::post( 'password' ) ) ) {
					// credentials ok, go right in
					$current_user = Model_User::find_by_username( Auth::get_screen_name() );
					Session::set_flash( 'success', e( 'Welcome, ' . $current_user->username ) );
					Response::redirect( 'user' );
				}
				else {
					$this->theme->template->set_global( 'login_error', 'Invalid username or password!' );
				}
			}
		}

		$this->theme->set_partial( 'content', 'user/login' );
		$this->theme->template->set_global( 'val', $val );
		//$this->template->title = 'Login';
		//$this->template->content = View::forge( 'admin/login', array('val' => $val), false );
	}

	public function action_logout() {
		Auth::logout();
		Response::redirect( '' );
	}
}