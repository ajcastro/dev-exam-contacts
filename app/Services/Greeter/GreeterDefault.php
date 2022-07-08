<?php

namespace App\Services\Greeter;

class GreeterDefault implements GreeterInterface
{
    public function getMessage()
    {
        return 'Hello, How are you?';
    }
}
