<?php
namespace Vratiu\SendyApi;

class SendyApi
{
    /**
     * Connection config
     * @var array
     */
    protected $config = array();
    
    /**
     * Http Client
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;
    
    protected $actions = array(
        'subscribe' => '/subscribe',
        'unsubscribe' => '/unsubscribe',
        'subscription.status' => '/api/subscribers/subscription-status.php',
        'subscriber.count' => '/api/subscribers/active-subscriber-count.php'
    );

    public function __construct(array $config)
    {
       $this->config = $config;
    }
    
    public function setClient(\GuzzleHttp\ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        
        return $this;
    }
    
    /**
     * Get Http Client
     * @return \GuzzleHttp\ClientInterface
     */
    public function getClient()
    {
        return $this->httpClient;
    }
    
    /**
     * Make a http request to server
     * @param string $action
     * @param array $params
     * @param string $method
     * @return \GuzzleHttp\Psr7\Response
     * @throws Exception
     */
    public function makeRequest($action, array $params, $method = 'POST')
    {
        $options = ($method == 'GET')? array('query' => $params)
                                    : array('form_params' => $params);
        
        $client = $this->getClient();
        $response = $client->request(
                                $method,
                                $this->getActionUrl($action),
                                $options
                            );

        if($response->getStatusCode() >= 400){
            throw new Exception('Request error', $response->getStatusCode());
        }
        
        return $response;
    }
    
    public function subscribe($email, $name, array $extra = array())
    {
        $params = $extra + array(
            'email' => $email,
            'name' => $name,
            'list' => $this->config['subscriberList'],
            'boolean' => 'true'
            );
        $res = $this->makeRequest('subscribe', $params);
        
        return new Result\Subscribe($res);
    }
    
    public function unsubscribe($email)
    {
        $res = $this->makeRequest('unsubscribe', array(
            'list' => $this->config['subscriberList'],
            'email' => $email,
            'boolean' => 'true'
        ));
        
        return new Result\Unsubscribe($res);
    }
    
    
    public function subscriberCount()
    {
        $res = $this->makeRequest('subscriber.count', array(
            'api_key' => $this->config['apiKey'],
            'list_id' => $this->config['subscriberList']
        ));
        return new Result\SubscriberCount($res);
    }
    
    public function subscriptionStatus($email)
    {
        $res = $this->makeRequest('subscription.status', array(
            'api_key' => $this->config['apiKey'],
            'list_id' => $this->config['subscriberList'],
            'email' => $email
        ));
        return new Result\SubscriptionStatus($res);
    }
    
    protected function getActionUrl($action)
    {
        if (false == isset($this->actions[$action])) {
            throw new Exception("Action $action is not a valid SendyApi action");
        }

        return $this->config['url'] . $this->actions[$action];
    }
}

