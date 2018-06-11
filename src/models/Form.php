<?php

namespace WATR\Models;

use WATR\Models\Field;
use WATR\Models\Link;
use WATR\Models\Reference;
use WATR\Models\Screen;

/**
 * Form Model
 */
class Form
{
    /**
     * @var string Typeform unique identifier
     */
    public $id;

    /**
     * @var string title
     */
    public $title;

    /**
     * var Reference identifier for location
     */
    public $theme;

    /**
     * var Reference identifier for location
     */
    public $workspace;

    /**
     * var Setting Typeform form settings
     */
    public $settings;

    /**
     * var Screen[] settings
     */
    public $welcome_screens = [];

    /**
     * var Screen[] settings
     */
    public $thankyou_screens = [];

    /**
     * var Field[] settings
     */
    public $fields = [];

    /*
     * var Link settings
     */
    public $link = [];

    /**
     * Form constructor
     */
    public function __construct($json)
    {
        $this->id = $json->id;
        $this->title = $json->title;

        $this->theme = new Reference($json->theme);
        $this->workspace = new Reference($json->workspace);
        $this->settings = new Setting($json->settings);

        foreach($json->welcome_screens as $screen)
        {
            array_push($this->welcome_screens, new Screen($screen));
        }

        foreach($json->thankyou_screens as $screen)
        {
            array_push($this->thankyou_screens, new Screen($screen));
        }

        $this->settings = new Link($json->_links);

        foreach($json->fields as $field)
        {
            array_push($this->fields, new Field($field));
        }
    }
}