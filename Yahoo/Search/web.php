<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Web search class
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
 * Web search class
 *
 * This class implements an interface to Yahoo's web search by using
 * the Yahoo API.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005 Martin Jansen
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Services_Yahoo
 * @link       http://developer.yahoo.net/web/V1/webSearch.html
 */
class Services_Yahoo_Search_web extends Services_Yahoo_Search_AbstractSearch {

    protected $requestURL = "http://api.search.yahoo.com/WebSearchService/V1/webSearch";

    /**
     * Set to allow multiple results with similar content
     *
     * @access public
     */
    public function setSimilarOK()
    {
        $this->parameters['similar_ok'] = 1;
    }

    /**
     * Set the language the results are written in
     *
     * A list of supported languages can be found on
     * http://developer.yahoo.net/documentation/languages.html.
     *
     * @link   http://developer.yahoo.net/documentation/languages.html
     * @access public
     * @param  string Language code
     */
    public function setLanguage($language)
    {
        $this->parameters['language'] = $language;
    }

    /**
     * Sets the domains to restrict the search to
     *
     * @access public
     * @param  array Array of domains
     */    
    public function setSites($sites) {
        $this->parameters['sites'] = $sites;
    }

    /**
     * Returns the domains to restrict the search to
     *
     * @access public
     * @return array Array of domains
     */
    public function getSites() {
        return $this->getParameter("site");
    }

    /**
     * Sets the subscriptions to premium contents that should also be searched
     *
     * @access public
     * @param  array Array of subscription codes
     */    
    public function setSubscriptions($subscriptions) {
        $this->parameters['subscription'] = $sites;
    }

    /**
     * Returns the subscriptions to premium contents that should also be searched
     *
     * @access public
     * @return array Array of subscription codes
     */
    public function getSubscriptions() {
        return $this->getParameter("subscription");
    }

    /**
     * Sets the Creative Commons licenses that the contents must be licensed under
     *
     * @access public
     * @param  array Array of license codes
     */
    public function setLicenses($licenses) {
        $this->parameters['license'] = $licenses;
    }

    /**
     * Returns the Creative Commons licenses that the contents must be licensed under
     *
     * @access public
     * @return array Array of license codes
     */
    public function getLicenses() {
        return $this->getParameter("license");
    }
}
