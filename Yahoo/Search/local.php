<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Local search class
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

require_once "AbstractSearch.php";

/**
 * Local search class
 *
 * This class implements an interface to Yahoo's Local search by using
 * the Yahoo API.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Services_Yahoo
 * @link       http://developer.yahoo.net/local/V1/localSearch.html
 */
class Services_Yahoo_Search_local extends Services_Yahoo_Search_AbstractSearch {

    protected $requestURL = "http://api.local.yahoo.com/LocalSearchService/V1/localSearch";

    /** 
     * Set how far (in miles) from the specified location to search for the query terms
     *
     * The default radius varies according to the location given.
     *
     * @access public
     * @param  string Radius as a float number
     * @return Services_Yahoo_AbstractSearch Object which contains the method
     */
    public function inRadius($radius)
    {
        $this->parameters['radius'] = $radius;

        return $this;
    }
    
    /** 
     * Set the street name
     *
     * The number is optional.
     *
     * @access public
     * @param  string Name of the street
     * @return Services_Yahoo_AbstractSearch Object which contains the method
     */
    public function inStreet($street)
    {
        $this->parameters['street'] = $street;

        return $this;
    }

    /** 
     * Set the city name
     *
     * @access public
     * @param  string City name
     * @return Services_Yahoo_AbstractSearch Object which contains the method
     */
    public function inCity($city)
    {
        $this->parameters['city'] = $city;

        return $this;
    }

    /** 
     * Set the United States state
     *
     * @access public
     * @param  string State name. You can spell out the full state name or you can use the two-letter abbreviation.
     *
     * @link   http://en.wikipedia.org/wiki/State_codes
     * @access public
     * @param  string State name
     * @return Services_Yahoo_AbstractSearch Object which contains the method
     */
    public function inState($state)
    {
        $this->parameters['state'] = $state;

        return $this;
    }

    /** 
     * Set the ZIP code
     *
     * The parameter can be a five-digit ZIP code, or the five-digit 
     * code plus four-digit extension. If this location contradicts 
     * the city and state specified, the ZIP code will be used for 
     * determining the location and the city and state will be ignored.
     *
     * @access public
     * @param  string ZIP code as described
     * @return Services_Yahoo_AbstractSearch Object which contains the method
     */
    public function withZIP($code)
    {
        $this->parameters['zip'] = $code;

        return $this;
    }

    /** 
     * Set a location description
     *
     * This free field lets users enter any of the following:
     *   - city, state
     *   - city, state, ZIP
     *   - ZIP
     *   - street, city, state
     *   - street, city, state, ZIP
     *   - street, ZIP
     *
     * If location is specified, it will take priority over the 
     * individual fields in determining the location for the query. 
     * City, state and ZIP will be ignored.
     *
     * @access public
     * @param  string Location description
     * @return Services_Yahoo_AbstractSearch Object which contains the method
     */
    public function atLocation($text)
    {
        $this->parameters['location'] = $location;

        return $this;
    }
}
