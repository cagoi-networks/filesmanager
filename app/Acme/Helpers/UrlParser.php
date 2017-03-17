<?php

namespace App\Acme\Helpers;

class UrlParser {

    private $url;
    private $operations;

    /**
     * UrlParser constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $this->url = array_filter(explode('&', preg_replace('/^-\//','', $this->url)));
        foreach ($this->url as $url)
        {
            $url = array_filter(explode('=', $url));
            $this->operations[$url[0]] = isset($url[1])? $url[1]: null;
        }
        return $this->operations;
    }
}