<?php

/***************************************************************
* Copyright notice
*
* (c) 2010 Stefan Galinski <stefan.galinski@gmail.com>
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Test class for tx_pmkshadowbox_build.
 *
 * @package TYPO3
 * @subpackage pmkshadowbox
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */
class tx_pmkshadowbox_buildTest extends tx_phpunit_testcase {
	/**
	 * @var tx_pmkshadowbox_build
	 */
	protected $fixture = null;

	/**
	 * @var tx_pmkshadowbox_cache
	 */
	protected $cacheHandler = null;

	/**
	 * @var string
	 */
	protected $cacheDirectory = '';

	protected function setUp() {
		$this->cacheDirectory = 'typo3temp/pmkshadowbox_test/';
		$this->cacheHandler = new tx_pmkshadowbox_cache($this->cacheDirectory);
		$this->fixture = new tx_pmkshadowbox_build($this->cacheHandler);
	}

	protected function tearDown() {
		$this->cacheHandler->clear();
		rmdir(PATH_site . $this->cacheHandler->getCacheDirectory());
		unset($this->fixture, $this->cacheHandler);
	}

	/**
	 * @test
	 */
	public function testBuildDirectoryIsAvailable() {
		$this->assertTrue(is_dir(PATH_site . $this->cacheDirectory));
	}

	/**
	 * @test
	 */
	public function testBuildInstanceWithoutCacheHandlerAsParameter() {
		try {
			$buildInstance = new tx_pmkshadowbox_build();
			$cacheHandler = $buildInstance->getCacheHandler();
			$this->assertTrue(is_dir(PATH_site . $cacheHandler->getCacheDirectory()));
		} catch(Exception $exception) {
			$this->fail('Failed with message: ' . $exception->getMessage());
		}
	}
	
	/**
	 * @test
	 */
	public function testBuildWithDojoAndPlayersWithBlanks() {
		$configuration = array(
			'useSizzle' => TRUE,
			'players' => 'iframe, html,flv',
			'adapter' => 'dojo',
			'language' => 'it',
			'languageFallback' => 'da'
		);

		$buildDirectory = 'dojo-it-iframe-html-flv-sizzle/';
		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($this->cacheDirectory . $buildDirectory, $actualBuildDirectory);
		$this->assertTrue(file_exists(
			PATH_site . $this->cacheDirectory . $buildDirectory . 'shadowbox.js'
		));
	}

	/**
	 * @test
	 */
	public function testBuildWithoutSizzleAndMootools() {
		$configuration = array(
			'useSizzle' => FALSE,
			'players' => 'iframe,html,flv',
			'adapter' => 'mootools',
			'language' => 'de',
			'languageFallback' => 'da'
		);

		$buildDirectory = 'mootools-de-DE-iframe-html-flv/';
		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($this->cacheDirectory . $buildDirectory, $actualBuildDirectory);
		$this->assertTrue(file_exists(
			PATH_site . $this->cacheDirectory . $buildDirectory . 'shadowbox.js'
		));
	}

	/**
	 * @test
	 */
	public function testBuildWithoutSizzleAndFlashAndBrokenLanguageAndJquery() {
		$configuration = array(
			'useSizzle' => FALSE,
			'players' => 'iframe,html',
			'adapter' => 'jquery',
			'language' => 'unknown',
			'languageFallback' => 'unknown'
		);

		$buildDirectory = 'jquery-en-iframe-html/';
		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($this->cacheDirectory . $buildDirectory, $actualBuildDirectory);
		$this->assertTrue(file_exists(
			PATH_site . $this->cacheDirectory . $buildDirectory . 'shadowbox.js'
		));
	}

	/**
	 * @test
	 */
	public function testBuildWithoutSizzleAndFlashAndBrokenAdapterAndBrokenPlayer() {
		$configuration = array(
			'useSizzle' => FALSE,
			'players' => 'iframe,unknwon,html',
			'adapter' => 'unknown',
			'language' => 'it',
			'languageFallback' => 'de'
		);

		$buildDirectory = 'base-it-iframe-html/';
		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($this->cacheDirectory . $buildDirectory, $actualBuildDirectory);
		$this->assertTrue(file_exists(
			PATH_site . $this->cacheDirectory . $buildDirectory . 'shadowbox.js'
		));
	}

