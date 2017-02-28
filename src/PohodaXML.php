<?php
namespace admin\logic\Pohoda;

use XMLWriter;

/**
 * Default class for PohodaXMLs
 *
 * @author Pavel Cihlář <cihlar.pavel84@gmail.com>
 */
abstract class PohodaXML {

    const APPLICATION = 'cdb';
    const VERSION = '2.0';
    
    /**
     * filename
     *
     * @var string
     */    
    protected $filename;       
    
    /**
     * ico
     *
     * @var string
     */    
    protected $ico;    
    
    /**
     * name
     *
     * @var string
     */    
    protected $name;
    
    /**
     * data
     *
     * @var array
     */    
    protected $data;
    
    /**
     * options
     *
     * @var array
     */    
    protected $options;        
    
    /**
     * XML object
     *
     * @var XMLWriter
     */
    protected $xml;
    
    /**
     * onAfterRender
     *
     * @var array
     */
    protected $onAfterRender = [];        
    
    /**
     * constructor
     */
    public function __construct() {
        $this->xml = $this->initXML();
        
        $this->addRootElement();
    }
    
    /**
     * addRootElement
     */    
    public function addRootElement() {
        $this->xml->startElement('dat:dataPack');
        foreach ( $this->getRootElementAtributes() as $key => $value ) {
            $this->xml->writeAttribute('xmlns:' . $key, $value);
        }
        $this->xml->writeAttribute('id', $this->filename);
        $this->xml->writeAttribute('ico', $this->ico);
        $this->xml->writeAttribute('version', self::VERSION);
        $this->xml->writeAttribute('note', $this->name);
        $this->xml->writeAttribute('application', self::APPLICATION);
        $this->addContent();        
        $this->xml->endElement();
    }    
    
    /**
     * initXML
     *
     * @return XMLWriter
     */
    private function initXML() {
        if (!extension_loaded('libxml'))
            throw new PohodaXMLException('libXML has to be enabled');
        
        $xmlWriter = new XMLWriter();
        $xmlWriter->openURI('php://output');  
        $xmlWriter->startDocument('1.0','UTF-8');  
        $xmlWriter->setIndent(4);
        
        return $xmlWriter;
    }    
    
    /**
     * addContent
     */      
    protected abstract function addContent();
    
    /**
     * getRootElementAttribute
     * 
     * @return array
     */      
    protected abstract function getRootElementAtributes();    
    
    /**
     * closeXML
     */        
    private function closeXML() {
        $this->xml->endDocument();   
        $this->xml->flush();
    }
    
    /**
     * addOnAfterRender
     * 
     * @param callable onAfterRender
     */        
    public function addOnAfterRender(callable $onAfterRender) {
        $this->onAfterRender[] = $onAfterRender;
    }    
    
    /**
     * addOnAfterRender
     * 
     * @param callable onAfterRender
     */       
    public function onAfterRender() {
        foreach ($this->onAfterRender as $afterRender) {
            $afterRender($this->name);
        }        
    }    
    
    /**
     * addDataItem
     * 
     * @param IDataItem className
     */
    public function addDataItem($className, $data) {
        $className = __NAMESPACE__ . '\\Template\\' . $className;
        $dataItem = new $className($data, $this->xml);
        $dataItem->addContent();
    }    
    
    /**
     * renderOuput
     */        
    public function renderOuput() {
        $this->closeXML();
        $this->onAfterRender();
    }
    
    /**
     * setFilename
     * 
     * @param string Filename
     */       
    protected function setFilename($fileName) {
        $this->filename = $fileName . '-' . time() . '.xml';
    }
    
    /**
     * getFilename
     * 
     * @return string Filename
     */        
    public function getFilename() {
        return $this->filename;
    }    
}