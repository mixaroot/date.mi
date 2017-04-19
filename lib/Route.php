<?php

namespace lib;

/**
 * Class Route
 * @package lib
 */
class Route
{
    /**
     * @var array
     */
    private $rules = [];

    /**
     * @param array $rules
     */
    function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @throws \Exception
     */
    public function start()
    {
        try {
            $this->getRoute();
        } catch (\Throwable $ex) {
            throw new \Exception($ex);
        }
    }

    /**
     * Start class by route
     */
    private function getRoute()
    {
        $method = $this->getUri();
        foreach ($this->rules as $rule => $class) {
            if ($method === $rule) {
                $controller = new $class;
                if ($controller instanceof Controller) {
                    (new $class)->init();
                } else {
                    throw new \Exception('Controller must implement lib Controller');
                }
                return;
            }
        }
        throw new \Exception('Have not rules');
    }

    /**
     * Get request URI
     * @return string
     */
    protected function getUri()
    {
        return mb_strtolower($_SERVER['REQUEST_URI']);
    }
}