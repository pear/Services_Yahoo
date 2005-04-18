<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Abstract search class
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

require_once "Services/Yahoo/ContentAnalysis/Response.php";
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
 * @copyright  2005 Martin Jansen
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Services_Yahoo
 */
abstract class Services_Yahoo_ContentAnalysis_AbstractContentAnalysis {

    protected $parameters = array("appid" => "PEAR_Services_Yahoo");

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
        $request = new HTTP_Request($this->requestURL);

        foreach ($this->parameters as $key => $value) {
            $request->addQueryString($key, $value);
        }

        $result = $request->sendRequest();
        if (PEAR::isError($result)) {
            throw new Services_Yahoo_Exception($result->getMessage());
        }

        return new Services_Yahoo_ContentAnalysis_Response($request);
    }

    /**
     * Set Application ID for the content analysis
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
     * Set the query for the content analysis
     *
     * @access public
     * @param  string Query for the content analysis
     */
    public function setQuery($query)
    {
        $this->parameters['query'] = $query;
    }
}
