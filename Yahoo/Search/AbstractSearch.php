<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Abstract search class
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

require_once "Services/Yahoo/Search/Response.php";
require_once "HTTP/Request.php";

/**
 * Abstract search class
 *
 * This abstract class serves as the base class for all different
 * types of searches that available through Services_Yahoo.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Services_Yahoo
 */
abstract class Services_Yahoo_Search_AbstractSearch {

    protected $parameters = array("appid" => "PEAR_Services_Yahoo", "output" => "php"); 

    /**
     * Submits the search
     *
     * This method submits the search and handles the response.  It
     * returns an instance of Services_Yahoo_Result which may be used
     * to further make use of the result.
     *
     * @access public
     * @return object Services_Yahoo_Response Search result
     * @throws Services_Yahoo_Exception
     */
    public function submit()
    {
        $url = $this->requestURL . "?";

        foreach ($this->parameters as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $value2) {
                    $url .= $key . "=" . urlencode($value2) . "&";
                }
                continue;
            }

            $url .= $key . "=" . urlencode($value) . "&";
        }

        $request = new HTTP_Request($url);

        $result = $request->sendRequest();
        if (PEAR::isError($result)) {
            throw new Services_Yahoo_Exception($result->getMessage());
        }

        return new Services_Yahoo_Search_Response($request);
    }

    /**
     * Set Application ID for the search
     *
     * An Application ID is a string that uniquely identifies your 
     * application. Think of it as like a User-Agent string. If you 
     * have multiple applications, you should use a different ID for 
     * each one. You can register your ID and make sure nobody is 
     * already using your ID on Yahoo's Application ID registration 
     * page.
     *
     * The ID defaults to "PEAR_Services_Yahoo", but you are free to
     * change it to whatever you want.  Please note that the access
     * to the Yahoo API is not limited via the Application ID but via
     * the IP address of the host where the package is used.
     *
     * @link   http://api.search.yahoo.com/webservices/register_application
     * @link   http://developer.yahoo.net/documentation/rate.html
     * @access public
     * @param  string Application ID
     * @return void
     */
    public function setAppID($id)
    {
        $this->parameters['appid'] = $id;
    }

    /**
     * Set the query to search for
     *
     * @access public
     * @param  string Query to search for
     */
    public function setQuery($query)
    {
        $this->parameters['query'] = $query;
    }

    /**
     * Set the kind of search to submit
     *
     * The allowed values of the parameter depend on the search
     * type. If unsure, please consult Yahoo's documentation at
     * http://developer.yahoo.net/.
     *
     * Even if not all searches support this parameter, it is common
     * enough to be part of the abstract base class.
     *
     * @access public
     * @param  string Kind of search
     */
    public function setType($type)
    {
        $this->parameters['type'] = $type;
    }

    /**
     * Set the number of results to return.
     *
     * Even if not all searches support this parameter, it is common
     * enough to be part of the abstract base class.
     *
     * @access public
     * @param  int Number of results
     */
    public function setResultNumber($count)
    {
        $count = (int)$count;
        if ($count > 50 || $count < 0) {
            $count = 10;
        }
        $this->parameters['results'] = $count;
    }

    /**
     * Set the starting result position to return (1-based)
     *
     * Even if not all searches support this parameter, it is common
     * enough to be part of the abstract base class.
     * 
     * @access public
     * @param  int Starting position
     */
    public function setStart($start)
    {
        $this->parameters['start'] = $start;
    }

    /**
     * Set the format to search for
     *
     * The allowed values of the parameter depend on the search
     * type. If unsure, please consult Yahoo's documentation at
     * http://developer.yahoo.net/.
     *
     * Even if not all searches support this parameter, it is common
     * enough to be part of the abstract base class.
     *
     * @access public
     * @param  string Format of search
     */
    public function setFormat($format)
    {
        $this->parameters['format'] = $format;
    }

    /**
     * Set that the results will include adult content
     *
     * Even if not all searches support this parameter, it is common
     * enough to be part of the abstract base class.
     *
     * @access public
     */
    public function setAdultOK()
    {
        $this->parameters['adult_ok'] = 1;
    }

    /**
     * Returns an element from the parameters
     *
     * @access protected
     * @param  string $name Name of the element
     * @return string Value of the parameter idenfied by $name
     */
    protected function getParameter($name) {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }

        return "";
    }
}
