<?php
/** Slate authentication groups and roles
 *
 *  DO NOT MODIFY UNLESS YOU KNOW WHAT YOU ARE DOING!
 */
return array(
	'groups' => array(
		-1 => array('name' => 'Suspended', 'roles' => array('suspended')),
		0 => array('name' => 'Guests', 'roles' => array()),
		1 => array('name' => 'Users', 'roles' => array('user')),
		100 => array('name' => 'Managers', 'roles' => array('user', 'manager')),
		1000 => array('name' => 'Administrators', 'roles' => array('user', 'manager', 'admin')),
	),
);