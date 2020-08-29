<?php

namespace PHPSoda\Http;

/**
 * Class JsonResponse
 * @package PHPSoda\Http
 */
class JsonResponse extends Response
{
    public function __construct($data = null, int $status = 200, array $headers = [])
    {
        parent::__construct(json_encode($data), $status, $headers);

        $this->getHeaders()->set('Content-Type', 'application/json');
    }
}
