<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Services_Yahoo Search Response
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
 * Services_Yahoo Search Response class
 *
 * This class provides methods for accessing the response of a search
 * request.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @extends    Exception
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
 * @version    CVS: $Id$
 */
class Services_Yahoo_Search_Response implements Iterator {

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
            $exception = new Services_Yahoo_Exception("Search query failed");
            $exception->addErrors($this->getMessages());

            throw $exception;
        }
    }

    // {{{ response handling

    /**
     * Get number of query matches in the database
     *
     * This method returns the overall number of matches in the
     * database.
     *
     * @access public
     * @return integer Number of query matches
     */
    public function getTotal()
    {
        return (int)$this->returnAttribute("totalResultsAvailable");
    }

    /**
     * Get the position of the first result in the overall search
     *
     * @access public
     * @return integer Position of the first result in the overall search
     */
    public function getFirstResultPosition()
    {
        return (int)$this->returnAttribute("firstResultPosition");
    }

    /**
     * Get number of query matches returned from the search
     *
     * This may be lower than the number of results requested if 
     * there were fewer total results available.
     *
     * @access public
     * @return integer Number of query matches returned
     */
    public function getTotalResultsReturned()
    {
        return (int)$this->returnAttribute("totalResultsReturned");
    }

    /**
     * Get the URL of a webpage containing a map graphic with all returned results plotted on it
     *
     * This URL is not part of all search responses, but it is used
     * often enough to be part of the general response class.
     *
     * @access public
     * @return string Map URL
     */
    public function getResultSetMapUrl()
    {
        if (isset($this->result['ResultSetMapUrl'])) {
            return $this->result['ResultSetMapUrl'];
        }

        return "";
    }

    /**
     * Determine if there are more matches than the ones that have been returned
     *
     * This method may be used as the criteria for displaying 
     * "Next" links or similar.
     *
     * @access public
     * @return boolean True if more results are available, false otherwise.
     */
    public function hasMore()
    {
        $firstResult = $this->getFirstResultPosition();
        $lastResult = $firstResult + $this->getTotalResultsReturned() - 1;

        return ($this->lastResult < $this->getTotal());
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
        return (array)$this->result['Result'][$this->iteratorCounter];
    }

    public function next()
    {
        $this->iteratorCounter++;
        if (!isset($this->result['Result'][$this->iteratorCounter])) {
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
     * Parse result set from the response
     *
     * @access private
     * @throws Services_Yahoo_Exception
     */
    private function parseRequest()
    {
        $tmp = unserialize($this->request->getResponseBody());
        
        if ($tmp === false || !is_array($tmp) || !isset($tmp['ResultSet'])) {
            throw new Services_Yahoo_Exception("The response did not contain a serialized array of search results");
        }
        
        $this->result = $tmp['ResultSet'];
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
        foreach ($this->result['Message'] as $message) {
            $returnValue[] = $message;
        }
        return $returnValue;
    }

    /**
     * Attempts to get the value of a specific attribute of the top level tag
     *
     * @access private
     * @param  string Name of the attribute
     * @return mixed  A string containing the attribute value if the 
     *                attribute exists. NULL otherwise.
     */
    private function returnAttribute($name)
    {
        if (isset($this->result[$name])) {
            return $this->result[$name];
        }

        return null;
    }

    // }}}
}
