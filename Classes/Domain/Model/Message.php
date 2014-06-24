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
 * Message
 *
 * @package evchat
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Message extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * body
	 *
	 * @var string
	 */
	protected $body = '';

	/**
	 * time
	 *
	 * @var \DateTime
	 */
	protected $time = NULL;

	/**
	 * Parent conversation
	 *
	 * @var \Evorion\Evchat\Domain\Model\Conversation
	 */
	protected $conversation = NULL;

	/**
	 * Visitor that sent the message, if it was a visitor.
	 *
	 * @var \Evorion\Evchat\Domain\Model\Visitor
	 */
	protected $visitor = NULL;

	/**
	 * administrator
	 *
	 * @var integer
	 */
	protected $administrator = 0;

	/**
	 * Returns the body
	 *
	 * @return \string $body
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * Sets the body
	 *
	 * @param \string $body
	 * @return void
	 */
	public function setBody($body) {
		$this->body = $body;
	}

	/**
	 * Returns the time
	 *
	 * @return \DateTime $time
	 */
	public function getTime() {
		return $this->time;
	}

	/**
	 * Sets the time
	 *
	 * @param \DateTime $time
	 * @return void
	 */
	public function setTime($time) {
		$this->time = $time;
	}

	/**
	 * Returns the conversation
	 *
	 * @return \Evorion\Evchat\Domain\Model\Conversation $conversation
	 */
	public function getConversation() {
		return $this->conversation;
	}

	/**
	 * Sets the conversation
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $conversation
	 * @return void
	 */
	public function setConversation(\Evorion\Evchat\Domain\Model\Conversation $conversation) {
		$this->conversation = $conversation;
	}

	/**
	 * Returns the visitor
	 *
	 * @return \Evorion\Evchat\Domain\Model\Visitor $visitor
	 */
	public function getVisitor() {
		return $this->visitor;
	}

	/**
	 * Sets the visitor
	 *
	 * @param \Evorion\Evchat\Domain\Model\Visitor $visitor
	 * @return void
	 */
	public function setVisitor(\Evorion\Evchat\Domain\Model\Visitor $visitor) {
		$this->visitor = $visitor;
	}

	/**
	 * Returns the administrator
	 *
	 * @return integer $administrator
	 */
	public function getAdministrator() {
		return $this->administrator;
	}

	/**
	 * Sets the administrator
	 *
	 * @param integer $administrator
	 * @return void
	 */
	public function setAdministrator($administrator) {
		$this->administrator = $administrator;
	}

}