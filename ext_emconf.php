<?php

########################################################################
# Extension Manager/Repository config file for ext "pmkshadowbox".
#
# Auto generated 01-02-2010 15:18
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'PMK Shadowbox',
	'description' => 'Shadowbox is an online media viewer application (Lightbox) that supports all of the web\'s most popular media publishing formats. Shadowbox is written entirely in JavaScript and CSS and is highly customizable. Compatible with ALL JS Frameworks.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '2.9.9',
	'dependencies' => '',
	'conflicts' => '',
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
	'author_email' => 'pmk@io.dk',
	'author_company' => 'telenor,domainFACTORY GmbH',
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
			'typo3' => '4.3.0-0.0.0',
			'php' => '5.0.0-0.0.0',
		),
		'suggests' => array(
			'scriptmerger' => '3.0.0-0.0.0',
		),
	),
	'_md5_values_when_last_written' => 'a:139:{s:23:"Changes_2.0_to_3.0b.txt";s:4:"2b34";s:31:"class.tx_pmkshadowbox_cache.php";s:4:"9391";s:35:"class.tx_ttnews_imageMarkerHook.php";s:4:"8223";s:21:"ext_conf_template.txt";s:4:"7ce0";s:12:"ext_icon.gif";s:4:"82b5";s:17:"ext_localconf.php";s:4:"cf14";s:14:"ext_tables.php";s:4:"3031";s:12:"savefile.php";s:4:"5317";s:14:"doc/manual.sxw";s:4:"dc6e";s:21:"res/build/CHANGES.txt";s:4:"d34c";s:21:"res/build/LICENSE.txt";s:4:"729a";s:20:"res/build/README.txt";s:4:"d997";s:23:"res/build/shadowbox.css";s:4:"264d";s:22:"res/build/shadowbox.js";s:4:"2abd";s:25:"res/build/adapters/README";s:4:"0620";s:36:"res/build/adapters/shadowbox-base.js";s:4:"9fb2";s:36:"res/build/adapters/shadowbox-dojo.js";s:4:"d533";s:35:"res/build/adapters/shadowbox-ext.js";s:4:"4b8b";s:38:"res/build/adapters/shadowbox-jquery.js";s:4:"0965";s:40:"res/build/adapters/shadowbox-mootools.js";s:4:"7ca4";s:41:"res/build/adapters/shadowbox-prototype.js";s:4:"1eca";s:35:"res/build/adapters/shadowbox-yui.js";s:4:"4b15";s:26:"res/build/languages/README";s:4:"e25d";s:35:"res/build/languages/shadowbox-ar.js";s:4:"d1cb";s:35:"res/build/languages/shadowbox-ca.js";s:4:"b5e7";s:35:"res/build/languages/shadowbox-cs.js";s:4:"1f99";s:38:"res/build/languages/shadowbox-de-CH.js";s:4:"83b7";s:38:"res/build/languages/shadowbox-de-DE.js";s:4:"96ec";s:35:"res/build/languages/shadowbox-de.js";s:4:"96ec";s:35:"res/build/languages/shadowbox-dk.js";s:4:"5121";s:35:"res/build/languages/shadowbox-en.js";s:4:"02d3";s:35:"res/build/languages/shadowbox-es.js";s:4:"78c8";s:35:"res/build/languages/shadowbox-et.js";s:4:"2c1f";s:35:"res/build/languages/shadowbox-fi.js";s:4:"41a4";s:35:"res/build/languages/shadowbox-fr.js";s:4:"5593";s:35:"res/build/languages/shadowbox-gl.js";s:4:"4094";s:35:"res/build/languages/shadowbox-he.js";s:4:"3fc5";s:35:"res/build/languages/shadowbox-hu.js";s:4:"fe35";s:35:"res/build/languages/shadowbox-id.js";s:4:"7fb9";s:35:"res/build/languages/shadowbox-is.js";s:4:"545a";s:35:"res/build/languages/shadowbox-it.js";s:4:"4a7e";s:35:"res/build/languages/shadowbox-ja.js";s:4:"8c58";s:35:"res/build/languages/shadowbox-ko.js";s:4:"b347";s:35:"res/build/languages/shadowbox-my.js";s:4:"174d";s:35:"res/build/languages/shadowbox-nl.js";s:4:"4f61";s:35:"res/build/languages/shadowbox-no.js";s:4:"b3e7";s:35:"res/build/languages/shadowbox-pl.js";s:4:"74a0";s:38:"res/build/languages/shadowbox-pt-BR.js";s:4:"ea43";s:38:"res/build/languages/shadowbox-pt-PT.js";s:4:"1d6f";s:35:"res/build/languages/shadowbox-pt.js";s:4:"1d6f";s:35:"res/build/languages/shadowbox-ro.js";s:4:"8d17";s:35:"res/build/languages/shadowbox-ru.js";s:4:"3190";s:35:"res/build/languages/shadowbox-sk.js";s:4:"3fc2";s:35:"res/build/languages/shadowbox-sv.js";s:4:"6669";s:35:"res/build/languages/shadowbox-tr.js";s:4:"d09e";s:38:"res/build/languages/shadowbox-zh-CN.js";s:4:"0a55";s:38:"res/build/languages/shadowbox-zh-TW.js";s:4:"0b09";s:35:"res/build/languages/shadowbox-zh.js";s:4:"0a55";s:42:"res/build/libraries/mediaplayer/player.swf";s:4:"65da";s:43:"res/build/libraries/mediaplayer/readme.html";s:4:"3718";s:38:"res/build/libraries/mediaplayer/yt.swf";s:4:"88df";s:34:"res/build/libraries/sizzle/LICENSE";s:4:"418d";s:36:"res/build/libraries/sizzle/sizzle.js";s:4:"3b30";s:37:"res/build/libraries/swfobject/LICENSE";s:4:"0b51";s:48:"res/build/libraries/swfobject/expressInstall.swf";s:4:"204f";s:42:"res/build/libraries/swfobject/swfobject.js";s:4:"8940";s:24:"res/build/players/README";s:4:"344b";s:34:"res/build/players/shadowbox-flv.js";s:4:"683f";s:35:"res/build/players/shadowbox-gdoc.js";s:4:"5aed";s:35:"res/build/players/shadowbox-html.js";s:4:"a5f8";s:37:"res/build/players/shadowbox-iframe.js";s:4:"6dac";s:34:"res/build/players/shadowbox-img.js";s:4:"1018";s:33:"res/build/players/shadowbox-qt.js";s:4:"4236";s:34:"res/build/players/shadowbox-swf.js";s:4:"30df";s:34:"res/build/players/shadowbox-wmp.js";s:4:"fe98";s:29:"res/build/resources/close.png";s:4:"370c";s:28:"res/build/resources/next.png";s:4:"1c8c";s:29:"res/build/resources/pause.png";s:4:"b960";s:28:"res/build/resources/play.png";s:4:"a404";s:32:"res/build/resources/previous.png";s:4:"156f";s:27:"res/build/skins/loading.gif";s:4:"ffb9";s:24:"res/build/skins/web3.zip";s:4:"b97a";s:35:"res/build/skins/classic/loading.gif";s:4:"ffb9";s:32:"res/build/skins/classic/skin.css";s:4:"5beb";s:31:"res/build/skins/classic/skin.js";s:4:"09e7";s:43:"res/build/skins/classic/resources/close.png";s:4:"370c";s:42:"res/build/skins/classic/resources/next.png";s:4:"0f72";s:43:"res/build/skins/classic/resources/pause.png";s:4:"3e19";s:42:"res/build/skins/classic/resources/play.png";s:4:"9a23";s:46:"res/build/skins/classic/resources/previous.png";s:4:"0ec7";s:42:"res/build/skins/classicCloseOnTop/skin.css";s:4:"6d2b";s:41:"res/build/skins/classicCloseOnTop/skin.js";s:4:"3d53";s:53:"res/build/skins/classicCloseOnTop/resources/close.png";s:4:"370c";s:52:"res/build/skins/classicCloseOnTop/resources/next.png";s:4:"0f72";s:53:"res/build/skins/classicCloseOnTop/resources/pause.png";s:4:"3e19";s:52:"res/build/skins/classicCloseOnTop/resources/play.png";s:4:"9a23";s:56:"res/build/skins/classicCloseOnTop/resources/previous.png";s:4:"0ec7";s:43:"res/build/skins/classicWithSave/loading.gif";s:4:"ffb9";s:40:"res/build/skins/classicWithSave/skin.css";s:4:"4dac";s:39:"res/build/skins/classicWithSave/skin.js";s:4:"c708";s:51:"res/build/skins/classicWithSave/resources/Thumbs.db";s:4:"417b";s:51:"res/build/skins/classicWithSave/resources/close.png";s:4:"370c";s:50:"res/build/skins/classicWithSave/resources/next.png";s:4:"0f72";s:51:"res/build/skins/classicWithSave/resources/pause.png";s:4:"3e19";s:50:"res/build/skins/classicWithSave/resources/play.png";s:4:"9a23";s:54:"res/build/skins/classicWithSave/resources/previous.png";s:4:"0ec7";s:51:"res/build/skins/classicWithSave/resources/print.png";s:4:"b655";s:50:"res/build/skins/classicWithSave/resources/save.png";s:4:"2e04";s:35:"res/build/skins/dropshadow/skin.css";s:4:"dd4e";s:34:"res/build/skins/dropshadow/skin.js";s:4:"bfe5";s:46:"res/build/skins/dropshadow/resources/close.png";s:4:"370c";s:45:"res/build/skins/dropshadow/resources/next.png";s:4:"0f72";s:46:"res/build/skins/dropshadow/resources/pause.png";s:4:"3e19";s:45:"res/build/skins/dropshadow/resources/play.png";s:4:"9a23";s:49:"res/build/skins/dropshadow/resources/previous.png";s:4:"0ec7";s:49:"res/build/skins/dropshadow/resources/shadow50.png";s:4:"a291";s:49:"res/build/skins/dropshadow/resources/shadow70.png";s:4:"5d68";s:29:"res/build/skins/snow/skin.css";s:4:"816c";s:28:"res/build/skins/snow/skin.js";s:4:"3d53";s:40:"res/build/skins/snow/resources/Thumbs.db";s:4:"6c70";s:40:"res/build/skins/snow/resources/close.png";s:4:"af3b";s:39:"res/build/skins/snow/resources/next.png";s:4:"4d99";s:40:"res/build/skins/snow/resources/pause.png";s:4:"195b";s:39:"res/build/skins/snow/resources/play.png";s:4:"8cdd";s:43:"res/build/skins/snow/resources/previous.png";s:4:"bedf";s:29:"res/build/skins/web3/skin.css";s:4:"dabf";s:28:"res/build/skins/web3/skin.js";s:4:"fbc1";s:40:"res/build/skins/web3/resources/Thumbs.db";s:4:"9c3a";s:42:"res/build/skins/web3/resources/loading.gif";s:4:"9818";s:38:"res/build/skins/web3/resources/nav.png";s:4:"4a2d";s:38:"res/build/skins/web3/resources/nav.psd";s:4:"0334";s:54:"res/patches/shadowbox_iframeFlashWhiteFlickering.patch";s:4:"6134";s:49:"res/patches/shadowbox_iframeScrollingOption.patch";s:4:"61d7";s:34:"static/PMK_Shadowbox/constants.txt";s:4:"41f0";s:30:"static/PMK_Shadowbox/setup.txt";s:4:"7a09";s:42:"static/PMK_Shadowbox_tt_news/constants.txt";s:4:"3fad";s:38:"static/PMK_Shadowbox_tt_news/setup.txt";s:4:"1154";s:46:"static/PMK_Shadowbox_tt_products/constants.txt";s:4:"1246";s:42:"static/PMK_Shadowbox_tt_products/setup.txt";s:4:"3c16";}',
);

?>