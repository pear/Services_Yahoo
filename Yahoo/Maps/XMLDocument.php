<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Services_Yahoo_Maps_XMLDocument class
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
 * Provides facilities for creating and modifying XML for use with the
 * Yahoo! Maps API.
 * 
 * The Yahoo! Maps XML is based on geoRSS 2.0
 *
 * @category   Web Services
 * @package    Services_Yahoo
 * @author     Bryan Dunlap <bdunlap@bryandunlap.com>
 * @copyright  2005 Bryan Dunlap
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 */
class Services_Yahoo_Maps_XMLDocument
{

    /**
     * Location of the GeoRSS 2.0 schema
     *
     * @const
     */
    const URI_GEO   = "http://www.w3.org/2003/01/geo/wgs84_pos#";

    /**
     * Location of the Yahoo! Maps schema
     *
     * @const
     */
    const URI_YMAPS = "http://api.maps.yahoo.com/Maps/V1/AnnotatedMaps.xsd";

    /**
     * DOMDocument instance 
     *
     * @var    object
     * @access private
     */
    private $domDoc;
        
    /**
     * Constructor
     *
     * @param  string  $file  (optional) a string containing the path to a valid
     *                                   XML document
     * @throws Services_Yahoo_Exception
     * @access public
     */
    public function __construct($file = false)
    {
        if ($file) {
            $domDoc = DOMDocument::load($file);
        } else {
            $this->createNew();
        }
    }
    
    /**
     * Adds a group sub-element to the groups element
     *
     * @param  array  $options  an array containing valid attributes for the
     *                          group element
     * @return void
     * @throws Services_Yahoo_Exception
     * @access public
     */
    public function addGroup($options)
    {
        $validOptions = array("id", "title",
                              "ymaps:BaseIcon",
                              "ymaps:HoverIcon",
                              "ymaps:PopupIcon");
        if (!($groups = $this->domDoc->getElementsByTagName("ymaps:Groups")
                                     ->item(0))) {
            $groups   = $this->domDoc->getElementsByTagName("channel")
                                     ->item(0)
                                     ->appendChild($this->domDoc->createElement("ymaps:Groups"));
        }
        $group = $this->domDoc->createElement("group");
        foreach ($options as $name => $value) {
            if (!in_array($name, $validOptions)) {
                throw new Services_Yahoo_Exception("Attribute {$name} not recognized");
            }
            $group->appendChild($this->setElementValue($this->domDoc->createElement($name),
                                                       $value));
        }
        $groups->appendChild($group);
    }
    
    /**
     * Adds an item sub-element to the channel element
     *
     * @param  array  $options  an array containing valid attributes for the
     *                          item element
     * @return void
     * @throws Services_Yahoo_Exception
     * @access public
     */
    public function addItem($options)
    {
        $validOptions = array("title", "link", "description",
                              "ymaps:Address", "ymaps:CityState",
                              "ymaps:Zip", "ymaps:Country",
                              "geo:lat", "geo:long",
                              "ymaps:PhoneNumber", "ymaps:Group",
                              "ymaps:BaseIcon", "ymaps:HoverIcon",
                              "ymaps:PopupIcon", "ymaps:ExtraLink",
                              "ymaps:ExtraImage", "ymaps:ItemUrl");
        $channel = $this->domDoc->getElementsByTagName("channel")
                                ->item(0);
        $item = $this->domDoc->createElement("item");
        foreach ($options as $name => $value) {
            if (!in_array($name, $validOptions)) {
                throw new Services_Yahoo_Exception("Attribute {$name} not recognized");
            }
            if ($name == "ymaps:ExtraLink") {
                foreach ($value as $linkText => $href) {
                    $extraLink = $this->domDoc->createElement("ymaps:ExtraLink", 
                                                              $linkText);
                    $extraLink->setAttribute("href", $href);
                    $item->appendChild($extraLink);
                }
            } elseif ($name == "ymaps:ExtraImage") {
                $extraImage = $this->domDoc->createElement("ymaps:ExtraImage");
                foreach ($value as $elementName => $elementValue) {
                    $extraImage->appendChild($this->setElementValue($this->domDoc->createElement($elementName),
                                                                    $elementValue));
                }
                $item->appendChild($extraImage);
            } else {
                $item->appendChild($this->setElementValue($this->domDoc->createElement($name),
                                                          $value));                
            }
        }
        $channel->appendChild($item);
    }
    
    /**
     * Sets the image sub-element of the channel element
     *
     * @param  string  $imageURL   a string containing a valid URL to an image
     * @return void
     * @access public
     */
    public function setBrandingImage($options)
    {
        $validOptions = array("id", "title",
                              "ymaps:BaseIcon",
                              "ymaps:HoverIcon",
                              "ymaps:PopupIcon");
        $image = $this->setChannelElement("image", $imageUrl);        
        foreach ($options as $name => $value) {
            if (!in_array($name, $validOptions)) {
                throw new Services_Yahoo_Exception("Attribute {$name} not recognized");
            }
        }
    }

    /**
     * Sets the description sub-element of the channel element
     *
     * @param  string $description  a string containing the description
     * @return void
     * @access public
     */
    public function setDescription($description)
    {
        $this->setChannelElement("description", $description);        
    }
    
