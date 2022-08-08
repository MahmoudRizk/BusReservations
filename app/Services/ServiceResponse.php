<?php

namespace App\Services;

class ServiceResponse
{
    public bool $success;
    public string $errorCode;
    public string $message;
    public $data;

    public function __construct(bool $success = false, string $errorCode = "", string $message = "", $data = [])
    {
        $this->success = $success;
        $this->errorCode = $errorCode;
        $this->message = $message;
        $this->data = $data;
    }
}
