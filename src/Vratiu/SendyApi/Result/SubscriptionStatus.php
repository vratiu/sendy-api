<?php
namespace Vratiu\SendyApi\Result;

use GuzzleHttp\Message\ResponseInterface;

class SubscriptionStatus extends ResultAbstract
{
    const ERROR_NO_DATA_PASSED      = 'No data passed';
    const ERROR_APIKEY_NOT_FOUND    = 'API key not passed';
    const ERROR_INVALID_API_KEY     = 'Invalid API key';
    const ERROR_EMPTY_LIST_ID       = 'List ID not passed';
    const ERROR_INVALID_LIST_ID     = 'List does not exist';
    const ERROR_EMAIL_NOT_FOUND     = 'Email does not exist in list';
    
    const RESULT_SUBSCRIBED         = 'Subscribed';
    const RESULT_UNSUBSCRIBED       = 'Unsubscribed';
    const RESULT_UNCONFIRMED        = 'Unconfirmed';
    const RESULT_BOUNCED            = 'Bounced';
    const RESULT_SOFT_BOUNCED       = 'Soft bounced';
    const RESULT_SOFT_COMPLAINED    = 'Complained';
    
    public static $errors = array(
        self::ERROR_NO_DATA_PASSED,
        self::ERROR_APIKEY_NOT_FOUND,
        self::ERROR_EMPTY_LIST_ID,
        self::ERROR_INVALID_LIST_ID,
        self::ERROR_EMAIL_NOT_FOUND,
    );
    
    public static $results = array(
        self::RESULT_BOUNCED,
        self::RESULT_SOFT_BOUNCED,
        self::RESULT_SOFT_COMPLAINED,
        self::RESULT_SUBSCRIBED,
        self::RESULT_UNCONFIRMED,
        self::RESULT_UNSUBSCRIBED
    );
    
    
    public function __construct(ResponseInterface $response)
    {
        $responseString = $response->getBody()->__toString();
        if(in_array($responseString, self::$results)){
            $this->isError = false;
            $this->result = $responseString;
        }else{
            $this->parseError($responseString);
        }
    }
}
