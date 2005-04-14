<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Term Extraction service class
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
 * Term Extraction service class
 *
 * This class implements an interface to Yahoo's Term Extraction service 
 * by using the Yahoo API.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005 Martin Jansen
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Services_Yahoo
 * @link       http://developer.yahoo.net/content/V1/termExtraction.html
 */
class Services_Yahoo_Search_termExtraction extends Services_Yahoo_Search_AbstractSearch {

    protected $requestURL = "http://api.search.yahoo.com/ContentAnalysisService/V1/termExtraction";

    /**
     * Set the context to extract terms from.
     *
     * Note: One must not encode the context to UTF-8 before passing it 
     * to this method.  The encoding will be done automatically.
     *
     * @access public
     * @param  string Context to extract terms from
     */
    public function setContext($context)
    {
        $this->parameters['context'] = utf8_encode($context);
    }
}
