<?php
namespace admin\logic\Pohoda\Template;

use admin\logic\Pohoda\PohodaXML;
use admin\logic\Pohoda\PohodaXMLException;

/**
 * Stock Template
 *
 * @author Pavel Cihlář <cihlar.pavel84@gmail.com>
 */
class Stock extends PohodaXML {

    const NAME = 'Import skladové zásoby';
    
    /**
     * Constructor
     *
     * @param string ico
     * @param array data
     * @param array options
     */
    public function __construct($ico, $data, $options) {
        $this->name = self::NAME;
        $this->ico = $ico;
        $this->data = $data;
        $this->options = $options;
        $this->setFilename('stock');
        
        parent::__construct();
    }
    
    /**
     * addContent
     */       
    public function addContent() {
        foreach ( $this->data as $data ) {
            if (!isset($data['code']))
                throw new PohodaXMLException('Skladová položka musí mit vyplněnou hodnotu "code"');            
            
            $this->xml->startElement('dat:dataPackItem');
            $this->xml->writeAttribute('id', $data['code']);
            $this->xml->writeAttribute('version', self::VERSION);
            $this->xml->startElement('stk:stock');
            $this->xml->writeAttribute('version', self::VERSION);
            
            $this->addDataItem('Stock\Header', $data);

            $this->xml->endElement();
            $this->xml->endElement();
        }
    }    
    
    /**
     * getRootElementAtributes
     * 
     * @return array
     */       
    public function getRootElementAtributes() {
        return [
            'dat' => 'http://www.stormware.cz/schema/version_2/data.xsd',
            'stk' => 'http://www.stormware.cz/schema/version_2/stock.xsd',
            'typ' => 'http://www.stormware.cz/schema/version_2/type.xsd',
            'ftr' => 'http://www.stormware.cz/schema/version_2/filter.xsd',
        ];
    }
}