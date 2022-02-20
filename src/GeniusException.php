<?php

namespace Yzpeedro\GeniusPhpSdk;

use Exception;
use Throwable;

class GeniusException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString() {
        return "GeniusException: [$this->code]: $this->message\n";
    }
}