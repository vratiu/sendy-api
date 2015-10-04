<?php
namespace Vratiu\SendyApi\Result;

use GuzzleHttp\Psr7\Response;

class SubscriberCount extends ResultAbstract
{
    const ERROR_NO_DATA_PASSED      = 'No data passed';
    const ERROR_APIKEY_NOT_FOUND    = 'API key not passed';
    const ERROR_INVALID_API_KEY     = 'Invalid API key';
    const ERROR_EMPTY_LIST_ID       = 'List ID not passed';
    const ERROR_INVALID_LIST_ID     = 'List does not exist';
    
    public static $errors = array(
        self::ERROR_NO_DATA_PASSED,
        self::ERROR_APIKEY_NOT_FOUND,
        self::ERROR_EMPTY_LIST_ID,
        self::ERROR_INVALID_LIST_ID,
    );
    
    
    public function __construct(Response $response)
    {
        $responseString = $response->getBody()->__toString();
        if(is_numeric($responseString)){
            $this->isError = false;
            $this->result = intval($responseString);
        }else{
            $this->parseError($responseString);
        }
    }
}
