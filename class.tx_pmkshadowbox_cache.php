<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Stefan Galinski (stefan.galinski@gmail.com)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * This class contains a class with methods which are used to enable the merging
 * of the shadowbox javascript files.
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */

if (!class_exists(JSMin)) {
	/** Minify: JSMin */
	require_once(PATH_typo3 . 'contrib/jsmin/jsmin.php');
}

/**
 * This class contains several methods which are used for the merging process.
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */
class tx_pmkshadowbox_cache {
	/** @var array $extConfig holds the extension configuration */
	private $extConfig = array();

	/** @var array $players hold the available shadowbox player scripts */
	private $players = array();

	/** @var string $tempDirectory contains the temporary directory */
	private $tempDirectory = '';

	/**
	 * CONSTRUCTOR
	 *
	 * Initialites some class variables...
	 *
	 * @return void
	 */
	public function __construct() {
		$this->tempDirectory = 'typo3temp/pmkshadowbox/';
		if (!is_dir(PATH_site . $this->tempDirectory)) {
			mkdir(PATH_site . $this->tempDirectory);
		}

		$this->players = array(
			'shadowbox-flv.js',
			'shadowbox-html.js',
			'shadowbox-iframe.js',
			'shadowbox-img.js',
			'shadowbox-qt.js',
			'shadowbox-swf.js',
			'shadowbox-wmp.js'
		);
	}

	/**
	 * Clear cache post processor.
	 *
	 * @param object $params parameter array
	 * @param object $pObj partent object
	 * @return void
	 */
	public function clearCachePostProc(&$params, &$pObj) {
		// only if the cache command is available
		if ($params['cacheCmd'] !== 'all') {
			return;
		}

		// only if the temporary directory exists
		if (!is_dir(PATH_site . $this->tempDirectory)) {
			return;
		}

		// remove any files in the directory
		$handle = opendir(PATH_site . $this->tempDirectory);
		while (false !== ($file = readdir($handle))) {
			if ($file == '.' || $file == '..') {
				continue;
			}

			if (is_file(PATH_site . $this->tempDirectory . $file)) {
				unlink(PATH_site . $this->tempDirectory . $file);
			}
		}
	}

	/**
	 * This function caches the selected javascript files into a single file. By this
	 * way we can reduce the initial load heavily and should gain a big speed boost.
	 * The name is a combination of the skin, language and adapter. The following files
	 * are included:
	 *
	 * - base shadowbox script
	 * - adapter script
	 * - language script
	 * - skin script
	 * - all player scripts
	 *
	 * @param string $content default script inclusions
	 * @param array $conf configuration/parameters (currently not used)
	 * @return string replacement script inclusion
	 */
	public function main($content, $conf) {
		// global extension configuration
        $this->extConfig = unserialize(
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['pmkshadowbox']
        );

		// do nothing if the disable flag is set
        if ($this->extConfig['disableCache']) {
            return $content;
        }

		// parse script tags
		$scriptTags = $this->parseContent($content);

		// built script files array
		$files = array();
		foreach ($scriptTags[1] as $script) {
			$filename = basename($script);
			$type = basename(dirname($script));

			// add script to the file array
			$files[$filename] = PATH_site . $script;

			// parse type for the main file name
			if ($type == 'adapters') {
				$adapter = substr($filename, 10, strrpos($filename, '.') - 10);
			} elseif ($type == 'languages') {
				$language = substr($filename, 10, strrpos($filename, '.') - 10);
			} elseif ($type !== 'players' && $type !== 'build') {
				$skin = $type;
			}
		}

		// merge player scripts
		foreach ($this->players as $playerScript) {
			$files[$playerScript] = t3lib_extMgm::extPath('pmkshadowbox') .
				'res/build/players/' . $playerScript;
		}

		// built final cache filename
		$cacheFileName = $adapter . '-' . $language . '-' . $skin . '.js';

		// merge files if the cache file doesn't already exists
		if (!file_exists(PATH_site . $this->tempDirectory . $cacheFileName)) {
			$mergedContent = $this->getMergedFileContents($files);
			t3lib_div::writeFile(
				PATH_site . $this->tempDirectory . $cacheFileName,
				$mergedContent
			);
		}

		// finally replace the script tags
		return $this->replaceScriptTags($content, $cacheFileName);
	}

	/**
	 * This function parses the given content and returns an array with all
	 * found entries with there related src attribute values.
	 *
	 * @param string $content html content
	 * @return array script tag matches
	 */
	protected function parseContent($content) {
		$matches = array();
		$prefix = preg_quote($this->extConfig['prefix'], '/');
		$pattern = '/<script.*?src="(.+?)".*?>.*?<\/script>/is';
		preg_match_all($pattern, $content, $matches);

		return $matches;
	}

	/**
	 * This function replaces all script tags of a given content with a
	 * single one.
	 *
	 * @param string $content content
	 * @param string $filename replacement file
	 * @return string content with the new script tag
	 */
	protected function replaceScriptTags($content, $filename) {
		// built new script tag
		$scriptTag = sprintf(
			'<script type="text/javascript" src="%s"></script>',
			$GLOBALS['TSFE']->absRefPrefix . $this->tempDirectory . $filename
		);

		// replace all script tags with the new one
		$content = preg_replace('/<script.+?>.*?<\/script>/is', '', $content);

		return $scriptTag . "\n" . $content;
	}

	/**
	 * Returns the contents of an array of given javascript files as a string. All files that
	 * has more than 20 lines are minified with JSMin.
	 *
	 * @param array $files files with absolute paths
	 * @return string merged file contents
	 */
	protected function getMergedFileContents(array $files) {
		$mergedContent = '';
		foreach ($files as $file) {
			$content = file($file);
			$lines = count($content);
			$content = implode("\n", $content);

			// we assume that files with less than 20 lines are not minified
			if ($lines > 20) {
				$content = JSMin::minify($content);
			}

			$mergedContent .= $content . "\n";
		}

		return $mergedContent;
	}

	/**
	 * Tests if a given file exists or not.
	 *
	 * @param string $content content
	 * @param array $conf config
	 * @return boolean true if file exists
	 */
	public function fileExists($content,$conf) {
		return @file_exists($this->cObj->stdWrap($conf['file'],$conf['file.']));
	}

	// @todo to be documented
	public function getPathToShadowboxRoot() {
		return t3lib_div::getIndpEnv('TYPO3_REQUEST_HOST') . '/' .
			str_replace(PATH_site, '', t3lib_extMgm::extPath('pmkshadowbox') . 'res/build/');
	}
}

?>
