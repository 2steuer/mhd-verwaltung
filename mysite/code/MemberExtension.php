<?php

class MemberExtension extends DataExtension {
	static $many_many =  array(
			'SubscribedCategories' => 'DeviceCategory'
		);

	public function updateCMSFields(FieldList $fields) {
		$fields->push(CheckBoxSetField::create('SubscribedCategories', 'Bitte wählen')
				->setSource(DeviceCategory::get()->filter('Active', '1')->map('ID', 'Name'))
				->setValue($this->owner->SubscribedCategories()));
	}
}