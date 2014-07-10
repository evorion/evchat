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
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * eventRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$events = $this->eventRepository->findAll();
		$this->view->assign('events', $events);
	}

	/**
	 * action new
	 *
	 * @param \Evorion\Evchat\Domain\Model\Event $newEvent
	 * @dontvalidate $newEvent
	 * @return void
	 */
	public function newAction(\Evorion\Evchat\Domain\Model\Event $newEvent = NULL) {
		$this->view->assign('newEvent', $newEvent);
	}

	/**
	 * action create
	 *
	 * @param \Evorion\Evchat\Domain\Model\Event $newEvent
	 * @return void
	 */
	public function createAction(\Evorion\Evchat\Domain\Model\Event $newEvent) {
		$this->eventRepository->add($newEvent);
		$this->flashMessageContainer->add('Your new Event was created.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Evorion\Evchat\Domain\Model\Event $event
	 * @return void
	 */
	public function deleteAction(\Evorion\Evchat\Domain\Model\Event $event) {
		$this->eventRepository->remove($event);
		$this->flashMessageContainer->add('Your Event was removed.');
		$this->redirect('list');
	}

}
?>