<?php
/***************************************************************
*  Copyright notice
*
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
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * This class contains a hook class for modifying the tt_news image markers
 * It just add a "IMAGE_NUM_CURRENT" register value, so that pmkshadowbox
 * can use navigation on tt_news images.
 *
 * @author Peter Klein <pmk@io.dk>
 */
class tx_ttnews_imageMarker extends tslib_pibase {
	var $prefixId = "tx_ttnews_imageMarkerHook";		// Same as class name
	var $scriptRelPath = "class.tx_ttnews_imageMarkerHook.php";	// Path to this script relative to the extension dir.
	var $extKey = "tt_news";	// The extension key.

	function extraItemMarkerProcessor($parentMarkerArray, $row, $lConf, $tt_news) {
		$tt_news->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->conf = &$tt_news->conf;

		if ($tt_news->config['FFimgH'] || $tt_news->config['FFimgW']) {
			$lConf['image.']['file.']['maxW'] = $tt_news->config['FFimgW'];
			$lConf['image.']['file.']['maxH'] = $tt_news->config['FFimgH'];
		}

		$this->makeImageMarkers($row,$lConf,$tt_news,$parentMarkerArray);

		return $parentMarkerArray;
	}

	function makeImageMarkers($row,$lConf,$tt_news,&$parentMarkerArray) {
		$imageNum = isset($lConf['imageCount']) ? $lConf['imageCount'] : 1;
		if (class_exists('t3lib_utility_Math')) {
			$imageNum = t3lib_utility_Math::forceIntegerInRange($imageNum, 0, 100);
		} else {
			$imageNum = t3lib_div::intInRange($imageNum, 0, 100);
		}
		$theImgCode = '';
		$imgs = t3lib_div::trimExplode(',', $row['image'], 1);
		$imgsCaptions = explode(chr(10), $row['imagecaption']);
		$imgsAltTexts = explode(chr(10), $row['imagealttext']);
		$imgsTitleTexts = explode(chr(10), $row['imagetitletext']);

		$textRenderObj = $tt_news->theCode;

		reset($imgs);

		if ($textRenderObj == 'displaySingle' || $textRenderObj == 'SINGLE') {
			$parentMarkerArray = $this->getSingleViewImages($lConf, $imgs, $imgsCaptions, $imgsAltTexts, $imgsTitleTexts, $imageNum, $parentMarkerArray,$tt_news);
		} else {

			$imageMode = (strpos($textRenderObj, 'LATEST') ? $lConf['latestImageMode'] : $lConf['listImageMode']);

			$suf = '';
			if (is_numeric(substr($lConf['image.']['file.']['maxW'], - 1))) { // 'm' or 'c' not set by TS
				if ($imageMode) {
					switch ($imageMode) {
						case 'resize2max' :
							$suf = 'm';
							break;
						case 'crop' :
							$suf = 'c';
							break;
						case 'resize' :
							$suf = '';
							break;
					}
				}
			}

				// only insert width/height if it is not given by TS and width/height is empty
			if ($lConf['image.']['file.']['maxW'] && ! $lConf['image.']['file.']['width']) {
				$lConf['image.']['file.']['width'] = $lConf['image.']['file.']['maxW'] . $suf;
				unset($lConf['image.']['file.']['maxW']);
			}
			if ($lConf['image.']['file.']['maxH'] && ! $lConf['image.']['file.']['height']) {
				$lConf['image.']['file.']['height'] = $lConf['image.']['file.']['maxH'] . $suf;
				unset($lConf['image.']['file.']['maxH']);
			}

			$cc = 0;
			foreach ($imgs as $val) {
				if ($cc == $imageNum)
					break;
				if ($val) {
					$lConf['image.']['altText'] = $imgsAltTexts[$cc];
					$lConf['image.']['titleText'] = $imgsTitleTexts[$cc];
					$lConf['image.']['file'] = 'uploads/pics/' . $val;
					$GLOBALS['TSFE']->register['IMAGE_NUM_CURRENT'] = $cc;

					$theImgCode .= $tt_news->local_cObj->IMAGE($lConf['image.']) . $tt_news->local_cObj->stdWrap($imgsCaptions[$cc], $lConf['caption_stdWrap.']);
				}
				$cc++;
			}

			if ($cc) {
				$parentMarkerArray['###NEWS_IMAGE###'] = $tt_news->local_cObj->wrap($theImgCode, $lConf['imageWrapIfAny']);
			} else {
				$parentMarkerArray['###NEWS_IMAGE###'] = $tt_news->local_cObj->stdWrap($parentMarkerArray['###NEWS_IMAGE###'], $lConf['image.']['noImage_stdWrap.']);
			}
		}
	}

