<?php

namespace Evorion\Evchat\Tests\Unit\Domain\Model;

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
 * Test case for class \Evorion\Evchat\Domain\Model\Message.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Vlatko Šurlan <vlatko.surlan@evorion.hr>
 */
class MessageTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Evorion\Evchat\Domain\Model\Message
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Evorion\Evchat\Domain\Model\Message();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getBodyReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getBody()
		);
	}

	/**
	 * @test
	 */
	public function setBodyForStringSetsBody() {
		$this->subject->setBody('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'body',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTimeReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getTime()
		);
	}

	/**
	 * @test
	 */
	public function setTimeForDateTimeSetsTime() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setTime($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'time',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getConversationReturnsInitialValueForConversation() {
		$this->assertEquals(
			NULL,
			$this->subject->getConversation()
		);
	}

	/**
	 * @test
	 */
	public function setConversationForConversationSetsConversation() {
		$conversationFixture = new \Evorion\Evchat\Domain\Model\Conversation();
		$this->subject->setConversation($conversationFixture);

		$this->assertAttributeEquals(
			$conversationFixture,
			'conversation',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getVisitorReturnsInitialValueForVisitor() {
		$this->assertEquals(
			NULL,
			$this->subject->getVisitor()
		);
	}

	/**
	 * @test
	 */
	public function setVisitorForVisitorSetsVisitor() {
		$visitorFixture = new \Evorion\Evchat\Domain\Model\Visitor();
		$this->subject->setVisitor($visitorFixture);

		$this->assertAttributeEquals(
			$visitorFixture,
			'visitor',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAdministratorReturnsInitialValueForAdministrator() {
		$this->assertEquals(
			NULL,
			$this->subject->getAdministrator()
		);
	}

	/**
	 * @test
	 */
	public function setAdministratorForAdministratorSetsAdministrator() {
		$administratorFixture = new \Evorion\Evchat\Domain\Model\Administrator();
		$this->subject->setAdministrator($administratorFixture);

		$this->assertAttributeEquals(
			$administratorFixture,
			'administrator',
			$this->subject
		);
	}
}
