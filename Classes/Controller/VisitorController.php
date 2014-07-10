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
class VisitorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * visitorRepository
	 *
	 * @var \Evorion\Evchat\Domain\Repository\VisitorRepository
	 * @inject
	 */
	protected $visitorRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$visitors = $this->visitorRepository->findAll();
		$this->view->assign('visitors', $visitors);
	}

	/**
	 * action show
	 *
	 * @param \Evorion\Evchat\Domain\Model\Visitor $visitor
	 * @return void
	 */
	public function showAction(\Evorion\Evchat\Domain\Model\Visitor $visitor) {
		$this->view->assign('visitor', $visitor);
	}

	/**
	 * action new
	 *
	 * @param \Evorion\Evchat\Domain\Model\Visitor $newVisitor
	 * @dontvalidate $newVisitor
	 * @return void
	 */
	public function newAction(\Evorion\Evchat\Domain\Model\Visitor $newVisitor = NULL) {
		$this->view->assign('newVisitor', $newVisitor);
	}

	/**
	 * action create
	 *
	 * @param \Evorion\Evchat\Domain\Model\Visitor $newVisitor
	 * @return void
	 */
	public function createAction(\Evorion\Evchat\Domain\Model\Visitor $newVisitor) {
		$this->visitorRepository->add($newVisitor);
		$this->flashMessageContainer->add('Your new Visitor was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Evorion\Evchat\Domain\Model\Visitor $visitor
	 * @return void
	 */
	public function editAction(\Evorion\Evchat\Domain\Model\Visitor $visitor) {
		$this->view->assign('visitor', $visitor);
	}

	/**
	 * action update
	 *
	 * @param \Evorion\Evchat\Domain\Model\Visitor $visitor
	 * @return void
	 */
	public function updateAction(\Evorion\Evchat\Domain\Model\Visitor $visitor) {
		$this->visitorRepository->update($visitor);
		$this->flashMessageContainer->add('Your Visitor was updated.');
		$this->redirect('list');
	}

}
?>