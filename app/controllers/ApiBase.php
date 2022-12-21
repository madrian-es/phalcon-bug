<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

class ApiBase extends Controller
{
    public $_request;  

    
    protected $_log = TRUE;
    
    public function initialize()
    {
        set_time_limit(600); // Only API
       
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        
        $this->__getRequestParameters();
    }
    
    public function returnResponse($error = null, $data = [] ){
        $this->http_code = 200;
        
        if ($error){
            $this->http_code = 400;

            $response =  [
                'success' => false,
                'code'    => $this->http_code,
                'msg'     => $error,
            ];
        } else {
         
            $response =  [ 'success' => true ];
            if(!empty($data))
                $response = array_merge($response, $data);
        }

        $this->response->setStatusCode($this->http_code);
        $this->response->setJsonContent($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)->send();
    }

    private function __getRequestParameters(){
      
        if ($this->request->getJsonRawBody()){
            $request = $this->request->getJsonRawBody();
        } else if ($this->request->isPost()) {
            // Uncomment following line and try again:
            //json_encode(null);
            $request = (object) $this->request->getPost();
        } else {
            $request = (object) $this->request->getPut();
        }

        $this->_request = $request;
    }

}
