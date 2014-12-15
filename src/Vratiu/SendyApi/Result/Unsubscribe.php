<?php
namespace Vratiu\SendyApi\Result;

use GuzzleHttp\Message\ResponseInterface;

class Unsubscribe extends ResultAbstract
{
    const ERROR_FIELDS_MISSING      = 'Some fields are missing.';
    const ERROR_INVALID_EMAIL       = 'Invalid email address.';

    
    public static $errors = array(
        self::ERROR_FIELDS_MISSING,
        self::ERROR_INVALID_EMAIL
    );
    
    public function __construct(ResponseInterface $response)
    {
        $responseString = $response->getBody()->__toString();
        if($responseString === 'true' || $responseString == '1'){
            $this->isError = false;
            $this->result = true;
        }else{
            $this->parseError($responseString);
        }
    }
}
