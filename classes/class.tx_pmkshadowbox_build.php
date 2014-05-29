<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Stefan Galinski (stefan.galinski@gmail.com)
 *  (c) 2010 Peter Klein (pmk@io.dk)
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

// unfortunately not automatically loaded
require_once(t3lib_extMgm::extPath('pmkshadowbox') . 'resources/jsmin.php');

/**
 * This class contains methods for building up the shadowbox script.
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 * @author Peter Klein <pmk@io.dk>
 */
class tx_pmkshadowbox_build {
	/**
	 * Content Object for Typoscript Operations
	 *
	 * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	public $cObj = NULL;

	/**
	 * Cache Handler
	 *
	 * @var tx_pmkshadowbox_cache
	 */
	protected $cacheHandler = NULL;

	/**
	 * Extension Configuration
	 *
	 * @var array
	 */
	protected $extensionConfiguration = array();

	/**
	 * Path to the Source Directory
	 *
	 * @var string
	 */
	protected $sourceDirectory = '';

	/**
	 * Constructor
	 *
	 * Note: If no cache handler parameter is given, the method will create a new one!
	 *
	 * @param tx_pmkshadowbox_cache $cacheHandler
	 * @throws Exception
	 */
	public function __construct($cacheHandler = NULL) {
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		$this->sourceDirectory = t3lib_extMgm::siteRelPath('pmkshadowbox') . 'resources/shadowbox/source/';
		$this->extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['pmkshadowbox']);

