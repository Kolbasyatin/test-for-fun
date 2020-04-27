<?php

declare(strict_types=1);


class Response
{
    /** @var string  */
    private $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function send()
    {
        echo $this->data;
    }

}