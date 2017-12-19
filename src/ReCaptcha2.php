<?php

namespace FreddieGar\GReCaptcha;

use Exception;

class ReCaptcha2
{
    /**
     * @var array
     */
    public $response;

    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * @var string
     */
    protected $reCaptcha;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $userAgent = 'MyAgent/1.0';

    /**
     * ReCaptcha2 constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!empty($config['reCaptcha'])) {
            $this->reCaptcha($config['reCaptcha']);
        }

        if (!empty($config['secret'])) {
            $this->secret($config['secret']);
        }

        if (!empty($config['ipAddress'])) {
            $this->ipAddress($config['ipAddress']);
        }

        if (!empty($config['url'])) {
            $this->url($config['url']);
        }

        if (!empty($config['userAgent'])) {
            $this->userAgent($config['userAgent']);
        }
    }

    /**
     * Do request to validate reCaptcha i  provider
     *
     * @return $this
     * @throws Exception
     */
    public function request()
    {
        if (!$this->validate()) {
            throw new Exception('Parameters required dont are complete, please verify');
        }

        $data = array(
            'secret' => $this->secret(),
            'response' => $this->reCaptcha()
        );

        // This parameter is optional, if exist is add in request
        if ($this->ipAddress()) {
            $data['remoteip'] = $this->ipAddress();
        }

        $query = http_build_query($data);

        $options = array(
            'http' => array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($query) . "\r\n" .
                    "User-Agent:" . $this->userAgent() . "\r\n",
                'method' => 'POST',
                'content' => $query
            )
        );

        $context = stream_context_create($options);

        $this->response(file_get_contents($this->url(), false, $context));

        return $this;
    }

    /**
     * Setter and Getter to reCaptcha
     * @param null $reCaptcha
     * @return $this|string
     */
    public function reCaptcha($reCaptcha = null)
    {
        if (!is_null($reCaptcha)) {
            $this->reCaptcha = $reCaptcha;
            return $this;
        }

        return $this->reCaptcha;
    }

    /**
     * Setter and Getter to secret
     * @param null $secret
     * @return $this|string
     */
    public function secret($secret = null)
    {
        if (!is_null($secret)) {
            $this->secret = $secret;
            return $this;
        }

        return $this->secret;
    }

    /**
     * Setter and Getter to IP Address
     * @param null $ipAddress
     * @return $this|string
     */
    public function ipAddress($ipAddress = null)
    {
        if (!is_null($ipAddress)) {
            $this->ipAddress = $ipAddress;
            return $this;
        }

        return $this->ipAddress;
    }

    /**
     * Setter and Getter to url
     * @param null $url
     * @return $this|string
     */
    public function url($url = null)
    {
        if (!is_null($url)) {
            $this->url = $url;
            return $this;
        }

        return $this->url;
    }

    /**
     * Setter and Getter to response
     * @param null $response
     * @return $this|array
     */
    private function response($response = null)
    {
        if (!is_null($response)) {
            $this->response = json_decode($response, true);
            return $this;
        }

        return $this->response;
    }

    /**
     * Setter and Getter to userAgent
     * @param null $userAgent
     * @return $this|string
     */
    public function userAgent($userAgent = null)
    {
        if (!is_null($userAgent)) {
            $this->userAgent = $userAgent;
            return $this;
        }

        return $this->userAgent;
    }

    /**
     * Validate data to sent
     * @return bool
     */
    protected function validate()
    {
        return !empty($this->url())
            && !empty($this->secret())
            && !empty($this->reCaptcha());
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isValid()
    {
        if (empty($this->response())) {
            throw new Exception('First run request() method to get a response');
        }

        $response = $this->response();

        return !empty($response['success']) && $response['success'];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getErrors()
    {
        if (empty($this->response())) {
            throw new Exception('First run request() method to get a response');
        }

        $response = $this->response();

        return !empty($response['error-codes']) ? $response['error-codes'] : [];
    }

    /**
     * Response from Google to array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response();
    }
}
