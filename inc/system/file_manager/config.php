<?php
return [
    'id' => 'file_manager',
    'name' => 'File manager',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'version' => '1.0',
    'desc' => '',
    'icon' => 'far fa-folder-open',
    'color' => '',
    'menu' => [
        'tab' => 4,
        'position' => 900,
        'name' => 'File manager'
    ],
	'css' => [
        'assets/plugins/file.upload/css/jquery.fileupload.css',
		'assets/css/file_manager.css',
	],
	'js' => [
        'assets/plugins/file.upload/js/vendor/jquery.ui.widget.js',
        'assets/plugins/file.upload/js/jquery.iframe-transport.js',
        'assets/plugins/file.upload/js/jquery.fileupload.js',
        'assets/plugins/jquery.lazy/jquery.lazy.min.js',
        'assets/plugins/jquery-gdrive/jquery-gdrive.js',
		'assets/js/file_manager.js'
	]
];