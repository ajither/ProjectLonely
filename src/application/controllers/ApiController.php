<?php

/**
 * @author     Ajith E R, <ajithurulikunnam@gmail.com>
 * @date       September 11, 2017
 * @brief      This class controlls all api calls.
 * @details    API calls are directed towards a method with the same name as the
 *             API
 */

class ApiController {
    
    public function testApi($request) {
        $payload = $request->getParsedBody();
        echo 'Hello World!';
    }
}
