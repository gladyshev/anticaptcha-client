<?php

namespace Anticaptcha\Response;

abstract class StatusResponse extends AbstractResponse
{
    public ?string $status = null;
}
