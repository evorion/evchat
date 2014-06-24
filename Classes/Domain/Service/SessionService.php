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
 *
 * @package evchat
* @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
*
*/
class SessionService implements \TYPO3\CMS\Core\SingletonInterface {

    private $prefixKey = 'tx_evchat_';

    /**
    * Returns the object stored in the user´s PHP session
    * @return Object the stored object
    */
    public function get($key) {
        return unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', $this->prefixKey . $key));
    }

    /**
    * Writes an object into the PHP session
    * @param    $object any serializable object to store into the session
    * @return   Evorion\Evchat\Domain\Service\SessionService this
    */
    public function set($key, $object) {
        $sessionData = serialize($object);
        $GLOBALS['TSFE']->fe_user->setKey('ses', $this->prefixKey . $key, $sessionData);
        $GLOBALS['TSFE']->fe_user->storeSessionData();
        return $this;
    }

    /**
    * Cleans up the session: removes the stored object from the PHP session
    * @return   Evorion\Evchat\Domain\Service\SessionService this
    */
    public function delete($key) {
        $GLOBALS['TSFE']->fe_user->setKey('ses', $this->prefixKey . $key, NULL);
        $GLOBALS['TSFE']->fe_user->storeSessionData();
        return $this;
    }

    public function setPrefixKey($prefixKey) {
    	$this->prefixKey = $prefixKey;
    }

}
?>