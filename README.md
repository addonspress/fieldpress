# FieldPress 

FieldPress is WordPress Back-end builder framework which facilities WordPress user, theme and plugin developer to create advanced back-end section like meta-box, widget and menu options in very short time.  

## Screenshot
![FildPress](https://addonspress.com/wp-content/uploads/2018/09/fieldpress-feature.png?'FieldPRess'')

### Prerequisites

To install FieldPress framework, WordPress set is required either it is in localhost or Web server.

### Installing

A steps for FieldPress installation on localhost and Web-servers are as follows:-

A) Usage in Theme development 

- Download zip file from github repository.
- Create a folder called "library" in your theme directory.
- Exact the downloaded zip file and place it to theme directory(yourtheme/library) of your project.
- Add the FieldPress framework required code in the your theme/functions.php
```php
defined('FIELDPRESS_URL') or define('FIELDPRESS_URL', get_template_directory_uri().'/library/fieldpress/');
require_once get_template_directory() .'/library/fieldpress/fieldpress.php';
```
- Now you are ready to configure framework menu options, metaboxes, widget.
- To configure take a look of example file under yourtheme/library/fieldPress/example.

B) Usage as like a Plugin

- Download zip file from github repository.
- Option 1 : Extract the downloaded file under the plugin directory(wp-content/plugin/) of your project.
- Option 2 : Upload the zip file from Wordpess Admin panel -> Plugins -> Add new -> Upload plugin.
- Activate FieldPress as similar to other WordPress plugin . 
- Now , you are ready to configure fieldPress framework menu options, meta-box, widget.
- To configure take a look of example files under wp-content/plugins/fieldPress/example.

c) Usage under plugin development 

- Download zip file from github repository.
- Create a folder called "library" in your plugin directory.
- Exact the downloaded zip file and place it to plugin directory(/wp-content/plugins/yourpluign/library).
- Add the FieldPress framework required code in the your pluign yourplugin.php or functions.php .
```php
require_once plugin_dir_path( __FILE__ ). 'library/fieldpress/fieldpress.php';
```
- Now you are ready to configure framework menu options, metaboxes, widget.
- To configure take a look of example file under yourplugins/library/fieldPress/example.
- Refer Documentation



### Overriding FieldPress Files

    You can override an existing files of FieldPress without touching FieldPress files. Just create a folder "fieldpress" under your theme directory 

    Example: 
    themename/fieldpress/example/menu.php
    themename/fieldpress/example/meta.php
    themename/fieldpress/class/fp-widget-base.php

     
## Compatible

   FiledPress framework is compatible with latest version of WordPress.  

## Features
- Meta-box Framework
- Widget Framework
- Options Framework

## Options Fields

   These are the main fields of this framework. And these fields contains their several types like Check-box with multiple check-box options and so on. 

- Checkbox
- Colors
- Date
- Email
- File Upload
- Gallery
- Image
- Icon
- Map
- Number
- Radio
- Repeater
- Nested Repeater
- Nested Menu Repeater
- Select Image
- Select
- Sorter
- Switcher
- Tabs
- Text
- Text-area
- URL
- WYSIWYG

## Version
   0.0.1

## Authors
   
   Name    : AddonsPress
   
   Site Url : https://addonspress.com/

## License

This project is licensed under the WordPress GPLv2 (or later).