	/**
	 * @test
	 */
	public function testBuildWithoutSizzleAndFlashAndLanguageFallbackDe() {
		$configuration = array(
			'useSizzle' => FALSE,
			'players' => 'iframe',
			'adapter' => 'base',
			'language' => 'unknown',
			'languageFallback' => 'de'
		);

		$buildDirectory = 'base-de-DE-iframe/';
		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($this->cacheDirectory . $buildDirectory, $actualBuildDirectory);
		$this->assertTrue(file_exists(
			PATH_site . $this->cacheDirectory . $buildDirectory . 'shadowbox.js'
		));
	}

	/**
	 * @test
	 */
	public function testBuildWithLanguageStdWrap() {
		$configuration = array(
			'useSizzle' => FALSE,
			'players' => 'iframe,html',
			'adapter' => 'base',
			'language.' => array(
				'cObject' => 'COA',
				'cObject.' => array(
					'10' => 'LOAD_REGISTER',
					'10.' => array(
						'lang' => 'de'
					),
					'20' => 'TEXT',
					'20.' => array(
						'data' => 'register:lang'
					)
				)
			),
			'languageFallback' => 'da'
		);

		$buildDirectory = 'base-de-DE-iframe-html/';
		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($this->cacheDirectory . $buildDirectory, $actualBuildDirectory);
		$this->assertTrue(file_exists(
			PATH_site . $this->cacheDirectory . $buildDirectory . 'shadowbox.js'
		));
	}

	/**
	 * @test
	 */
	public function testBuildCacheFileExistsWithMultipleEmptyConfiguratonArrays() {
		$buildDirectory = 'base-en/';
		$this->fixture->build('', array());
		$actualBuildDirectory = $this->fixture->build('', array());
		$this->assertEquals($this->cacheDirectory . $buildDirectory, $actualBuildDirectory);
		$this->assertTrue(file_exists(
			PATH_site . $this->cacheDirectory . $buildDirectory . 'shadowbox.js'
		));
	}

	/**
	 * @test
	 */
	public function testFullBuildWithAllResources() {
		$configuration = array(
			'useSizzle' => TRUE,
			'players' => 'iframe,html,flv',
			'adapter' => 'base',
			'language' => 'de',
			'languageFallback' => 'en'
		);

		$buildDirectory = 'base-de-DE-iframe-html-flv-sizzle/';
		$relativeBuildDirectoryPath = $this->cacheDirectory . $buildDirectory;
		
		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($this->cacheDirectory . $buildDirectory, $actualBuildDirectory);
		$this->assertTrue(file_exists(PATH_site . $relativeBuildDirectoryPath . 'shadowbox.js'));

		$expectedResources = array('shadowbox.js', 'expressInstall.swf', 'play.png', 'next.png',
			'close.png', 'pause.png', 'shadowbox.css', 'previous.png', 'player.swf', 'loading.gif', 'yt.swf');
		$actualResources = array();

		$directoryHandler = new DirectoryIterator(PATH_site . $relativeBuildDirectoryPath);
		foreach ($directoryHandler as $fileInfo) {
			/** @var $fileInfo DirectoryIterator */
			if ($fileInfo->isDot()) {
				continue;
			}

			$actualResources[] = $fileInfo->getFilename();
		}
		sort($actualResources);
		sort($expectedResources);
		$this->assertEquals($expectedResources, $actualResources);
	}

	/**
	 * @test
	 */
	public function testBuildWithoutFlashResourcesAndBrokenSkinModification() {
		$configuration = array(
			'useSizzle' => FALSE,
			'players' => 'iframe,html',
			'skinModificationDirectory' => 'EXT:pmkshadowbox/resources/skinModifications/dontExists/',
			'adapter' => 'base',
			'language' => 'de',
			'languageFallback' => 'en'
		);

		$buildDirectory = 'base-de-DE-iframe-html/';
		$relativeBuildDirectoryPath = $this->cacheDirectory . $buildDirectory;

		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($relativeBuildDirectoryPath, $actualBuildDirectory);
		$this->assertTrue(file_exists(PATH_site . $relativeBuildDirectoryPath . 'shadowbox.js'));

		$expectedResources = array('shadowbox.js', 'play.png', 'next.png',
			'close.png', 'pause.png', 'shadowbox.css', 'previous.png', 'loading.gif');
		$actualResources = array();

		$directoryHandler = new DirectoryIterator(PATH_site . $relativeBuildDirectoryPath);
		foreach ($directoryHandler as $fileInfo) {
			/** @var $fileInfo DirectoryIterator */
			if ($fileInfo->isDot()) {
				continue;
			}

			$actualResources[] = $fileInfo->getFilename();
		}
		sort($actualResources);
		sort($expectedResources);
		$this->assertEquals($expectedResources, $actualResources);
	}

