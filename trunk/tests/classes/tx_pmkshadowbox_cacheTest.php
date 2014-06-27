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
 * Test class for tx_pmkshadowbox_cache.
 *
 * @package TYPO3
 * @subpackage pmkshadowbox
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */
class tx_pmkshadowbox_cacheTest extends tx_phpunit_testcase {
	/**
	 * @var tx_pmkshadowbox_cache
	 */
	protected $fixture = null;

	/**
	 * @var string
	 */
	protected $buildDirectory =  '';

	/**
	 * @var string
	 */
	protected $cacheDirectory = '';

	protected function setUp() {
		$this->cacheDirectory = 'typo3temp/pmkshadowbox_test/';
		$this->buildDirectory = 'mootools-de-iframe/';
		$this->fixture = new tx_pmkshadowbox_cache($this->cacheDirectory);
	}

	protected function tearDown() {
		$this->fixture->clear();
		rmdir(PATH_site . $this->fixture->getCacheDirectory());
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function testWriteCacheFile() {
		$this->fixture->setBuildDirectory($this->buildDirectory);
		$script = $this->fixture->writeCacheFile('shadowbox.js', 'Bla');
		$this->assertTrue(file_exists(PATH_site . $script));
		$this->assertEquals('Bla', file_get_contents(PATH_site . $script));
	}

	/**
	 * @test
	 */
	public function testGetCacheDirectory() {
		$this->assertEquals($this->cacheDirectory, $this->fixture->getCacheDirectory());
	}

	/**
	 * @test
	 */
	public function testSetBuildDirectory() {
		$this->fixture->setBuildDirectory($this->buildDirectory);
		$expectedDirectory = PATH_site . $this->cacheDirectory . $this->buildDirectory;
		$this->assertTrue(is_dir($expectedDirectory));
	}

	/**
	 * @test
	 */
	public function testClearCachePostProc() {
		$this->fixture->setBuildDirectory($this->buildDirectory);
		$script = $this->fixture->writeCacheFile('shadowbox.js', '');
		$this->assertTrue(file_exists(PATH_site . $script));
		
		$this->fixture->clearCachePostProc(array(), null);
		$buildDirectory = PATH_site . $this->cacheDirectory . $this->buildDirectory;
		$this->assertTrue(file_exists($buildDirectory . 'shadowbox.js'));
		
		$this->fixture->clearCachePostProc(array('cacheCmd' => 'all'), null);
		$this->assertFalse(file_exists($buildDirectory . 'shadowbox.js'));
	}

	/**
	 * @test
	 */
	public function testCopyResourceFile() {
		$this->fixture->setBuildDirectory($this->buildDirectory);

		$resource = t3lib_extMgm::extPath('pmkshadowbox') .
			'resources/shadowbox/source/resources/player.swf';
		$destination = $this->fixture->copyResourceFile($resource, 'test.swf');
		$expectedPathName = $this->cacheDirectory . $this->buildDirectory . 'test.swf';
		$this->assertEquals($expectedPathName, $destination);
		$this->assertTrue(file_exists(PATH_site . $expectedPathName));
		
		$destination = $this->fixture->copyResourceFile($resource);
		$expectedPathName = $this->cacheDirectory . $this->buildDirectory . 'player.swf';
		$this->assertEquals($expectedPathName, $destination);
		$this->assertTrue(file_exists(PATH_site . $expectedPathName));
	}
}

?>