    /**
     * Sets the "defaultViewNumbered" attribute of the ymaps:Groups element
     *
     * @param  boolean $defaultViewNumbered
     * @return void
     * @access public
     */
    public function setDefaultViewNumbered($defaultViewNumbered = true)
    {
        $this->domDoc->getElementsByTagName("ymaps:Groups")
                     ->item(0)
                     ->setAttribute("defaultViewNumbered", (boolean) $defaultViewNumbered);
    }

    /**
     * Sets the ymaps::IntlCode sub-element of the channel element
     *
     * @param  string $languageCode  a string containing the language code
     * @return void
     * @access public
     */
    public function setLanguageCode($languageCode)
    {
        $this->setChannelElement("ymaps:IntlCode", $languageCode);        
    }

    /**
     * Sets the geo:lat sub-element of the channel element
     *
     * @param  float $latitude  a float representing latitude
     * @return void
     * @access public
     */
    public function setLatitude($latitude)
    {
        $this->setChannelElement("geo:lat", (float) $latitude);        
    }

    /**
     * Sets the geo:long sub-element of the channel element
     *
     * @param  float $longitude  a float representing longitude
     * @return void
     * @access public
     */
    public function setLongitude($longitude)
    {
        $this->setChannelElement("geo:long", (float) $longitude);        
    }

    /**
     * Sets the link sub-element of the channel element
     *
     * @param  string $link  a string containing a valid URL
     * @return void
     * @access public
     */
    public function setLink($link)
    {
        $this->setChannelElement("link", $link);
    }
    
    /**
     * Sets the title sub-element of the channel element
     *
     * @param  string $title  a string containing a title
     * @return void
     * @access public
     */
    public function setTitle($title)
    {
        $this->setChannelElement("title", $title);        
    }
    
    /**
     * Sets the ymaps:ZoomLevel sub-element of the channel element
     *
     * @param  integer $zoomLevel  an integer representing the map"s zoom level
     * @return void
     * @access public
     */
    public function setZoomLevel($zoomLevel)
    {
        $this->setChannelElement("ymaps:ZoomLevel", $zoomLevel);                
    }
    
    /**
     * Exports the DOM representation to XML and saves to file
     *
     * @param  string $file   the string containing the path of the
     *                        file to save to
     * @return boolean        true if successful
     * @throws Services_Yahoo_Exception
     * @access public
     */
    public function toFile($file)
    {
        if (!$this->domDoc->save($file)) {
            throw new Services_Yahoo_Exception("DOM export to XML file {$file} failed");
        }
        return true;
    }

    /**
     * Exports the DOM representation to an XML string
     *
     * @return string
     * @throws Services_Yahoo_Exception
     * @access public
     */
    public function toXML()
    {
        if (!($xmlString = $this->domDoc->saveXML())) {
            throw new Services_Yahoo_Exception("DOM export to XML string failed");
        }
        return $xmlString;
    }

    /**
     * Creates a new Yahoo! Maps XML Document
     *
     * @return void
     * @access private
     */
    private function createNew()
    {
        $domDoc = new DOMDocument("1.0", "UTF-8");
        $rss = $domDoc->appendChild($domDoc->createElement("rss"));
        $rss->setAttribute("version", "2.0");
        $rss->setAttribute("xmlns:geo", self::URI_GEO);
        $rss->setAttribute("xmlns:ymaps", self::URI_YMAPS);
        $channel = $rss->appendChild($domDoc->createElement("channel"));
        $channel->appendChild($domDoc->createElement("link"));
        $channel->appendChild($domDoc->createElement("title"));
        $channel->appendChild($domDoc->createElement("description"));
        $this->domDoc = $domDoc;
    }
    
    /**
     * Sets a channel sub-element
     *
     * @param  string  $name   a string containing the
     *                         sub-element name
     * @param  string  $value  a string containing the
     *                         sub-element value
     * @return object          a DOMElement instance
     * @access private
     */
    private function setChannelElement($name, $value)
    {
        if (!($element = $this->domDoc->getElementsByTagName("channel")
                                      ->item(0)
                                      ->getElementsByTagName($name)
                                      ->item(0))) {
            $element   = $this->domDoc->getElementsByTagName("channel")
                                      ->item(0)
                                      ->appendChild($this->domDoc->createElement($name));
        }
        $element = $this->setElementValue($element, $value);
        return $element;
    }
    
    /**
     * Sets an element's value
     *
     * @param  object  $element a DOMElement instance
     * @param  string  $value   a string containing the
     *                          element value
     * @return object           a DOMElement instance
     * @access private
     */
    private function setElementValue($element, $value)
    {
        $cData = array("link", "url", "href", "image",
                       "ymaps:BaseIcon", "ymaps:HoverIcon",
                       "ymaps:PopupIcon", "ymaps:ExtraLink",
                       "ymaps:ExtraImage", "ymaps:ItemUrl");
        (in_array($element->nodeName, $cData)) ? 
            $element->appendChild($this->domDoc->createCDATASection($value)) :
            $element->nodeValue = $value;

        return $element;
    }
}
