<?php
namespace admin\logic\Pohoda;

use Exception;

/**
 * PohodaException
 *
 * @author Pavel Cihlář <cihlar.pavel84@gmail.com>
 */
class PohodaXMLException extends Exception {
    
    /**
     * Constructor
     *
     * @param string message
     * @param string code
     */    
    public function __construct($message = null, $code = 0) {
        parent::__construct('PohodaXML Exception: ' . $message, $code);
    }
}