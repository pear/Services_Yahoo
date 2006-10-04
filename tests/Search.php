<?php
/**
 * Services_Yahoo Search Unit Tests
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
require_once "Services/Yahoo/Search.php";

/**
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
 * @version    CVS: $Id$
 */
class SearchTest extends PHPUnit_Framework_TestCase {

    public function testFactory() {
        $client = Services_Yahoo_Search::factory("image");
        $this->assertType("Services_Yahoo_Search_image", $client);

        $client = Services_Yahoo_Search::factory("local");
        $this->assertType("Services_Yahoo_Search_local", $client);

        $client = Services_Yahoo_Search::factory("news");
        $this->assertType("Services_Yahoo_Search_news", $client);

        $client = Services_Yahoo_Search::factory("video");
        $this->assertType("Services_Yahoo_Search_video", $client);

        $client = Services_Yahoo_Search::factory("web");
        $this->assertType("Services_Yahoo_Search_web", $client);
    }

    public function testWithResults10() {
        $client = Services_Yahoo_Search::factory("web");

        $result = $client->searchFor("Madonna");

        $this->assertEquals(10, $result->getTotalResultsReturned());
    }

    public function testWithResults20() {
        $client = Services_Yahoo_Search::factory("web");

        $result = $client->withResults(20)->searchFor("Madonna");

        $this->assertEquals(20, $result->getTotalResultsReturned());
    }

    public function testStartingAt() {
        $client = Services_Yahoo_Search::factory("web");

        $results = $client->startingAt(87)->searchFor("Madonna");

        $this->assertEquals(87, $results->getFirstResultPosition());
        $this->assertEquals(10, $results->getTotalResultsReturned());
    }

    public function testInFormat() {
        $client = Services_Yahoo_Search::factory("web");

        $results = $client->inFormat("html")->searchFor("Madonna");

        foreach ($results as $result) {
            $this->assertEquals("text/html", $result['MimeType']);
        }
    }

    public function testOnSite() {
        $client = Services_Yahoo_Search::factory("web");

        $results = $client->onSite("pear.php.net")->searchFor("Documentation");

        foreach ($results as $result) {
            $this->assertRegExp("~^http://pear\.php\.net~", $result['Url']);
            $this->assertRegExp("~^pear\.php\.net~", $result['DisplayUrl']);
        }
    }

    public function testOnSites() {
        $client = Services_Yahoo_Search::factory("web");

        $results = $client->onSite("pear.php.net")->onSite("pecl.php.net")->searchFor("PHP");

        foreach ($results as $result) {
            $this->assertThat($result['Url'], $this->logicalOr($this->matchesRegularExpression("~^http://pear\.php\.net~"),
                                                               $this->matchesRegularExpression("~^http://pecl\.php\.net~")));

            $this->assertThat($result['DisplayUrl'], $this->logicalOr($this->matchesRegularExpression("~^pear\.php\.net~"),
                                                                      $this->matchesRegularExpression("~^pecl\.php\.net~")));
        }
    }
}