		if ($cacheHandler === NULL) {
			try {
				$this->cacheHandler = t3lib_div::makeInstance(
					'tx_pmkshadowbox_cache',
					'typo3temp/pmkshadowbox/'
				);
			} catch (Exception $exception) {
				t3lib_div::sysLog(
					$exception->getMessage(),
					'pmkshadowbox',
					t3lib_div::SYSLOG_SEVERITY_ERROR
				);
				throw $exception;
			}
		} else {
			$this->cacheHandler = $cacheHandler;
		}
	}

	/**
	 * Destructor
	 *
	 * @return void
	 */
	public function  __destruct() {
		unset($this->cacheHandler, $this->cObj);
	}

	/**
	 * Returns the cache handler
	 *
	 * @return tx_pmkshadowbox_cache
	 */
	public function getCacheHandler() {
		return $this->cacheHandler;
	}

	/**
	 * Applies the stdWrap typoscript property on all entries of the given array that
	 * are suffixed with a dot. The primitive value without a dot is overridden in this case.
	 *
	 * @param array $configuration typoscript configuration
	 * @return array normalized typoscript configuration
	 */
	protected function applyStdWrapOn(array $configuration) {
		if (!is_object($GLOBALS['TSFE'])) {
			$GLOBALS['TSFE'] = t3lib_div::makeInstance('tslib_fe', array(), 0, 0);
		}

		$newConfiguration = array();
		foreach ($configuration as $label => $value) {
			if (!is_array($value)) {
				$newConfiguration[$label] = $value;
				continue;
			}

			$labelWithoutDot = rtrim($label, '.');
			$newConfiguration[$labelWithoutDot] = $this->cObj->stdWrap('', $value);
		}

		return $newConfiguration;
	}

	/**
	 * Checks the availability of the adapter and returns the given value or 'base' as an
	 * hardcoded fallback value. It's returned as a relative path to the adapter based upon
	 * the TYPO3 root.
	 *
	 * @param string $adapter
	 * @return string
	 */
	protected function getAdapter($adapter) {
		$adapter = $this->sourceDirectory . 'adapters/' . $adapter . '.js';
		if (!file_exists(PATH_site . $adapter)) {
			$adapter = $this->sourceDirectory . 'adapters/base.js';
		}

		return $adapter;
	}

	/**
	 * Checks the availability of the given language. The second parameter is used
	 * as a fallback, but the hardcoded fallback will be 'en' in any case. The method
	 * returns the relative path to the language based upon the TYPO3 root.
	 *
	 * Note: The language 'de' is translated into 'de-DE' to simplify the usage in the
	 * typoscript configuration code.
	 *
	 * @param string $language
	 * @param string $languageFallback
	 * @return string
	 */
	protected function getLanguage($language, $languageFallback) {
		$language = ($language === 'de' ? 'de-DE' : $language);
		$language = $this->sourceDirectory . 'languages/' . $language . '.js';
		if (!file_exists(PATH_site . $language)) {
			$languageFallback = ($languageFallback === 'de' ? 'de-DE' : $languageFallback);
			$language = $this->sourceDirectory . 'languages/' . $languageFallback . '.js';
			if (!file_exists(PATH_site . $language)) {
				$language = $this->sourceDirectory . 'languages/en.js';
			}
		}

		return $language;
	}

	/**
	 * Checks the availability of the given players and returns an array with all
	 * available ones. The values are prefixed with the relative directory based upon
	 * the TYPO3 root.
	 *
	 * @param array $wantedPlayers wanted players
	 * @return array available players
	 */
	protected function getPlayers(array $wantedPlayers) {
		$availablePlayers = array();
		foreach ($wantedPlayers as $player) {
			$player = $this->sourceDirectory . 'players/' . trim($player) . '.js';
			if (file_exists(PATH_site . $player)) {
				$availablePlayers[] = $player;
			}
		}

		return $availablePlayers;
	}

	/**
	 * Checks the given typoscript configuration variable and returns the relative path
	 * to the sizzle javascript file based on the TYPO3 root directory. Otherwise an blank
	 * string will be returned.
	 *
	 * @param mixed $useSizzle see method description
	 * @return string
	 */
	protected function getCssSelectorSupport($useSizzle) {
		$sizzle = '';
		if ($useSizzle == 1) {
			$sizzle = $this->sourceDirectory . 'find.js';
		}

		return $sizzle;
	}

	/**
	 * Checks the availability of the skin modification and returns the normalized, relative
	 * path based on the TYPO3 root directory. If the file doesn't exists a blank string is
	 * returned.
	 *
	 * @param string $typo3SkinModificationDirectory TYPO3 path to a skin modification directory
	 * @return string
	 */
	protected function getSkinModificationDirectory($typo3SkinModificationDirectory) {
		$skinModificationDirectory = t3lib_div::getFileAbsFileName($typo3SkinModificationDirectory);
		if (is_dir($skinModificationDirectory)) {
			$skinModificationDirectory = str_replace(PATH_site, '', $skinModificationDirectory);
		} else {
			$skinModificationDirectory = '';
		}

		return $skinModificationDirectory;
	}

	/**
	 * Checks the availability of the given flash player and returns the normalized, relative
	 * path based on the TYPO3 root directory. If the file doesn't exists a blank string is
	 * returned.
	 *
	 * @param string $flashPlayer relative path to a flash player script
	 * @return string
	 */
	protected function getFlashPlayer($flashPlayer) {
		$flashPlayer = t3lib_div::getFileAbsFileName($flashPlayer);
		if (file_exists($flashPlayer)) {
			$flashPlayer = str_replace(PATH_site, '', $flashPlayer);
		} else {
			$flashPlayer = '';
		}

		return $flashPlayer;
	}

	/**
	 * Checks the availability of the given flash player YouTube companion and returns the normalized, relative
	 * path based on the TYPO3 root directory. If the file doesn't exists a blank string is
	 * returned.
	 *
	 * @param string $flashPlayerYT relative path to a flash player script
	 * @return string
	 */
	protected function getFlashPlayerYT($flashPlayerYT) {
		$flashPlayerYT = t3lib_div::getFileAbsFileName($flashPlayerYT);
		if (file_exists($flashPlayerYT)) {
			$flashPlayerYT = str_replace(PATH_site, '', $flashPlayerYT);
		} else {
			$flashPlayerYT = '';
		}

		return $flashPlayerYT;
	}

	/**
	 * Checks the availability of the given express install script and returns the normalized,
	 * relative path based on the TYPO3 root directory. If the file doesn't exists a blank
	 * string is returned.
	 *
	 * @param string $flashExpressInstallScript relative path to the script
	 * @return string
	 */
	protected function getFlashExpressInstallScript($flashExpressInstallScript) {
		$flashExpressInstallScript = t3lib_div::getFileAbsFileName($flashExpressInstallScript);

		if (file_exists($flashExpressInstallScript)) {
			$flashExpressInstallScript = str_replace(PATH_site, '', $flashExpressInstallScript);
		} else {
			$flashExpressInstallScript = '';
		}

		return $flashExpressInstallScript;
	}

	/**
	 * Returns the skin modification javascript if it's exists!
	 *
	 * @param string $skinModificationDirectory
	 * @return string
	 */
	protected function getSkinModificationJavaScript($skinModificationDirectory) {
		$skinModificationJavaScript = '';
		if ($skinModificationDirectory !== '' &&
			file_exists(PATH_site . $skinModificationDirectory . 'skin.js')
		) {
			$skinModificationJavaScript = $skinModificationDirectory . 'skin.js';
		}

		return $skinModificationJavaScript;
	}

	/**
	 * Checks the players array for the values 'flv' and 'swf'. If the match is
	 * positive we are returning a relative path to the flash script based on the TYPO3 root.
	 * Otherwise an emptry string will be returned.
	 *
	 * @param array $players
	 * @return string
	 */
	protected function needsFlash(array $players) {
		$flash = '';
		$playerNames = array_map('basename', $players);
		if (in_array('flv.js', $playerNames) || in_array('swf.js', $playerNames)) {
			$flash = $this->sourceDirectory . 'flash.js';
		}

		return $flash;
	}

	/**
	 * Returns the file name without the file extension from a normal path string.
	 *
	 * @param string $filePath
	 * @return string
	 */
	protected function getFileNameWithoutExtension($filePath) {
		$fileName = basename($filePath);
		return substr($fileName, 0, strrpos($fileName, '.'));
	}

	/**
	 * Creates the scriptfile with the name "$scriptname" based upon the array in
	 * "$scripts" and their defined order.
	 *
	 * @param array $scripts
	 * @throws Exception if a file could not be read or written
	 * @return string relative path to the cache file
	 */
	protected function createScriptFile(array $scripts) {
		$scriptContent = '';
		foreach ($scripts as $script) {
			if (($content = file_get_contents(PATH_site . $script)) === FALSE) {
				$message = 'Could not read the source file: ' . PATH_site . $script;
				t3lib_div::sysLog($message, 'pmkshadowbox', t3lib_div::SYSLOG_SEVERITY_ERROR);
				throw new Exception($message);
			}
			$scriptContent .= $content;
		}

		// the scriptmerger check prevents the minification of the script twice!
		if ($this->extensionConfiguration['enableJavascriptMinification'] === '1' &&
			!t3lib_extMgm::isLoaded('scriptmerger')
		) {
			$scriptContent = JSMin::minify($scriptContent);
		}

		return $this->cacheHandler->writeCacheFile('shadowbox.js', $scriptContent);
	}

	/**
	 * Copies the resources of the shadowbox source folder inside the build directory. If a
	 * skin modification directory is passed and the folder contains a "resources" directory,
	 * we copy the contents inside the build directory. This can be used to override the default
	 * resources of the shadowbox.
	 *
	 * @param string $skinModificationDirectory
	 * @return void
	 */
	protected function copySkinResources($skinModificationDirectory) {
		// copy the default resources
		$absoluteSourceDirectory = PATH_site . $this->sourceDirectory . 'resources/';
		$directoryHandler = new DirectoryIterator($absoluteSourceDirectory);
		$allowedFileExtensions = array('png', 'gif', 'jpg', 'css');
		foreach ($directoryHandler as $fileInfo) {
			/** @var $fileInfo DirectoryIterator */
			if ($fileInfo->isFile()) {
				$fileName = $fileInfo->getFilename();
				$fileExtension = substr($fileName, strrpos($fileName, '.') + 1);
				if (!in_array($fileExtension, $allowedFileExtensions)) {
					continue;
				}

				$this->cacheHandler->copyResourceFile($fileInfo->getPathname());
			}
		}

		// copy the skin modification resources if available
		$resourceFolder = PATH_site . $skinModificationDirectory . 'resources/';
		if (is_dir($resourceFolder)) {
			$directoryHandler = new DirectoryIterator($resourceFolder);
			foreach ($directoryHandler as $fileInfo) {
				if ($fileInfo->isDot() || $fileInfo->isDir()) {
					continue;
				}

				$this->cacheHandler->copyResourceFile($fileInfo->getPathname());
			}
		}
	}

	/**
	 * Copies the flash player resources to the build directory
	 *
	 * Note: The two parameters can be used to override the default resource
	 *
	 * @param string $flashPlayer relative path to an alternative flash player (default: blank)
	 * @param string $flashPlayerYT relative path to an alternative flash player (default: blank)
	 * @param string $expressInstallScript relative path to an express install script (default: blank)
	 * @return void
	 */
	protected function copyFlashResources($flashPlayer = '', $flashPlayerYT = '', $expressInstallScript = '') {
		if ($flashPlayer === '') {
			$flashPlayer = $this->sourceDirectory . 'resources/player.swf';
		}
		$this->cacheHandler->copyResourceFile(PATH_site . $flashPlayer, 'player.swf');

		if ($flashPlayerYT === '') {
			$flashPlayerYT = $this->sourceDirectory . 'resources/yt.swf';
		}
		$this->cacheHandler->copyResourceFile(PATH_site . $flashPlayerYT, 'yt.swf');

		if ($expressInstallScript === '') {
			$expressInstallScript = $this->sourceDirectory . 'resources/expressInstall.swf';
		}
		$this->cacheHandler->copyResourceFile(PATH_site . $expressInstallScript, 'expressInstall.swf');
	}

	/**
	 * Returns the name of the build directory based upon the given configuration.
	 *
	 * @param array $configuration
	 * @return string
	 */
	protected function getNameOfBuildDirectory(array $configuration) {
		$playerNames = array_map(
			array($this, 'getFileNameWithoutExtension'),
			$configuration['players']
		);
		$playerNames = implode('-', $playerNames);

		$flashPlayerName = '';
		if ($configuration['flashPlayer'] !== '') {
			$flashPlayerName = '-' . $this->getFileNameWithoutExtension($configuration['flashPlayer']);
		}

		$flashExpressInstallScriptName = '';
		if ($configuration['flashExpressInstallScript'] !== '') {
			$flashExpressInstallScriptName = '-' . $this->
					getFileNameWithoutExtension($configuration['flashExpressInstallScript']);
		}

		$buildDirectory = $this->getFileNameWithoutExtension($configuration['adapter']) . '-' .
			$this->getFileNameWithoutExtension($configuration['language']);
		$buildDirectory .= ($playerNames !== '' ? '-' . $playerNames : '');
		$buildDirectory .= ($configuration['useSizzle'] !== '' ? '-sizzle' : '');
		$buildDirectory .= ($configuration['skinModificationDirectory'] !== '' ? '-' .
			basename($configuration['skinModificationDirectory']) : '');
		$buildDirectory .= $flashPlayerName . $flashExpressInstallScriptName;
		$buildDirectory .= '/';

		return $buildDirectory;
	}

	/**
	 * Returns an array with the shadowbox source javascripts and modifications in the
	 * needed order.
	 *
	 * @param array $configuration
	 * @return array
	 */
	protected function getOrderedScripts(array $configuration) {
		$scripts = array_merge(
			array(
				$this->sourceDirectory . 'intro.js',
				$this->sourceDirectory . 'core.js',
				$this->sourceDirectory . 'util.js',
				$configuration['adapter'],
				$this->sourceDirectory . 'load.js',
				$this->sourceDirectory . 'plugins.js',
				$this->sourceDirectory . 'cache.js',
				$configuration['useSizzle'], $configuration['useFlash'], $configuration['language']
			), $configuration['players'], array(
				$this->sourceDirectory . 'skin.js',
				$this->getSkinModificationJavaScript($configuration['skinModificationDirectory']),
				$this->sourceDirectory . 'outro.js'
			)
		);

		return t3lib_div::removeArrayEntryByValue($scripts, '');
	}

	/**
	 * This function builds a new shadowbox directory from the sources based upon the
	 * selected configuration. The new directory is saved inside "typo3temp/pmkshadowbox".
	 *
	 * Configuration options:
	 * - useSizzle: sizzle for css selector usage
	 * - players: the players (e.g. "iframe,html,swf")
	 * - adapter: the framework adapter (e.g. "mootools")
	 * - language: the language (e.g. "de")
	 * - languageFallback language fallback if the selected one doesn't exists (e.g. "en")
	 *
	 * @param string $content current content
	 * @param array $configuration configuration parameters (stdWrap allowed!)
	 * @return string relative path to the build directory
	 */
	public function build($content, array $configuration) {
		// prepare the configuration (apply stdWrap, fallbacks and existence checks)
		$configuration = $this->applyStdWrapOn($configuration);

		$configuration['adapter'] = $this->getAdapter($configuration['adapter']);
		$configuration['players'] = $this->getPlayers(explode(',', $configuration['players']));
		$configuration['useFlash'] = $this->needsFlash($configuration['players']);
		$configuration['useSizzle'] = $this->getCssSelectorSupport($configuration['useSizzle']);
		$configuration['flashPlayer'] = $this->getFlashPlayer($configuration['flashPlayer']);
		$configuration['flashPlayerYT'] = $this->getFlashPlayerYT($configuration['flashPlayerYT']);
		$configuration['flashExpressInstallScript'] = $this->
			getFlashExpressInstallScript($configuration['flashExpressInstallScript']);
		$configuration['skinModificationDirectory'] = $this->
			getSkinModificationDirectory($configuration['skinModificationDirectory']);
		$configuration['language'] = $this->
			getLanguage($configuration['language'], $configuration['languageFallback']);

		// get the name of the final build directory
		$buildDirectory = $this->getNameOfBuildDirectory($configuration);
		$this->cacheHandler->setBuildDirectory($buildDirectory);

		// an existing cache directory can be delivered immediately
		$buildDirectory = $this->cacheHandler->getPathToBuildDirectory();
		if (file_exists($buildDirectory . 'shadowbox.js')) {
			return $buildDirectory;
		}

		// otherwise create a new one
		$this->createScriptFile(
			$this->getOrderedScripts($configuration)
		);

		$this->copySkinResources($configuration['skinModificationDirectory']);
		if ($configuration['useFlash'] !== '') {
			$this->copyFlashResources(
				$configuration['flashPlayer'],
				$configuration['flashPlayerYT'],
				$configuration['flashExpressInstallScript']
			);
		}

		return $buildDirectory;
	}
}

if (defined(
		'TYPO3_MODE'
	) && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_pmkshadowbox_build.php']
) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_pmkshadowbox_build.php']);
}

?>
