<?php
/**
 * Services_Yahoo Exception Unit Tests
 *
 * Copyright 2005-2006 Martin Jansen
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Services_Yahoo
 */

require_once "PHPUnit/Framework/TestCase.php";
require_once "Services/Yahoo/Exception.php";

/**
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
 * @version    CVS: $Id$
 */
class Services_Yahoo_Tests_Exception extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->e = new Services_Yahoo_Exception("exception text");
    }

    public function testInheritance() {
        $this->assertType("Exception", $this->e);
        $this->assertType("PEAR_Exception", $this->e);
    }

    public function getErrors() {
        $this->assertEquals($this->e->getErrors(), array());
    }

    public function testAddError1() {
        $this->e->addError("message text");
        $this->assertEquals($this->e->getErrors(), array("message text"));
    }

    public function testAddError2() {
        $this->e->addError("message text 1");
        $this->e->addError("message text 2");
        $this->assertEquals($this->e->getErrors(), array("message text 1", "message text 2"));
    }

    public function testAddErrors() {
        $this->e->addErrors(array("message text 1", "message text 2"));
        $this->assertEquals($this->e->getErrors(), array("message text 1", "message text 2"));
    }

    public function testHasErrors1() {
        $this->assertFalse($this->e->hasErrors());
    }

    public function testHasErrors2() {
        $this->e->addError("message text");
        $this->assertTrue($this->e->hasErrors());
    }

    public function testHasErrors3() {
        $this->e->addErrors(array("message text 1", "message text 2"));
        $this->assertTrue($this->e->hasErrors());
    }
}
