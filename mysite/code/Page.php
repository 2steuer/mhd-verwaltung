<?php
class Page extends SiteTree {

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



	}

}
