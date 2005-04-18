<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Services_Yahoo Content Analysis Response
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005 Martin Jansen
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
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
 * @copyright  2005 Martin Jansen
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
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
