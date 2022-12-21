<?php

namespace App;

use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;
use Phalcon\Encryption\Security\JWT\Token\Parser;
use Phalcon\Encryption\Security\JWT\Validator;
use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;

class Jwt extends \Phalcon\DI\Injectable{

    private $__passphrase = FALSE;
    private $__params     = [];

    /**
     * 
     */
    public function __construct($signer, $params = []){
        $this->__passphrase = $signer;
        $this->__params     = $params;

        $this->__checkProperties();
    }

    /**
     * 
     */
    public function isValidJWT($jwt){
        $signer     = new Hmac('sha256');
        $parser      = new Parser();

        $tokenObject = $parser->parse($jwt);
        $validator = new Validator($tokenObject);
    
        $valid = $validator
                ->validateExpiration(time())
                ->validateSignature($signer, $this->__passphrase);
               
        if(count($valid->getErrors()) > 0){
            return FALSE;
        }
        
        return $tokenObject->getClaims()->getPayload();
    }

    /**
     * 
     */
    public function addParameter($key, $value){
        $this->__params[$key] = $value;
    }

    /**
     * 
     */
    private function __checkProperties(){
        // Phrase
        if($this->__passphrase == FALSE || empty($this->__passphrase))throw new \Exception("The signer is empty or not allowed");
    }
}
