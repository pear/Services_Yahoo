<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Services_Yahoo Exception handling
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

require_once "PEAR/Exception.php";

/**
 * Services_Yahoo Exception class
 *
 * This class is used in all places in the package where Exceptions
 * are raised.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @extends    PEAR_Exception
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005 Martin Jansen
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 */
class Services_Yahoo_Exception extends PEAR_Exception {

    protected $errors = array();
 
    /**
     * Add error message to the internal error stack
     *
     * @access public
     * @param  string Error message
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * Add multiple error messages to the internal error stack
     *
     * @access  public
     * @param   array Array of error messages
     */
    public function addErrors($errors)
    {
        $this->errors = array_merge($this->errors, $errors);
    }

    /**
     * Determine if the exception contains error messages in the internal stack
     *
     * @access public
     * @return boolean True if the stack contains errors, false otherwise
     */
    public function hasErrors()
    {
        return (count($this->errors) > 0);
    }

    /**
     * Get list of error messages from the internal error stack
     *
     * This method may be used to generate a list of error messages
     * that have been returned from the Yahoo API.
     *
     * @access public
     * @return array List of error messages
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
