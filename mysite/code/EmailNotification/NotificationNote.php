<?php

class NotificationNote extends DataObject {
	static $db = array('Level' => 'Int');

	static $has_one = array(
			'Check' => 'Check',
			'Member' => 'Member'		
	);
}