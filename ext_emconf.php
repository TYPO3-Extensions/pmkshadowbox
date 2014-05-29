<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "pmkshadowbox".
 *
 * Auto generated 12-06-2013 21:59
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'PMK Shadowbox',
	'description' => 'Shadowbox is an online media viewer application (Lightbox) that supports all of the web\'s most popular media publishing formats. Shadowbox is written entirely in JavaScript and CSS and is highly customizable. Compatible with ALL JS Frameworks.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '3.3.0',
	'dependencies' => '',
	'conflicts' => 'kj_imagelightbox2,perfectlightbox,wsclicklightbox,ju_multibox,pmkslimbox,dam_ttnews',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => 'typo3temp/pmkshadowbox/',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Peter Klein, Stefan Galinski',
	'author_email' => 'stefan@sgalinski.de',
	'author_company' => '',
	'CGLcompliance' => NULL,
	'CGLcompliance_note' => NULL,
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '4.5.0-6.2.99',
			'php' => '5.3.0-5.5.99',
		),
		'conflicts' => 
		array (
			'kj_imagelightbox2' => '0.0.0-0.0.0',
			'perfectlightbox' => '0.0.0-0.0.0',
			'wsclicklightbox' => '0.0.0-0.0.0',
			'ju_multibox' => '0.0.0-0.0.0',
			'pmkslimbox' => '0.0.0-0.0.0',
			'dam_ttnews' => '0.0.0-0.0.0',
		),
		'suggests' => 
		array (
		),
	),
);

?>