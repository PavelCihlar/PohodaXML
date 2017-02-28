<?php
namespace admin\logic\Pohoda\Template\Stock;

use admin\logic\Pohoda\Template\DataItem;
use XMLWriter;

/**
 * Stock Header DataItem
 *
 * @author Pavel Cihlář <cihlar.pavel84@gmail.com>
 */
class Header extends DataItem {

    /**
     * Constructor
     *
     * @param array data
     * @param XMLWriter xmlWritter
     */
    public function __construct(array $data, XMLWriter &$xmlWritter) {
        $this->elements = ['stockType', 'code', 'isInternet', 'isSales', 'isSerialNumber', 'name', 'unit',
            'sellingPrice', 'guaranteeType', 'guarantee', 'note', 'purchasingRateVAT', 'sellingRateVAT'];
        
        parent::__construct($data, $xmlWritter);
    }

    /**
     * addContent
     * 
     * @Override
     */
    public function addContent() {
        $this->xml->startElement('stk:stockHeader');
        
        $this->addContentByElements();        
        
        if (isset($this->data['storage'])) {
            $this->xml->startElement('stk:storage');
            $this->xml->writeElement('typ:ids', $this->data['storage']);
            $this->xml->endElement();
        }
        
        if (isset($this->data['typePrice'])) {
            $this->xml->startElement('stk:typePrice');
            $this->xml->writeElement('typ:ids', $this->data['typePrice']);
            $this->xml->endElement();
        }
        
        $this->xml->endElement();
    }    
}