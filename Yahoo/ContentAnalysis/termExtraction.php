<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Term Extraction service class
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

require_once "AbstractContentAnalysis.php";

/**
 * Term Extraction service class
 *
 * This class implements an interface to Yahoo's Term Extraction service 
 * by using the Yahoo API.
 *
 * @category   Services
 * @package    Services_Yahoo
 * @author     Martin Jansen <mj@php.net>
 * @copyright  2005-2006 Martin Jansen
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License, Version 2.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Services_Yahoo
 * @link       http://developer.yahoo.net/content/V1/termExtraction.html
 */
class Services_Yahoo_ContentAnalysis_termExtraction extends Services_Yahoo_ContentAnalysis_AbstractContentAnalysis {

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
