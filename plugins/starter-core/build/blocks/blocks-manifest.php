<?php
// This file is generated. Do not modify it manually.
return array(
	'contact-form' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'starter/contact-form',
		'version' => '0.1.0',
		'title' => 'Contact form',
		'category' => 'widgets',
		'icon' => 'email',
		'description' => 'Name, email, optional phone and message, sent by email to the address in Settings → Business details. Works without JavaScript.',
		'keywords' => array(
			'yhteydenotto',
			'lomake',
			'form',
			'contact'
		),
		'textdomain' => 'starter-core',
		'attributes' => array(
			'showPhone' => array(
				'type' => 'boolean',
				'default' => true
			),
			'buttonText' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false,
			'multiple' => false,
			'spacing' => array(
				'margin' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'opening-hours' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'starter/opening-hours',
		'version' => '0.1.0',
		'title' => 'Opening hours',
		'category' => 'widgets',
		'icon' => 'clock',
		'description' => 'Opening hours from Settings → Business details, grouped by days with the same hours.',
		'keywords' => array(
			'aukioloajat',
			'aukiolo',
			'hours'
		),
		'textdomain' => 'starter-core',
		'attributes' => array(
			'dayFormat' => array(
				'type' => 'string',
				'enum' => array(
					'short',
					'long'
				),
				'default' => 'short'
			)
		),
		'supports' => array(
			'html' => false,
			'anchor' => true,
			'color' => array(
				'text' => true,
				'background' => false
			),
			'typography' => array(
				'fontSize' => true
			),
			'spacing' => array(
				'margin' => true
			)
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	)
);
