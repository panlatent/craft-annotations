<?php

namespace panlatent\craft\annotations\web\annotations;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class CsrfValidation
{
    public function __construct(public bool $enabled = true)
    {

    }
}