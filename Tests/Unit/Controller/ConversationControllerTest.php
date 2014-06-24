<?php
namespace Evorion\Evchat\Tests\Unit\Controller;
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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Evorion\Evchat\Controller\ConversationController.
 *
 * @author Vlatko Šurlan <vlatko.surlan@evorion.hr>
 */
class ConversationControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Evorion\Evchat\Controller\ConversationController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('Evorion\\Evchat\\Controller\\ConversationController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllConversationsFromRepositoryAndAssignsThemToView() {

		$allConversations = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$conversationRepository = $this->getMock('Evorion\\Evchat\\Domain\\Repository\\ConversationRepository', array('findAll'), array(), '', FALSE);
		$conversationRepository->expects($this->once())->method('findAll')->will($this->returnValue($allConversations));
		$this->inject($this->subject, 'conversationRepository', $conversationRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('conversations', $allConversations);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenConversationToView() {
		$conversation = new \Evorion\Evchat\Domain\Model\Conversation();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('conversation', $conversation);

		$this->subject->showAction($conversation);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenConversationToView() {
		$conversation = new \Evorion\Evchat\Domain\Model\Conversation();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newConversation', $conversation);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($conversation);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenConversationToConversationRepository() {
		$conversation = new \Evorion\Evchat\Domain\Model\Conversation();

		$conversationRepository = $this->getMock('Evorion\\Evchat\\Domain\\Repository\\ConversationRepository', array('add'), array(), '', FALSE);
		$conversationRepository->expects($this->once())->method('add')->with($conversation);
		$this->inject($this->subject, 'conversationRepository', $conversationRepository);

		$this->subject->createAction($conversation);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenConversationToView() {
		$conversation = new \Evorion\Evchat\Domain\Model\Conversation();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('conversation', $conversation);

		$this->subject->editAction($conversation);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenConversationInConversationRepository() {
		$conversation = new \Evorion\Evchat\Domain\Model\Conversation();

		$conversationRepository = $this->getMock('Evorion\\Evchat\\Domain\\Repository\\ConversationRepository', array('update'), array(), '', FALSE);
		$conversationRepository->expects($this->once())->method('update')->with($conversation);
		$this->inject($this->subject, 'conversationRepository', $conversationRepository);

		$this->subject->updateAction($conversation);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenConversationFromConversationRepository() {
		$conversation = new \Evorion\Evchat\Domain\Model\Conversation();

		$conversationRepository = $this->getMock('Evorion\\Evchat\\Domain\\Repository\\ConversationRepository', array('remove'), array(), '', FALSE);
		$conversationRepository->expects($this->once())->method('remove')->with($conversation);
		$this->inject($this->subject, 'conversationRepository', $conversationRepository);

		$this->subject->deleteAction($conversation);
	}
}
