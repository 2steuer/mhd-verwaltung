<?php

class MemberExtension extends DataExtension {
	static $many_many =  array(
			'SubscribedCategories' => 'DeviceCategory'
		);
}