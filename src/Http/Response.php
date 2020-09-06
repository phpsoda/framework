<?php

namespace PHPSoda\Http;

/**
 * Class Response
 *
 * @package PHPSoda\Http
 */
class Response
{
    /**
     * @var string
     */
    protected $content;
    /**
     * @var int
     */
    protected $statusCode;
    /**
     * @var string
     */
    protected $statusText;
    /**
     * @var ParameterBag
     */
    protected $headers;
    /**
     * @var string
     */
    protected $version;

    /**
     * @var string[]
     */
    public static $statusTexts = [
        100 => 'Continue',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        204 => 'No Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        304 => 'Not Modified',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        503 => 'Service Unavailable',
    ];

    /**
     * Response constructor.
     *
     * @param string $content
     * @param int    $status
     * @param array  $headers
     */
    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setHeaders($headers);
        $this->setProtocolVersion('1.0');
    }

    /**
     * @return $this
     */
    public function sendContent()
    {
        echo $this->content;

        return $this;
    }

    /**
     * @return $this
     */
    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }

        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value, $key === 'Content-Type', $this->statusCode);
        }

        header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText), true, $this->statusCode);

        return $this;
    }

    /**
     * @return $this
     */
    public function send()
    {
        $this->sendContent();
        $this->sendHeaders();

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        if (array_key_exists($statusCode, static::$statusTexts)) {
            $this->statusText = static::$statusTexts[$statusCode];
        } else {
            $this->statusText = 'Unknown';
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * @return ParameterBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = new ParameterBag($headers);

        return $this;
    }

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setProtocolVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }
}
