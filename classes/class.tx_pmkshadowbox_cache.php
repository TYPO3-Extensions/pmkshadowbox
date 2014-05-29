<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Stefan Galinski (stefan.galinski@gmail.com)
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
 * This class handles all cache directory operations.
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */
class tx_pmkshadowbox_cache {
	/**
	 * Path to the Cache Directory
	 *
	 * @var string
	 */
	protected $cacheDirectory = '';

	/**
	 * Build Directory Name
	 *
	 * @var string
	 */
	protected $buildDirectory = '';

	/**
	 * Constructor
	 *
	 * Note: The cache directory is created if it does not already exists!
	 *
	 * @param string $cacheDirectory
	 * @throws Exception
	 */
	public function __construct($cacheDirectory = 'typo3temp/pmkshadowbox/') {
		$this->cacheDirectory = $cacheDirectory;
		if (!is_dir(PATH_site . $this->cacheDirectory)) {
			if (!t3lib_div::mkdir(PATH_site . $this->cacheDirectory)) {
				$message = 'Cache directory "' . PATH_site . $this->cacheDirectory .
					'" couldn\'t be created!';
				t3lib_div::sysLog($message, 'pmkshadowbox', t3lib_div::SYSLOG_SEVERITY_ERROR);
				throw new Exception($message);
			}
		}
	}

	/**
	 * Returns the cache directory
	 *
	 * @return string cache directory
	 */
	public function getCacheDirectory() {
		return $this->cacheDirectory;
	}

	/**
	 * Sets the build directory name
	 *
	 * Note: The directory is immediatly created!
	 *
	 * @param string $buildDirectory
	 * @return void
	 */
	public function setBuildDirectory($buildDirectory) {
		$this->buildDirectory = $buildDirectory;

		if (!is_dir(PATH_site . $this->cacheDirectory . $this->buildDirectory)) {
			t3lib_div::mkdir(PATH_site . $this->cacheDirectory . $this->buildDirectory);
		}
	}

	/**
	 * Removes all files and directories inside the cache directory
	 *
	 * @throws Exception if a file or directory couldn't be deleted
	 * @return void
	 */
	public function clear() {
		$cacheDirectoryIterator = new DirectoryIterator(PATH_site . $this->cacheDirectory);
		foreach ($cacheDirectoryIterator as $fileInfo) {
			/** @var $fileInfo DirectoryIterator */
			if ($fileInfo->isDot() || !$fileInfo->isDir()) {
				continue;
			}

			foreach (new DirectoryIterator($fileInfo->getPathname()) as $cacheFileInfo) {
				/** @var $cacheFileInfo DirectoryIterator */
				if ($cacheFileInfo->isDot()) {
					continue;
				}

				if (unlink($cacheFileInfo->getPathname()) === FALSE) {
					$message = 'cache->clear(): File "' .
						$cacheFileInfo->getPathname() . '" couldn\'t be removed!';
					t3lib_div::sysLog($message, 'pmkshadowbox', t3lib_div::SYSLOG_SEVERITY_ERROR);
					throw new Exception($message);
				}
			}

			if (rmdir($fileInfo->getPathname()) === FALSE) {
				$message = 'cache->clear(): Build directory "' .
					$fileInfo->getPathname() . '" couldn\'t be removed!';
				t3lib_div::sysLog($message, 'pmkshadowbox', t3lib_div::SYSLOG_SEVERITY_ERROR);
				throw new Exception($message);
			}
		}
	}

	/**
	 * Writes the cache file "shadowbox.js" into the given build directory
	 *
	 * @param string $scriptName
	 * @param string $scriptContent
	 * @throws Exception if the file could not be written
	 * @return string relative path to the written cache file
	 */
	public function writeCacheFile($scriptName, $scriptContent) {
		$script = $this->cacheDirectory . $this->buildDirectory . $scriptName;
		if (t3lib_div::writeFile(PATH_site . $script, $scriptContent) === FALSE) {
			$message = 'cache->writeCacheFile: Could not write the script file: ' . $script;
			t3lib_div::sysLog($message, 'pmkshadowbox', t3lib_div::SYSLOG_SEVERITY_ERROR);
			throw new Exception($message);
		}

		return $script;
	}

	/**
	 * Copies a resource to the build directory and returns the relative path to the
	 * copied resource.
	 *
	 * @param string $resource absolute path to the resource file
	 * @param string $fileName new name of the resource file (default: name of the resource file)
	 * @throws Exception if the resource could not be copied
	 * @return string
	 */
	public function copyResourceFile($resource, $fileName = '') {
		if ($fileName === '') {
			$fileName = basename($resource);
		}

		$destination = $this->cacheDirectory . $this->buildDirectory . $fileName;
		if (copy($resource, PATH_site . $destination) === FALSE) {
			$message = 'cache->copyResourceFile: Resource "' .
				$resource . '" couldn\'t be copied!';
			t3lib_div::sysLog($message, 'pmkshadowbox', t3lib_div::SYSLOG_SEVERITY_ERROR);
			throw new Exception($message);
		}

		return $destination;
	}

	/**
	 * Returns the relative path to the cache file directory.
	 *
	 * @return string
	 */
	public function getPathToBuildDirectory() {
		return $this->getCacheDirectory() . $this->buildDirectory;
	}

	/**
	 * Clear cache post processing hook
	 *
	 * @param array $parameters
	 * @param object $parent
	 * @return void
	 */
	public function clearCachePostProc($parameters, $parent) {
		if ($parameters['cacheCmd'] === 'all') {
			$this->clear();
		}
	}
}

if (defined(
		'TYPO3_MODE'
	) && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_pmkshadowbox_cache.php']
) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_pmkshadowbox_cache.php']);
}

?>
