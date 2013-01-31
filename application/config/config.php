<?php
/** FuelPHP Framework Configuration File
 *  DO NOT MODIFY THIS FILE AS DOING SO MAY BREAK THE APPLICATION!
 *  YOU HAVE BEEN WARNED!
 *
 *  For information on Slate application files view the developer
 *  documentation at http://codesector.net/projects/slate
 */

return array(
	'always_load' => array(
		'packages' => array(
			'auth',
			'orm',
			'bootstrap',
		),
	),
	'whitelisted_classes' => array(
		'Fuel\\Core\\Response',
		'Fuel\\Core\\View',
		'Fuel\Core\Validation',
		'Closure',
	),
);
