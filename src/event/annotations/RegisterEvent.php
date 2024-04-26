<?php

namespace panlatent\craft\annotations\event\annotations;

#[\Attribute(\Attribute::TARGET_FUNCTION|\Attribute::TARGET_METHOD)]
class RegisterEvent
{
    public function __construct(public string $class, public string $event)
    {

    }
}