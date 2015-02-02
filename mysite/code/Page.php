<?php
class Page extends SiteTree {

	private static $db = array(
		'NotesEnabled' => 'Boolean',
		'NotesText' => 'Text'
	);

	private static $has_one = array(
		'NotesParent' => 'Page'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Notes', CheckBoxField::create('NotesEnabled', 'Notizzettel anzeigen'));
		$fields->addFieldToTab('Root.Notes', new TreeDropdownField(	
					"NotesParentID", 
					'Speicherort der Notizen', 
					"SiteTree"
				));
	
		return $fields;
	}

}
class Page_Controller extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
		'NoteForm'
	);

	public function init() {
		parent::init();

        Session::set('back-url', $this->getRequest()->getHeader('Referer'));

        Requirements::css('mysite/css/normalize.min.css');
        Requirements::css('mysite/css/format.css');

        Requirements::block(THIRDPARTY_DIR . '/jquery/jquery.js');

        Requirements::javascript('mysite/js/jquery-1.11.0.min.js');
        Requirements::javascript('mysite/js/modernizr-2.6.2.min.js');

        Requirements::javascript('lager/js/barcode_scan.js');

	}

	public function NoteForm() {
		$id = ($this->NotesParentID) ? $this->NotesParentID : $this->ID;

		$obj = Page::get()->byID($id);

		$fields = new FieldList(
			TextAreaField::create('NotesText', 'Notizen:')
				->setValue($obj->NotesText)
		);

		$actions = new FieldList(FormAction::create('saveNotes','Speichern'));

		return new Form($this, 'NoteForm', $fields, $actions);
	}

	public function saveNotes($data, $form) {
		$id = ($this->NotesParentID) ? $this->NotesParentID : $this->ID;

		$obj = Page::get()->byID($id);
		$form->saveInto($obj);
		$obj->write();

		return $this->redirectBack();
	}

}
