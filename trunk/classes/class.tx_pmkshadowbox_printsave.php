<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Peter Klein <pmk@io.dk>
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
 * Class tx_pmkshadowbox_printsave
 */
class tx_pmkshadowbox_printsave {
	/**
	 * Main function
	 *
	 * @return void
	 */
	public function main() {
		$image = $this->cleanGPValue(t3lib_div::_GET('image'));
		// Check if the requested file has an valid image file extension
		$allowedExtensions = t3lib_div::trimExplode(
			',', (strlen(
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			) > 0 ? $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] : 'gif,jpg,jpeg,tif,bmp,pcx,tga,png,pdf,ai'), 1
		);
		$imageInfo = pathinfo($image);
		if (!in_array(
			strtolower($imageInfo['extension']), $allowedExtensions
		)
		) {
			die('You are trying to download/print a file, which you don\'t have access to.');
		}

		if (!is_file(
			t3lib_div::getFileAbsFileName(str_replace(t3lib_div::getIndpEnv('TYPO3_SITE_URL'), '', $image))
		)
		) {
			die('File not found!');
		}

		switch ($this->cleanGPValue(t3lib_div::_GET('mode'))) {
			case 'print':
				$this->print_image($image);
				break;
			case 'save':
				$this->force_download($image);
				break;
			default:
				break;
		}
	}

	/**
	 * @param string $filename
	 * @return void
	 */
	function print_image($filename) {
		echo '<html>
		<head>
			<title>Print</title>
			<script type="text/javascript">
			function printit(){
				try {
					window.print();
				}
				catch(err) {
					return;
				}
				window.close();
			}
			window.onload = printit;
			</script>
		</head>
		<body style="margin:0;padding:0;">
			<img src="' . $filename . '" style="border:none;cursor:pointer;" onclick="self.close()">
		</body>
	</html>';
	}

	/**
	 * @param string $filename
	 * @param string $mimetype
	 * @return bool
	 */
	public function force_download($filename, $mimetype = '') {
		$filename = str_replace(t3lib_div::getIndpEnv('TYPO3_SITE_URL'), PATH_site, $filename);
		if (!file_exists($filename)) {
			return FALSE;
		}

		// Mimetype not set?
		if (empty($mimetype)) {
			$file_extension = strtolower(substr(strrchr($filename, "."), 1));
			switch ($file_extension) {
				case "pdf":
					$mimetype = "application/pdf";
					break;
				case "exe":
					$mimetype = "application/octet-stream";
					break;
				case "zip":
					$mimetype = "application/zip";
					break;
				case "doc":
					$mimetype = "application/msword";
					break;
				case "xls":
					$mimetype = "application/vnd.ms-excel";
					break;
				case "ppt":
					$mimetype = "application/vnd.ms-powerpoint";
					break;
				case "gif":
					$mimetype = "image/gif";
					break;
				case "png":
					$mimetype = "image/png";
					break;
				case "jpeg":
				case "jpg":
					$mimetype = "image/jpg";
					break;
				default:
					$mimetype = "application/force-download";
			}
		}

		// Make sure there's nothing else left
		$this->ob_clean_all();

		// Start sending headers
		header('Pragma: public'); // required
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', FALSE); // required for certain browsers
		header('Content-Transfer-Encoding: binary');
		header('Content-Type: ' . $mimetype);
		header('Content-Length: ' . filesize($filename));
		header('Content-Disposition: attachment; filename="' . basename($filename) . '";');

		// Send data
		readfile($filename);
		exit;
	}

	/**
	 * @return bool
	 */
	private function ob_clean_all() {
		$ob_active = ob_get_length() !== FALSE;
		while ($ob_active) {
			ob_end_clean();
			$ob_active = ob_get_length() !== FALSE;
		}
		return TRUE;
	}

	/**
	 * Clean GET/POST values to prevent XSS/PoC attacks
	 *
	 * @param string $value
	 * @param int $htmlspecialchars
	 * @return mixed|string
	 */
	private function cleanGPValue($value, $htmlspecialchars = 1) {
		// Remove HTML tags in value
		$value = strip_tags($value);

		// Decode URL-encoded chars
		$value = rawurldecode($value);

		// Remove all characters with ascii value below 32
		$value = preg_replace('/[\x{00}-\x{1F}]/iu', '', $value);
		//$value = preg_replace('/\W/si', '', $value);

		// Convert special characters to HTML entities
		return $htmlspecialchars ? htmlspecialchars($value) : $value;
	}
}

if (defined(
		'TYPO3_MODE'
	) && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_pmkshadowbox_printsave.php']
) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_pmkshadowbox_printsave.php']);
}

// Make instance:
$output = t3lib_div::makeInstance('tx_pmkshadowbox_printsave');
$output->main();

?>