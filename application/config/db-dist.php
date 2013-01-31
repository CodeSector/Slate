<?php
/** Slate Database Configuration
 *
 *  Slate uses PDO as well as native PHP drivers for database access
 *  for additional options view the developer docs at
 *  http://codesector.net/projects/slate
 */

return array(
	'default' => array(
		'connection' => array(
			'dsn' => 'mysql:host=localhost;dbname=',
			'username' => '',
			'password' => '',
		),
	),
);
)
;