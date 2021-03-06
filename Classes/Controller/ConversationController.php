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
 * @package evchat
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ConversationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * eventRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;

	/**
	 * conversationRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\ConversationRepository
	 * @inject
	 */
	protected $conversationRepository = NULL;
	
	/**
	 * visitorRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\VisitorRepository
	 * @inject
	 */
	protected $visitorRepository = NULL;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 * @inject
	 */
	protected $objectManager = NULL;

	/**
	 * Session Service provides access to user's PHP session
	 *
	 * @var \Evorion\Evchat\Domain\Service\SessionService
	 * @inject
	 */
	protected $sessionService = NULL;

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

		// Get the conversationKey either from an argument or the session
		if ($this->request->hasArgument('conversationKey'))
			$conversationKey = $this->request->getArgument('conversationKey');
		else
			$conversationKey = $this->sessionService->get('conversationKey');

		if ($conversation === NULL && $conversationKey)
			$conversation = $this->conversationRepository->findByConversationKey($conversationKey)->getFirst();
		else if ($conversation === NULL) {
			// There is no conversation so we create a new one
			$conversationKey = uniqid('', TRUE);
			$this->sessionService->set('conversationKey', $conversationKey);
			$conversation = $this->objectManager->get('Evorion\\Evchat\\Domain\\Model\\Conversation');
			$conversation->setConversationKey($conversationKey);
			$result = $this->conversationRepository->add($conversation);
			
			// Since we created a conversation there must be a Visitor that started it
			$visitor = $this->objectManager->get('Evorion\\Evchat\\Domain\\Model\\Visitor');
			$this->visitorRepository->add($visitor);
			
			// We need to persist here so we can get the database ID of the Visitor
			$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
			$persistenceManager->persistAll();

			// Save the uid of the visitor to the session
			$this->sessionService->set('Visitor', $visitor->getUid());

			// Create an Event which will trigger pollers
			$event = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Evorion\\Evchat\\Domain\\Model\\Event');
			$event->setObject('Conversation');
			$event->setEvent(
					json_encode(array(
						'conversationKey' => $conversationKey,
					))
			);
			$this->eventRepository->add($event);
		}

		$this->view->assign('conversation', $conversation);

	}

	/**
	 * action new
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $newConversation
	 * @dontvalidate $newConversation
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
		$this->conversationRepository->add($newConversation);
		$this->flashMessageContainer->add('Your new Conversation was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $conversation
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
		$this->conversationRepository->update($conversation);
		$this->flashMessageContainer->add('Your Conversation was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Evorion\Evchat\Domain\Model\Conversation $conversation
	 * @return void
	 */
	public function deleteAction(\Evorion\Evchat\Domain\Model\Conversation $conversation) {
		$this->conversationRepository->remove($conversation);
		$this->flashMessageContainer->add('Your Conversation was removed.');
		$this->redirect('list');
	}

	/**
	 * action poll
	 *
	 * @return void
	 */
	public function pollAction() {
		
	}

}
