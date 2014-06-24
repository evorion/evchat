<?php
namespace Evorion\Evchat\Controller;


/***************************************************************
 *
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
 * ConversationController
 */
class ConversationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * conversationRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\ConversationRepository
	 * @inject
	 */
	protected $conversationRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$conversations = $this->conversationRepository->findAll();
		$this->view->assign('conversations', $conversations);
	}

	/**
	 * action show
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $conversation
	 * @return void
	 */
	public function showAction(\Evorion\Evchat\Domain\Model\Conversation $conversation = NULL) {
		$this->view->assign('conversation', $conversation);
	}

	/**
	 * action new
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $newConversation
	 * @ignorevalidation $newConversation
	 * @return void
	 */
	public function newAction(\Evorion\Evchat\Domain\Model\Conversation $newConversation = NULL) {
		$this->view->assign('newConversation', $newConversation);
	}

	/**
	 * action create
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $newConversation
	 * @return void
	 */
	public function createAction(\Evorion\Evchat\Domain\Model\Conversation $newConversation) {
		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->conversationRepository->add($newConversation);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $conversation
	 * @ignorevalidation $conversation
	 * @return void
	 */
	public function editAction(\Evorion\Evchat\Domain\Model\Conversation $conversation) {
		$this->view->assign('conversation', $conversation);
	}

	/**
	 * action update
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $conversation
	 * @return void
	 */
	public function updateAction(\Evorion\Evchat\Domain\Model\Conversation $conversation) {
		$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->conversationRepository->update($conversation);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $conversation
	 * @return void
	 */
	public function deleteAction(\Evorion\Evchat\Domain\Model\Conversation $conversation) {
		$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		$this->conversationRepository->remove($conversation);
		$this->redirect('list');
	}

}