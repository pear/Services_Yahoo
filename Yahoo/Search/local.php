<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Local search class
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
 * @copyright  2005 Martin Jansen
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
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
     */
    public function setRadius($radius)
    {
        $this->parameters['radius'] = $radius;
    }
    
    /** 
     * Set the street name
     *
     * The number is optional.
     *
     * @access public
     * @param  string Name of the street
     */
    public function setStreet($street)
    {
        $this->parameters['street'] = $street;
    }

    /** 
     * Set the city name
     *
     * @access public
     * @param  string City name
     */
    public function setCity($city)
    {
        $this->parameters['city'] = $city;
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
     */
    public function setState($state)
    {
        $this->parameters['state'] = $state;
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
     */
    public function setZIP($code)
    {
        $this->parameters['zip'] = $code;
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
     */
    public function setLocation($text)
    {
        $this->parameters['location'] = $location;
    }
}
