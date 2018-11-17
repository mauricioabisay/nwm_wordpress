# New World Monkeys Wordpress Object Oriented Library

The following work was done during the incredible time I worked at New World Monkeys, where I met some of the most talented and intelligent people I have yet to encounter.

The primary goal is to force a meaningful, yet simple, approach to Wordpress customization using an Object Oriented paradigm.

This library is just a layer on top of Wordpress's extensible platform.

It is aimed to simplify my way of doing Wordpress customizations.

## Setup

1. Clone or unzip the project inside your theme root directoy
2. Start traveling into my mind

## How to use it

I recommend to separate the code into 3 files:
- functions.php
- functions-theme.php
- functions-posts.php

### functions.php
The old time wordpress functions.php file, that has to be present in plugins and themes. Here we will instanciate every object we want to include in our Wordpress customization.

### functions-theme.php
In this file goes the code describing a class extending WP\Theme.

### functions-posts.php
In this file define all the customs posts and extra fields to WooCommerce Product post type.

### Creating a Theme Object
To create a Wordpress theme:

1. Create the functions-theme.php file.
2. Define a class extending WP\Theme.
3. Declare WP\Theme abstract methods:
    - setScripts
    - publicActons
    - publicFilters
    - setAdminScripts
    - adminActions
    - adminFilters
4. Add your JS and CSS files in an OO way.
5. Instanciate the class that contains the theme definition in the `functions.php` file

#### functions-theme.php example
```
<?php
use WP\Theme;
require_once 'nwm_wordpress/wp.php';
require_once 'nwm_wordpress/wp_location.php';

class Tema extends WP\Theme {
    function __construct() {
        parent::__construct();
        add_action('init', array($this, 'init'));
    }

/**
* Here you add PUBLIC CSS and JS files to the theme, using $this->add_css(...) and $this->add_js(...)
*/
    function setScripts() {
        $this->add_css('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
        $this->add_js('jquery', 'https://code.jquery.com/jquery-3.3.1.slim.min.js');
    }

/**
* Here you add Dashboard CSS and JS files, using $this->add_admin_css(...) and $this->add_admin_js(...)
*/
    function setAdminScripts() {
    }

    function init() {
        add_post_type_support('post', 'excerpt');
        add_post_type_support('page', 'excerpt');
    }

    function publicActions() {
    }

    function publicFilters() {
    }

    function adminActions() {
    }

    function adminFilters() {
    }

}
```

### Creating a custom post object

To create a custom post:

1. If not already, create the `functions-posts.php`
2. Inside `functions-posts.php` define a class extending `WP\SimplePost`
3. Declare `WP\SimplePost` abstract method:
    - save_extra
4. Define your custom posts in OO way:
    - enable/disable features using enable_*feature*() or disable_*feature*() methods
    - define common used meta field types:
        + text (text, date, time, datetime, email, number, phone)
        + description (textarea)
        + single-choice (radios)
        + multi-choice (checkboxes)
        + dropdown (select)
    - You can add options to single-choice, multi-choice and dropdown via:
        * an array with values
        * a wordpress query (query_args array)
        * a post type (post type key name)
5. Instanciate the new custom post class in the `functions.php` file

#### functions-posts.php example
```
<?php
use WP\WP;
use WC\WC;
use WP\SimplePost;
require_once('nwm_wordpress/wp.php');
require_once('nwm_wordpress/wc.php');

class Faculty extends SimplePost {
    public function __construct() {
        parent::__construct('faculty', 'Faculty', 'Faculties');
        ...
    }
}

class Student extends SimplePost {
    public function __construct() {
        parent::__construct('student', 'Student', 'Students');
        $this->add_field('schoold_id', 'School ID', 'text')
        $this->add_field('faculty', 'Faculty', 'dropdown', 'Please select a faculty', 'faculty');
        $this->add_field('blood_type', 'Blood type', 'single-choice', array('A negative', 'A positive', 'B negative', 'B positive', 'AB negative', 'AB positive', 'O negative', 'O positive'));
    }

    /**
    * This method can be used for doing things after the post and it's fields data have been 
    * saved/updated. Here you have access to the _POST array and the post object 
    * (e.g. post->ID gets the post's database auto-assigned ID)
    *
    * @return void
    */
    public function save_extra($post) {
        
    }
}
```

## Author

Mauricio Abisay Lopez Velazquez
mauricioabisay.lopez@gmail.com