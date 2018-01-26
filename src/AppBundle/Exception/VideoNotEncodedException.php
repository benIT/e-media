<?php

namespace AppBundle\Exception;

class VideoNotEncodedException extends \RuntimeException
{
    /**
     * VideoNotEncodedException constructor.
     */
    public function __construct($message = null)
    {
        parent::__construct($message);
    }
}