<?php
namespace Evorion\Evchat\Domain\Service;

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
 * @package evchat
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class DBTrackerService implements \TYPO3\CMS\Core\SingletonInterface {

    /**
    * Gets the database tracker for the current conversation.
    *
    * @return   mixed
    */
    public function haveNew($UITrackers) {

		if (!is_array($UITrackers)) return FALSE;

    	/* Semaphore acquire BEGIN ***********************************************************************************/
		$semKey = ftok(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('evchat', 'ext_localconf.php'), 'T');
		$semID  = sem_get($semKey, 1);
		if ($semID === FALSE) throw Exception('Failed to get a semaphore!');

		if (!sem_acquire($semID)) throw Exception('Failed to acquire a semaphore!');
		/* Semaphore acquire END *************************************************************************************/

		$shmKey = ftok(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('evchat', 'ext_tables.php'), 'T');
		$shmID = shm_attach($shmKey, 10000);
		$DBTrackers = shm_get_var($shmID, 1);
		if (!is_array($DBTrackers)) $DBTrackers = array();

		$updates = array();
		foreach ($UITrackers as $path => $tracker)
			if (isset($DBTrackers[$path]) && $DBTrackers[$path] > $tracker) $updates[$path] = $tracker;

		/* Semaphore release BEGIN ***********************************************************************************/
		if (!sem_release($semID)) throw Exception('Failed to release a semaphore!');
		/* Semaphore release END *************************************************************************************/

		return count($updates) ? $updates : FALSE;
    }

    /**
     * Update DB trackers.
     *
     * @return   mixed
     */
    public function set($path, $tracker) {

    	/* Semaphore acquire BEGIN ***********************************************************************************/
    	$semKey = ftok(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('evchat', 'ext_localconf.php'), 'T');
		$semID  = sem_get($semKey, 1);
		if ($semID === FALSE) throw Exception('Failed to get a semaphore!');

		if (!sem_acquire($semID)) throw Exception('Failed to acquire a semaphore!');
		/* Semaphore acquire END *************************************************************************************/

		$shmKey = ftok(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('evchat', 'ext_tables.php'), 'T');
		$shmID = shm_attach($shmKey, 10000);
		$DBTrackers = shm_get_var($shmID, 1);

		if (!is_array($DBTrackers)) $DBTrackers = array();
		$DBTrackers[$path] = $tracker;

		if (!shm_put_var($shmID, 1, $DBTrackers)) throw Exception('Failed to save tracker to shared memory!');

		/* Semaphore release BEGIN ***********************************************************************************/
		if (!sem_release($semID)) throw Exception('Failed to release a semaphore!');
		/* Semaphore release END *************************************************************************************/

    }

}
?>