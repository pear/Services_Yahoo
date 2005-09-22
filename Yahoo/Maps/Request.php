<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Contains the Services_Yahoo_Maps_Request class
 * 
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 * 
 * @category   Web Services
 * @package    Services_Yahoo
 * @author     Bryan Dunlap <bdunlap@bryandunlap.com>
 * @copyright  2005 Bryan Dunlap
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 */

require_once "Services/Yahoo/Exception.php";

/**
 * Provides the ability to construct a valid Yahoo! Maps API request URL
 *
 * @category   Web Services
 * @package    Services_Yahoo
 * @author     Bryan Dunlap <bdunlap@bryandunlap.com>
 * @copyright  2005 Bryan Dunlap
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 */
class Services_Yahoo_Maps_Request
{
    
    /**
     * Location of the Yahoo! Maps REST service
     *
     * @const
     */
    const REQUEST_URL   = "http://api.maps.yahoo.com/Maps/V1/annotatedMaps";

    /**
     * Valid parameters to be passed 
     *
     * @var    string
     * @access private
     */
    private $parameters = array("appid"  => "PEAR_Services_Yahoo",
                                "xmlsrc" => "");
    
    /**
     * Constructor
     *
     * @param  string $appID   (optional) the string containing the
     *                                    Application ID
     * @param  string $xmlSrc  (optional) the string containing either valid XML
     *                                    or a URL to a valid XML document
     * @access public
     */
    public function __construct($id = null, $xmlSrc = null)
    {
        if (!is_null($appID)) {
            $this->setAppID($id);
        }
        if (!is_null($xmlSrc)) {
            $this->setXMLSrc($xmlSrc);
        }
    }
    
    /**
     * Builds a valid Yahoo! Maps REST request URL
     *
     * @return string
     * @throws Services_Yahoo_Exception
     * @access public
     */
    public function build($urlencode = true)
    {
        if (!$parameters["xmlsrc"]) {
            throw new Services_Yahoo_Exception("Parameter xmlsrc must be defined");
        }
        $url = self::REQUEST_URL . "?appid=" . 
               $this->parameters["appid"] . 
               "&xmlsrc=" . $this->parameters["xmlsrc"];
        return ($urlencode) ? urlencode($url) : $url;
    }
    
    /**
     * Sets the Yahoo! Application ID to use for this request
     *
     * @return void
     * @access public
     */
    public function setAppID($id)
    {
        $this->parameters["appid"] = $id;
    }
    
    /**
     * Sets the XML for this request
     *
     * @return void
     * @access public
     */
    public function setXMLSrc($xmlSrc)
    {
        $this->parameters["xmlsrc"] = $xmlSrc;
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
