<?php

class SubscriptionPage extends Page {

}

class SubscriptionPage_Controller extends Page_Controller {

	static $allowed_actions = array('index', 'SubscriptionForm');

	public function Categories() {
		return DeviceCategory::get()->filter(array('Active'=>'1'))->sort('Name');
	}

	public function Saved() {
		$ret = Session::get('saved');

		Session::set('saved', false);

		return $ret;
	}

	public function index($request) {
		return $this->render(array('Form' => $this->SubscriptionForm()));		
	}

	public function SubscriptionForm() {
		$member = Member::currentUser();

		$fields = new FieldList(
			CheckBoxSetField::create('SubscribedCategories', 'Bitte wählen')
				->setSource($this->Categories()->map('ID', 'Name'))
				->setValue($member->SubscribedCategories())
		);

		$actions = new FieldList(FormAction::create('update_subscriptions', 'Speichern'));

		return new Form($this, 'SubscriptionForm', $fields, $actions);
	}

	function update_subscriptions($data, $form) {
		$member = Member::currentUser();

		$form->saveInto($member);

		$member->write();

		Session::set('saved', true);

		return $this->redirect('index');
	}
}