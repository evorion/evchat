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
class MessageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * messageRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\MessageRepository
	 * @inject
	 */
	protected $messageRepository = NULL;

	/**
	 * conversationRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\ConversationRepository
	 * @inject
	 */
	protected $conversationRepository = NULL;

	/**
	 * eventRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;

	/**
	 * visitorRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\VisitorRepository
	 * @inject
	 */
	protected $visitorRepository = NULL;

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
	 * @param int $tracker
	 * @return void
	 */
	public function listAction($tracker = 0) {
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

		// Connect the Message to the Conversation
		$conversation = $this->conversationRepository->findOneByConversationKey($this->request->getArgument('conversationKey'));
		if (!is_object($conversation)) throw Exception('Failed to find conversation by key!');
		$newMessage->setConversation($conversation);

		// Connect the message to either a Visitor or an Administrator
		if ($GLOBALS['BE_USER']) {
			$newMessage->setAdministrator($GLOBALS['BE_USER']->user['uid']);
		} else {
			$visitorUID = $this->sessionService->get('Visitor');
			$visitor = $this->visitorRepository->findByUid($visitorUID);
			$newMessage->setVisitor($visitor);
		}

		$this->messageRepository->add($newMessage);
		
		// Create an Event which will trigger pollers
		$event = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Evorion\\Evchat\\Domain\\Model\\Event');
		$event->setObject('Message\\' . $conversation->getConversationKey());
		$event->setEvent(
			json_encode(array(
				'body'				=> $newMessage->getBody(),
				'admin'				=> $newMessage->getAdministrator() ? $newMessage->getAdministrator() : NULL,
				'visitor'			=> $newMessage->getVisitor() ? $newMessage->getVisitor()->getUid() : NULL
			))
		);
		$this->eventRepository->add($event);
		return json_encode(array('result' => true));

	}

}