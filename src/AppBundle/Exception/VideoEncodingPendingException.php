<?php

namespace AppBundle\Exception;

class VideoEncodingPendingException extends \RuntimeException
{
    /**
     * VideoNotEncodedException constructor.
     */
    public function __construct($message = null)
    {
        parent::__construct($message);
    }
}