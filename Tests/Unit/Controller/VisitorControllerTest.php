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
 * Test case for class Evorion\Evchat\Controller\VisitorController.
 *
 * @author Vlatko Šurlan <vlatko.surlan@evorion.hr>
 */
class VisitorControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Evorion\Evchat\Controller\VisitorController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('Evorion\\Evchat\\Controller\\VisitorController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllVisitorsFromRepositoryAndAssignsThemToView() {

		$allVisitors = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$visitorRepository = $this->getMock('Evorion\\Evchat\\Domain\\Repository\\VisitorRepository', array('findAll'), array(), '', FALSE);
		$visitorRepository->expects($this->once())->method('findAll')->will($this->returnValue($allVisitors));
		$this->inject($this->subject, 'visitorRepository', $visitorRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('visitors', $allVisitors);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}
}
