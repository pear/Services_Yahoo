<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Content analysis dispatcher
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

require_once "Services/Yahoo/Exception.php";

/**
 * Content analysis class
 *
 * This class provides a method to create a concrete instance of one
 * of the supported content analysis services.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005 Martin Jansen
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 */
class Services_Yahoo_ContentAnalysis {

    /**
     * Attempts to return a concrete instance of a content analysis class
     *
     * @access  public
     * @param   string Type of content analysis. Can be one of spellingSuggestion or termExtraction
     * @return  object Concrete instance of a content analysis class based on the paramter
     * @throws  Services_Yahoo_Exception
     */
    public function factory($type)
    {
        switch ($type) {

        case "termExtraction" :
        case "spellingSuggestion" :
            require_once "Services/Yahoo/ContentAnalysis/" . $type . ".php";
            $classname = "Services_Yahoo_ContentAnalysis_" . $type;
            return new $classname;

        default :
            throw new Services_Yahoo_Exception("Unknown content analysis type {$type}");
            break;
        }
    }
}
