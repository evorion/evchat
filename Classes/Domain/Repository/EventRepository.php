<?php
namespace Evorion\Evchat\Domain\Repository;

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
 * The repository for Events
 */
class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * DBTracker service
	 *
	 * @var \Evorion\Evchat\Domain\Service\DBTrackerService
	 * @inject
	 */
	protected $dbTracker = NULL;

	/**
	 * Adds an object to this repository
	 *
	 * @param object $object The object to add
	 * @throws Exception\IllegalObjectTypeException
	 * @api
	 * @return void
	 */
	public function add($object) {
		parent::add($object);
		// We need to persist here so we can get the database ID of the new Event
		$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
		$persistenceManager->persistAll();
		$this->dbTracker->set($object->getObject(), $object->getUid());
	}

	/**
	 * @param $trackers
	 */
	public function findByTracker($trackers) {
		$query = $this->createQuery();
		foreach ($trackers as $path => $tracker) {
			$query->matching(
				$query->logicalAnd(
					$query->equals('object', $path),
					$query->greaterThan('uid', $tracker)
				)
			);
		}
		return $query->execute();
	}

}