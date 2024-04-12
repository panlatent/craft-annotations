<?php

namespace panlatent\craft\annotations\web\annotations;

use craft\web\Controller;
use JetBrains\PhpStorm\ExpectedValues;

#[\Attribute(\Attribute::TARGET_CLASS)]
class AllowAnonymous
{
    /**
     * @param array|bool|int| $allowAnonymous
     */
    public function __construct(
        #[ExpectedValues(Controller::ALLOW_ANONYMOUS_NEVER, Controller::ALLOW_ANONYMOUS_LIVE, Controller::ALLOW_ANONYMOUS_OFFLINE)]
        public array|bool|int $allowAnonymous = true
    ) {}
}