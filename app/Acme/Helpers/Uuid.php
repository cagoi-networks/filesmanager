<?php

namespace App\Acme\Helpers;

class Uuid {

    protected $version = '1';

    /**
     * Uuid constructor.
     * @param $version
     */
    public function __construct($version)
    {
        $this->version = $version;
    }

    /**
     * @return bool|string
     */
    public function generate()
    {
        if (!in_array($this->version, [1,4]))
            return false;

        if($this->version == 1)
            $uuid = \Ramsey\Uuid\Uuid::uuid1();
        else
            $uuid = \Ramsey\Uuid\Uuid::uuid4();

        return $uuid->toString();
    }
}