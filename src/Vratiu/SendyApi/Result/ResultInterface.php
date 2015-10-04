<?php
namespace Vratiu\SendyApi\Result;

use GuzzleHttp\Psr7\Response;

interface ResultInterface
{
    /**
     * Parse response
     * @param Response $response
     */
    function __construct(Response $response);
    
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


