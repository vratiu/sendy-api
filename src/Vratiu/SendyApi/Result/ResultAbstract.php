<?php
namespace Vratiu\SendyApi\Result;

use GuzzleHttp\Psr7\Response;

abstract
class ResultAbstract implements ResultInterface
{
    /**
     * Default error
     */
    const ERROR_UNKNOWN     = 'Unknown error';
    
    /**
     * The response is valid or not
     * @var bool
     */
    protected $isError;
    
    protected $result;
    
    abstract public function __construct(Response $response);
    
    /**
     * Parses the error
     * @param type $responseString
     */
    protected function parseError($responseString)
    {
        $this->isError = true;
        if(in_array($responseString, static::$errors)){
            $this->result = $responseString;
        }else{
            $this->result = self::ERROR_UNKNOWN;
        }
    }
    
    public function isError()
    {
        return $this->isError;
    }
    
    public function result()
    {
        return $this->result;
    }
}
