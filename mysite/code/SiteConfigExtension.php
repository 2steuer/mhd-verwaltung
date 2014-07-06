<?php
 
class SiteConfigExtension extends DataExtension {

	static $db = array('SiteTitle' => 'Varchar');
     
    private static $has_one = array('Logo' => 'Image');
 
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new TextField('SiteTitle', 'Seitentitel'));
        $fields->addFieldToTab("Root.Main", new UploadField("Logo", "Logo"));

    }
}