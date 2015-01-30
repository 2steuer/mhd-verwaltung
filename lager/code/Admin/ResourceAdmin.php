<?php

class ResourceAdmin extends ModelAdmin {
    private static $managed_models = array('Resource'); // Can manage multiple models
    private static $url_segment = 'artikel'; // Linked as /admin/products/
    private static $menu_title = 'Artikelverwaltung';

    private static $model_importers = array(
        'Resource' => 'ResourceImporter'
    );
}