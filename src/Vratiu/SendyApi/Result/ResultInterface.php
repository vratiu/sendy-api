<?php
namespace Vratiu\SendyApi\Result;

use GuzzleHttp\Message\ResponseInterface;

interface ResultInterface
{
    /**
     * Parse response
     * @param \GuzzleHttp\Message\ResponseInterface $response
     */
    function __construct(ResponseInterface $response);
    
    /**
     * Is it an error
     * @return bool
     */
    function isError();
    
    /**
     * Actual response result
     * @return bool | string | int
     */
    function result();
}


