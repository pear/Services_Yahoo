<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Services_Yahoo Content Analysis Response
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

/**
 * Services_Yahoo Content Analysis Response class
 *
 * This class provides methods for accessing the response of a content
 * analysis request.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @extends    Exception
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
 * @version    CVS: $Id$
 */
class Services_Yahoo_ContentAnalysis_Response implements Iterator {

    private $isValidIterator = true;
    private $iteratorCounter = 0;

    private $request;
    private $results = array();

    /**
     * Constructor
     *
     * @param  object HTTP_Request Instance of HTTP_Request that was used for the request
     * @throws Services_Yahoo_Exception
     */
    public function __construct(HTTP_Request $request)
    {
        $this->request = $request;

        $this->parseRequest();
        
        if ($this->isError() == true) {
            $exception = new Services_Yahoo_Exception("Content analysis failed");
            $exception->addErrors($this->getMessages());

            throw $exception;
        }
    }

    // {{{ response handling

    /**
     * Get number of result sets returned by the content analysis
     *
     * @access public
     * @return integer Number of result sets returned
     */
    public function getTotalResultsReturned()
    {
        return count((array)$this->xml->Result);
    }

    /**
     * Get the HTTP_Request instance that was used for the query
     *
     * Access to the HTTP_Request instance is useful for introspecting
     * into the request details.  (E.g. for getting the HTTP response
     * code.)
     *
     * @access public
     * @return object HTTP_Request Instance of HTTP_Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    // }}}
    // {{{ Iterator implementation

    public function current()
    {
        return (string)$this->xml->Result[$this->iteratorCounter];
    }

    public function next()
    {
        $this->iteratorCounter++;
        if (!isset($this->xml->Result[$this->iteratorCounter])) {
            $this->isValidIterator = false;
        }
    }

    public function key()
    {
        return $this->iteratorCounter;
    }

    public function rewind()
    {
        $this->iteratorCounter = 0;
    }

    public function valid()
    {
        return $this->isValidIterator;
    }

    // }}}
    // {{{ private methods

    /**
     * Parse XML from the response
     *
     * @access private
     * @throws Services_Yahoo_Exception
     */
    private function parseRequest()
    {
        $this->xml = simplexml_load_string($this->request->getResponseBody());

        if ($this->xml === false) {
            throw new Services_Yahoo_Exception("The response contained no valid XML");
        }
    }

    /**
     * Determine if an error was returned by the Yahoo API
     *
     * This method evaluates the HTTP response code. If it indicates
     * an error, the method returns true.
     *
     * @access private
     * @return boolean  True on error, otherwise false.
     */
    private function isError()
    {
        return in_array($this->request->getResponseCode(), array(400, 403, 404, 503));
    }

    /**
     * Get all error messages if the response contained an error
     *
     * Returns all errors in an numerically indexed array that were 
     * part of the response.
     *
     * @access private
     * @see    isError()
     * @return array
     */
    private function getMessages()
    {
        $returnValue = array();
        foreach ($this->xml->Message as $message) {
            $returnValue[] = $message;
        }
        return $returnValue;
    }

    // }}}
}
