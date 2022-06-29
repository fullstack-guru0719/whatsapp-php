<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['post_system'][] = array(
        'class'    => 'post_system',
        'function' => 'action',
        'filename' => 'post_system.php',
        'filepath' => 'hooks',
        'params'   => array('red', 'yellow', 'blue')
);

$hook['pre_system'][] = array(
        'class'    => 'pre_system',
        'function' => 'action',
        'filename' => 'pre_system.php',
        'filepath' => 'hooks',
        'params'   => array('red', 'yellow', 'blue')
);

$hook['post_controller_constructor'][] = array(
        'class'    => 'post_controller_constructor',
        'function' => 'action',
        'filename' => 'post_controller_constructor.php',
        'filepath' => 'hooks',
        'params'   => array('red', 'yellow', 'blue')
);

$hook['post_controller'][] = array(
        'class'    => 'post_controller',
        'function' => 'action',
        'filename' => 'post_controller.php',
        'filepath' => 'hooks',
        'params'   => array('red', 'yellow', 'blue')
);

$hook['pre_controller'][] = array(
        'class'    => 'pre_controller',
        'function' => 'action',
        'filename' => 'pre_controller.php',
        'filepath' => 'hooks',
        'params'   => array('red', 'yellow', 'blue')
);

$hook['display_override'][] = array(
    'class'    => 'display_override',
    'function' => 'replace',
    'filename' => 'display_override.php',
    'filepath' => 'hooks'
);