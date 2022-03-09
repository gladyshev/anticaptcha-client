<?php

namespace Anticaptcha;

interface TaskInterface
{
    public function getType(): string;
    public function toArray(): array;
}
