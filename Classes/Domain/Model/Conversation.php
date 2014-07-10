<?php
namespace Evorion\Evchat\Domain\Model;

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
 *
 *
 * @package evchat
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Conversation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * conversationKey
	 *
	 * @var \string
	 */
	protected $conversationKey;

	/**
	 * Returns the conversationKey
	 *
	 * @return \string $conversationKey
	 */
	public function getConversationKey() {
		return $this->conversationKey;
	}

	/**
	 * Sets the conversationKey
	 *
	 * @param \string $conversationKey
	 * @return void
	 */
	public function setConversationKey($conversationKey) {
		$this->conversationKey = $conversationKey;
	}

}
?>