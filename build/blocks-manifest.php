<?php
// This file is generated. Do not modify it manually.
return array(
	'fm-blocks' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/fm-blocks',
		'version' => '0.1.0',
		'title' => 'Fm Blocks',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'fm-blocks',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	),
	'front-hero' => array(
		'apiVersion' => 3,
		'name' => 'plk/front-hero',
		'title' => 'Front Page Hero',
		'category' => 'media',
		'icon' => 'format-image',
		'keywords' => array(
			'plk',
			'hero',
			'banner',
			'image'
		),
		'supports' => array(
			'align' => array(
				'wide',
				'full'
			),
			'anchor' => true,
			'html' => false
		),
		'attributes' => array(
			'desktopId' => array(
				'type' => 'number'
			),
			'desktopAlt' => array(
				'type' => 'string',
				'default' => ''
			),
			'mobile1Id' => array(
				'type' => 'number'
			),
			'mobile1Alt' => array(
				'type' => 'string',
				'default' => ''
			),
			'mobile2Id' => array(
				'type' => 'number'
			),
			'mobile2Alt' => array(
				'type' => 'string',
				'default' => ''
			),
			'aspectRatioPreset' => array(
				'type' => 'string',
				'default' => 'banner'
			),
			'ratioDesktop' => array(
				'type' => 'string',
				'default' => '384/120'
			),
			'ratioMobile' => array(
				'type' => 'string',
				'default' => '8/5'
			),
			'roundedCorners' => array(
				'type' => 'boolean',
				'default' => false
			),
			'linkUrl' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'editorScript' => 'file:./index.js',
		'viewScript' => 'file:./view.js',
		'render' => 'file:./render.php'
	)
);
