<?php
namespace admin\logic\Pohoda\Template;

use XMLWriter;

/**
 * Default class for Pohoda DataItems
 *
 * @author Pavel Cihlář <cihlar.pavel84@gmail.com>
 */
class DataItem {
    
    /**
     * data
     *
     * @var array
     */    
    protected $data;
    
    /**
     * XML object
     *
     * @var XMLWriter
     */
    protected $xml;
    
    /**
     * elements
     *
     * @var array
     */    
    protected $elements = [];    
    
    /**
     * Constructor
     *
     * @param array data
     * @param XMLWriter xmlWritter
     */
    public function __construct(array $data, XMLWriter &$xmlWritter) {
        $this->data = $data;
        $this->xml = $xmlWritter;
    }
    
    /**
     * addContent
     */
    public function addContent() {
        $this->addContentByElements();
    }

    /**
     * addContentByElements
     */
    protected function addContentByElements() {
        foreach ( $this->elements as $element ) {
            if ( isset($this->data[$element]) ) {
                $this->xml->writeElement('stk:' . $element, $this->data[$element]);
            }
        }
    }
}