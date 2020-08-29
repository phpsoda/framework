<?php

namespace PHPSoda\Http;

/**
 * Class Request
 * @package PHPSoda\Http
 */
class Request
{
    /**
     * @var ParameterBag
     */
    public $query;
    /**
     * @var ParameterBag
     */
    public $request;
    /**
     * @var ParameterBag
     */
    public $cookies;
    /**
     * @var ParameterBag
     */
    public $server;
    /**
     * @var ParameterBag
     */
    public $session;

    /**
     * Request constructor.
     * @param array $query
     * @param array $request
     * @param array $cookies
     * @param array $server
     * @param array $session
     */
    public function __construct(
        array $query = [],
        array $request = [],
        array $cookies = [],
        array $server = [],
        array $session = []
    ) {

        $this->query = new ParameterBag($query);
        $this->request = new ParameterBag($request);
        $this->cookies = new ParameterBag($cookies);
        $this->server = new ParameterBag($server);
        $this->session = new ParameterBag($session);
    }

    /**
     * @return static
     */
    public static function createFromGlobals()
    {
        switch ($_SERVER['CONTENT_TYPE']) {
            case 'application/json':
                $data = json_decode(file_get_contents('php://input'), true);
                break;
            default:
                $data = $_POST;
        }

        return new static($_GET, $data, $_COOKIE, $_SERVER, $_SESSION ?? []);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return trim($this->server->get('PATH_INFO', ''), '/');
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
    }
}