	/**
	 * Fills the image markers for the SINGLE view with data. Supports Optionssplit for some parameters
	 *
	 * @param	[type]		$lConf: ...
	 * @param	[type]		$imgs: ...
	 * @param	[type]		$imgsCaptions: ...
	 * @param	[type]		$imgsAltTexts: ...
	 * @param	[type]		$imgsTitleTexts: ...
	 * @param	[type]		$imageNum: ...
	 * @return	array		$markerArray: filled markerarray
	 */
	function getSingleViewImages($lConf, $imgs, $imgsCaptions, $imgsAltTexts, $imgsTitleTexts, $imageNum, $markerArray,$tt_news) {
		$marker = 'NEWS_IMAGE';
		$sViewSplitLConf = array();
		$tmpMarkers = array();
		$iC = count($imgs);

		// remove first img from image array in single view if the TSvar firstImageIsPreview is set
		if (($iC > 1 && $tt_news->config['firstImageIsPreview']) || ($iC >= 1 && $tt_news->config['forceFirstImageIsPreview'])) {
			array_shift($imgs);
			array_shift($imgsCaptions);
			array_shift($imgsAltTexts);
			array_shift($imgsTitleTexts);
			$iC--;
		}

		if ($iC > $imageNum) {
			$iC = $imageNum;
		}

		// get img array parts for single view pages
		if ($tt_news->piVars[$tt_news->config['singleViewPointerName']]) {
			$spage = $tt_news->piVars[$tt_news->config['singleViewPointerName']];
			$astart = $imageNum * $spage;
			$imgs = array_slice($imgs, $astart, $imageNum);
			$imgsCaptions = array_slice($imgsCaptions, $astart, $imageNum);
			$imgsAltTexts = array_slice($imgsAltTexts, $astart, $imageNum);
			$imgsTitleTexts = array_slice($imgsTitleTexts, $astart, $imageNum);
		}

		if ($tt_news->conf['enableOptionSplit']) {
			if ($lConf['imageMarkerOptionSplit']) {
				$ostmp = explode('|*|', $lConf['imageMarkerOptionSplit']);
				$osCount = count($ostmp);
			}
			$sViewSplitLConf = $tt_news->processOptionSplit($lConf, $iC);
		}

		// reset markers for optionSplitted images
		for ($m = 1; $m <= $imageNum; $m++) {
			$markerArray['###' . $marker . '_' . $m . '###'] = '';
		}

		$cc = 0;
		$theImgCode = '';
		foreach ($imgs as $val) {
			if ($cc == $imageNum)
				break;
			if ($val) {
				if (! empty($sViewSplitLConf[$cc])) {
					$lConf = $sViewSplitLConf[$cc];
				}

				$lConf['image.']['altText'] = $imgsAltTexts[$cc];
				$lConf['image.']['titleText'] = $imgsTitleTexts[$cc];
				$lConf['image.']['file'] = 'uploads/pics/' . $val;
				$GLOBALS['TSFE']->register['IMAGE_NUM_CURRENT'] = $cc;

				$imgHtml = $tt_news->local_cObj->IMAGE($lConf['image.']) . $tt_news->local_cObj->stdWrap($imgsCaptions[$cc], $lConf['caption_stdWrap.']);

				if ($osCount) {
					if ($iC > 1) {
						$mName = '###' . $marker . '_' . $lConf['imageMarkerOptionSplit'] . '###';
					} else { // fall back to the first image marker if only one image has been found
						$mName = '###' . $marker . '_1###';
					}
					$tmpMarkers[$mName]['html'] .= $imgHtml;
					$tmpMarkers[$mName]['wrap'] = $lConf['imageWrapIfAny'];
				} else {
					$theImgCode .= $imgHtml;
				}
			}
			$cc++;
		}

		if ($cc) {
			if ($osCount) {
				foreach ($tmpMarkers as $mName => $res) {
					$markerArray[$mName] = $tt_news->local_cObj->wrap($res['html'], $res['wrap']);
				}
			} else {
				$markerArray['###' . $marker . '###'] = $tt_news->local_cObj->wrap($theImgCode, $lConf['imageWrapIfAny']);
			}
		} else {
			if ($lConf['imageMarkerOptionSplit']) {
				$m = '_1';
			}
			$markerArray['###' . $marker . $m . '###'] = $tt_news->local_cObj->stdWrap($markerArray['###' . $marker . $m . '###'], $lConf['image.']['noImage_stdWrap.']);
		}

		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_ttnews_imageMarkerHook.php'])  {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_ttnews_imageMarkerHook.php']);
}

?>