<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Services_Yahoo Exception handling
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
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
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