	/**
	 * @test
	 */
	public function testBuildWithSkinModification() {
		$configuration = array(
			'useSizzle' => FALSE,
			'players' => 'iframe',
			'skinModificationDirectory' => 'EXT:pmkshadowbox/resources/skinModifications/closeOnTop/',
			'adapter' => 'base',
			'language' => 'de',
			'languageFallback' => 'en'
		);

		$buildDirectory = 'base-de-DE-iframe-closeOnTop/';
		$relativeBuildDirectoryPath = $this->cacheDirectory . $buildDirectory;

		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($relativeBuildDirectoryPath, $actualBuildDirectory);
		$this->assertTrue(file_exists(PATH_site . $relativeBuildDirectoryPath . 'shadowbox.js'));

		$expectedResources = array('shadowbox.js', 'play.png', 'next.png',
			'close.png', 'pause.png', 'shadowbox.css', 'previous.png', 'loading.gif');
		$actualResources = array();

		$directoryHandler = new DirectoryIterator(PATH_site . $relativeBuildDirectoryPath);
		foreach ($directoryHandler as $fileInfo) {
			/** @var $fileInfo DirectoryIterator */
			if ($fileInfo->isDot()) {
				continue;
			}

			$actualResources[] = $fileInfo->getFilename();
		}
		sort($actualResources);
		sort($expectedResources);
		$this->assertEquals($expectedResources, $actualResources);
		
		$cssContent = file_get_contents(PATH_site . $relativeBuildDirectoryPath . 'shadowbox.css');
		$this->assertContains('#sb-nav-top', $cssContent);
	}

	/**
	 * @test
	 */
	public function testBuildWithSkinModificationAndDifferentFlashPlayerAndExpressInstallScript() {
		$configuration = array(
			'useSizzle' => FALSE,
			'players' => 'iframe,flv',
			'skinModificationDirectory' => 'EXT:pmkshadowbox/resources/skinModifications/closeOnTop/',
			'flashPlayer' => 'EXT:pmkshadowbox/resources/shadowbox/source/resources/player.swf',
			'flashExpressInstallScript' =>
				'EXT:pmkshadowbox/resources/shadowbox/source/resources/expressInstall.swf',
			'adapter' => 'base',
			'language' => 'de',
			'languageFallback' => 'en'
		);

		$buildDirectory = 'base-de-DE-iframe-flv-closeOnTop-player-expressInstall/';
		$relativeBuildDirectoryPath = $this->cacheDirectory . $buildDirectory;

		$actualBuildDirectory = $this->fixture->build('', $configuration);
		$this->assertEquals($relativeBuildDirectoryPath, $actualBuildDirectory);
		$this->assertTrue(file_exists(PATH_site . $relativeBuildDirectoryPath . 'shadowbox.js'));

		$expectedResources = array('shadowbox.js', 'expressInstall.swf', 'play.png', 'next.png',
			'close.png', 'pause.png', 'shadowbox.css', 'previous.png', 'player.swf', 'loading.gif', 'yt.swf');
		$actualResources = array();

		$directoryHandler = new DirectoryIterator(PATH_site . $relativeBuildDirectoryPath);
		foreach ($directoryHandler as $fileInfo) {
			/** @var $fileInfo DirectoryIterator */
			if ($fileInfo->isDot()) {
				continue;
			}

			$actualResources[] = $fileInfo->getFilename();
		}
		sort($actualResources);
		sort($expectedResources);
		$this->assertEquals($expectedResources, $actualResources);

		$cssContent = file_get_contents(PATH_site . $relativeBuildDirectoryPath . 'shadowbox.css');
		$this->assertContains('#sb-nav-top', $cssContent);
	}
}

?>