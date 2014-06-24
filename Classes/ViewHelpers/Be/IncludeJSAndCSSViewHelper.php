<?php
namespace Evorion\Evchat\ViewHelpers\Be;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Vlatko Šurlan <vlatko.surlan@evorion.hr>, Evorion mediji j.d.o.o.
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * ViewHelper to include JavaScript and CSS
 *
 * @package validation_examples_new
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class IncludeJSAndCSSViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper {

	/**
	 * Includes the given Javascript file
	 *
	 * @return void
	 */
	public function render() {

		$doc = $this->getDocInstance();
		$pageRenderer = $doc->getPageRenderer();

		$pageRenderer->loadJquery(NULL, NULL, $pageRenderer::JQUERY_NAMESPACE_NONE);

		$extRelPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('evchat');
		$pageRenderer->addJsFile($extRelPath . 'Resources/Public/Js/jQueryWithUI/jquery-1.8.x-1.10.x.js');
		$pageRenderer->addJsFile($extRelPath . 'Resources/Public/Js/autogrow/autogrow.js');
		$pageRenderer->addJsFile($extRelPath . 'Resources/Public/Js/evChat.js');
		$pageRenderer->addCssFile($extRelPath . 'Resources/Public/Css/evChat.css');

	}

}

?>