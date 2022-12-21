<?php
namespace App\Controllers\Api;

use \App\Jwt;

use Phalcon\Http\Request;

class TokenController extends \App\Controllers\ApiBase
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 
     */
    public function parseTokenAction()
    {       
        $request = null;
        $request = $this->_request;

        //Get the token from the request    
        $token        = isset($request->token) ? $request->token : NULL;
        $tokenParser  = NULL;
        if ($token != NULL){
            $ljwt        = new Jwt($this->config->jwt->signer);
            $tokenParser = $ljwt->isValidJWT($token);
            $tokenParser = $tokenParser === FALSE ? FALSE : (object)$tokenParser;
        }
      
        if (is_object($tokenParser)) {
            echo "It worked";
        } else {
            echo "Token is invalid, try with a valid one";
        }
    }
}
