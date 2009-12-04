<?php

########################################################################
# Extension Manager/Repository config file for ext: "pmkshadowbox"
#
# Auto generated 25-05-2009 19:03
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'PMK Shadowbox',
	'description' => 'Shadowbox is an online media viewer application (Lightbox) that supports all of the web\'s most popular media publishing formats. Shadowbox is written entirely in JavaScript and CSS and is highly customizable. Compatible with ALL JS Frameworks.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '1.1.1',
	'dependencies' => '',
	'conflicts' => 'kj_imagelightbox2,perfectlightbox,wsclicklightbox,ju_multibox,pmkslimbox',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Peter Klein, Stefan Galinski',
	'author_email' => 'pmk@io.dk',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'conflicts' => array(
			'kj_imagelightbox2' => '0.0.0-0.0.0',
			'perfectlightbox' => '0.0.0-0.0.0',
			'wsclicklightbox' => '0.0.0-0.0.0',
			'ju_multibox' => '0.0.0-0.0.0',
			'pmkslimbox' => '0.0.0-0.0.0',
		),
		'depends' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:122:{s:31:"class.tx_pmkshadowbox_cache.php";s:4:"55ae";s:21:"ext_conf_template.txt";s:4:"7ce0";s:12:"ext_icon.gif";s:4:"82b5";s:17:"ext_localconf.php";s:4:"478f";s:14:"ext_tables.php";s:4:"3031";s:27:"tt_news_imageMarkerFunc.php";s:4:"cd67";s:14:"doc/manual.sxw";s:4:"d437";s:17:"res/flvplayer.swf";s:4:"7e1f";s:22:"res/build/shadowbox.js";s:4:"3019";s:35:"res/build/adapter/shadowbox-base.js";s:4:"db68";s:35:"res/build/adapter/shadowbox-dojo.js";s:4:"2ec4";s:34:"res/build/adapter/shadowbox-ext.js";s:4:"6f34";s:37:"res/build/adapter/shadowbox-jquery.js";s:4:"b008";s:39:"res/build/adapter/shadowbox-mootools.js";s:4:"8ffc";s:40:"res/build/adapter/shadowbox-prototype.js";s:4:"c1b2";s:34:"res/build/adapter/shadowbox-yui.js";s:4:"d3a4";s:30:"res/build/lang/shadowbox-ar.js";s:4:"7d7f";s:30:"res/build/lang/shadowbox-ca.js";s:4:"f689";s:30:"res/build/lang/shadowbox-cs.js";s:4:"5c70";s:33:"res/build/lang/shadowbox-de-CH.js";s:4:"d5b1";s:33:"res/build/lang/shadowbox-de-DE.js";s:4:"f8e5";s:30:"res/build/lang/shadowbox-de.js";s:4:"d5b1";s:30:"res/build/lang/shadowbox-dk.js";s:4:"9506";s:30:"res/build/lang/shadowbox-en.js";s:4:"b939";s:30:"res/build/lang/shadowbox-es.js";s:4:"e889";s:30:"res/build/lang/shadowbox-et.js";s:4:"17fc";s:30:"res/build/lang/shadowbox-fi.js";s:4:"54ca";s:30:"res/build/lang/shadowbox-fr.js";s:4:"7b68";s:30:"res/build/lang/shadowbox-gl.js";s:4:"46e1";s:30:"res/build/lang/shadowbox-he.js";s:4:"43ce";s:30:"res/build/lang/shadowbox-id.js";s:4:"f2c2";s:30:"res/build/lang/shadowbox-is.js";s:4:"e08b";s:30:"res/build/lang/shadowbox-it.js";s:4:"72e9";s:30:"res/build/lang/shadowbox-ko.js";s:4:"4898";s:30:"res/build/lang/shadowbox-my.js";s:4:"1d89";s:30:"res/build/lang/shadowbox-nl.js";s:4:"cbda";s:30:"res/build/lang/shadowbox-no.js";s:4:"4a9a";s:30:"res/build/lang/shadowbox-pl.js";s:4:"e15e";s:33:"res/build/lang/shadowbox-pt-BR.js";s:4:"2add";s:33:"res/build/lang/shadowbox-pt-PT.js";s:4:"82c9";s:30:"res/build/lang/shadowbox-pt.js";s:4:"82c9";s:30:"res/build/lang/shadowbox-ro.js";s:4:"a982";s:30:"res/build/lang/shadowbox-ru.js";s:4:"ae58";s:30:"res/build/lang/shadowbox-sk.js";s:4:"2871";s:30:"res/build/lang/shadowbox-sv.js";s:4:"c767";s:30:"res/build/lang/shadowbox-tr.js";s:4:"4773";s:33:"res/build/lang/shadowbox-zh-CN.js";s:4:"4e7a";s:33:"res/build/lang/shadowbox-zh-TW.js";s:4:"aa5b";s:33:"res/build/player/shadowbox-flv.js";s:4:"e7ea";s:34:"res/build/player/shadowbox-html.js";s:4:"bb78";s:36:"res/build/player/shadowbox-iframe.js";s:4:"f68e";s:33:"res/build/player/shadowbox-img.js";s:4:"2437";s:32:"res/build/player/shadowbox-qt.js";s:4:"51d3";s:33:"res/build/player/shadowbox-swf.js";s:4:"0feb";s:33:"res/build/player/shadowbox-wmp.js";s:4:"6494";s:21:"res/build/skin/README";s:4:"6f90";s:32:"res/build/skin/classic/icons.psd";s:4:"9308";s:34:"res/build/skin/classic/loading.gif";s:4:"ffb9";s:31:"res/build/skin/classic/skin.css";s:4:"0aa8";s:30:"res/build/skin/classic/skin.js";s:4:"6f1e";s:38:"res/build/skin/classic/icons/close.png";s:4:"370c";s:37:"res/build/skin/classic/icons/next.png";s:4:"0f72";s:38:"res/build/skin/classic/icons/pause.png";s:4:"3e19";s:37:"res/build/skin/classic/icons/play.png";s:4:"9a23";s:41:"res/build/skin/classic/icons/previous.png";s:4:"0ec7";s:42:"res/build/skin/classicCloseOnTop/icons.psd";s:4:"9308";s:44:"res/build/skin/classicCloseOnTop/loading.gif";s:4:"ffb9";s:41:"res/build/skin/classicCloseOnTop/skin.css";s:4:"644c";s:40:"res/build/skin/classicCloseOnTop/skin.js";s:4:"c900";s:48:"res/build/skin/classicCloseOnTop/icons/close.png";s:4:"370c";s:47:"res/build/skin/classicCloseOnTop/icons/next.png";s:4:"0f72";s:48:"res/build/skin/classicCloseOnTop/icons/pause.png";s:4:"3e19";s:47:"res/build/skin/classicCloseOnTop/icons/play.png";s:4:"9a23";s:51:"res/build/skin/classicCloseOnTop/icons/previous.png";s:4:"0ec7";s:34:"res/build/skin/concept/loading.gif";s:4:"bf1a";s:31:"res/build/skin/concept/skin.css";s:4:"8b39";s:30:"res/build/skin/concept/skin.js";s:4:"e66d";s:38:"res/build/skin/concept/icons/Thumbs.db";s:4:"3b70";s:38:"res/build/skin/concept/icons/close.gif";s:4:"6c60";s:44:"res/build/skin/concept/icons/close_hover.gif";s:4:"21b1";s:37:"res/build/skin/concept/icons/next.gif";s:4:"211c";s:43:"res/build/skin/concept/icons/next_hover.gif";s:4:"ee5e";s:38:"res/build/skin/concept/icons/pause.gif";s:4:"586c";s:44:"res/build/skin/concept/icons/pause_hover.gif";s:4:"887b";s:37:"res/build/skin/concept/icons/play.gif";s:4:"7abc";s:43:"res/build/skin/concept/icons/play_hover.gif";s:4:"ccd7";s:41:"res/build/skin/concept/icons/previous.gif";s:4:"a881";s:47:"res/build/skin/concept/icons/previous_hover.gif";s:4:"6b5e";s:35:"res/build/skin/infernal/loading.gif";s:4:"1fe6";s:32:"res/build/skin/infernal/skin.css";s:4:"e84c";s:31:"res/build/skin/infernal/skin.js";s:4:"613d";s:39:"res/build/skin/infernal/icons/Thumbs.db";s:4:"9e1c";s:39:"res/build/skin/infernal/icons/close.png";s:4:"1575";s:45:"res/build/skin/infernal/icons/close_hover.png";s:4:"25b1";s:38:"res/build/skin/infernal/icons/next.png";s:4:"bab7";s:44:"res/build/skin/infernal/icons/next_hover.png";s:4:"6178";s:39:"res/build/skin/infernal/icons/pause.png";s:4:"9c20";s:45:"res/build/skin/infernal/icons/pause_hover.png";s:4:"1e54";s:38:"res/build/skin/infernal/icons/play.png";s:4:"3170";s:44:"res/build/skin/infernal/icons/play_hover.png";s:4:"56f5";s:42:"res/build/skin/infernal/icons/previous.png";s:4:"fae1";s:48:"res/build/skin/infernal/icons/previous_hover.png";s:4:"1448";s:31:"res/build/skin/nova/loading.gif";s:4:"1557";s:28:"res/build/skin/nova/skin.css";s:4:"9138";s:27:"res/build/skin/nova/skin.js";s:4:"e1b9";s:35:"res/build/skin/nova/icons/Thumbs.db";s:4:"9c61";s:35:"res/build/skin/nova/icons/close.png";s:4:"32f5";s:41:"res/build/skin/nova/icons/close_hover.png";s:4:"c55a";s:34:"res/build/skin/nova/icons/next.png";s:4:"cdf4";s:40:"res/build/skin/nova/icons/next_hover.png";s:4:"801d";s:35:"res/build/skin/nova/icons/pause.png";s:4:"9278";s:41:"res/build/skin/nova/icons/pause_hover.png";s:4:"bcf1";s:34:"res/build/skin/nova/icons/play.png";s:4:"6832";s:40:"res/build/skin/nova/icons/play_hover.png";s:4:"1019";s:38:"res/build/skin/nova/icons/previous.png";s:4:"82f4";s:44:"res/build/skin/nova/icons/previous_hover.png";s:4:"88e9";s:34:"static/PMK_Shadowbox/constants.txt";s:4:"d59b";s:30:"static/PMK_Shadowbox/setup.txt";s:4:"db0d";s:42:"static/PMK_Shadowbox_tt_news/constants.txt";s:4:"3fad";s:38:"static/PMK_Shadowbox_tt_news/setup.txt";s:4:"ba03";s:46:"static/PMK_Shadowbox_tt_products/constants.txt";s:4:"1246";s:42:"static/PMK_Shadowbox_tt_products/setup.txt";s:4:"3c16";}',
	'suggests' => array(
	),
);

?>