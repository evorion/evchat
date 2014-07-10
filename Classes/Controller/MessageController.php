<?php
namespace Evorion\Evchat\Controller;

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
class MessageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * messageRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\MessageRepository
	 * @inject
	 */
	protected $messageRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$messages = $this->messageRepository->findAll();
		$this->view->assign('messages', $messages);
	}

	/**
	 * action new
	 *
	 * @param \Evorion\Evchat\Domain\Model\Message $newMessage
	 * @dontvalidate $newMessage
	 * @return void
	 */
	public function newAction(\Evorion\Evchat\Domain\Model\Message $newMessage = NULL) {
		$this->view->assign('newMessage', $newMessage);
	}

	/**
	 * action create
	 *
	 * @param \Evorion\Evchat\Domain\Model\Message $newMessage
	 * @return void
	 */
	public function createAction(\Evorion\Evchat\Domain\Model\Message $newMessage) {
		$this->messageRepository->add($newMessage);
		$this->flashMessageContainer->add('Your new Message was created.');
		$this->redirect('list');
	}

}
?>