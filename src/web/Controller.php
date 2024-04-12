<?php

namespace panlatent\craft\annotations\web;

use panlatent\craft\annotations\web\annotations\AllowAnonymous;
use panlatent\craft\annotations\web\annotations\CsrfValidation;
use panlatent\craft\annotations\web\annotations\RequireAcceptsJson;
use panlatent\craft\annotations\web\annotations\RequireLogin;
use panlatent\craft\annotations\web\annotations\RequirePostRequest;
use ReflectionClass;
use ReflectionMethod;
use yii\base\Action;
use yii\base\InlineAction;

abstract class Controller extends \craft\web\Controller
{
    public function init(): void
    {
        $class = new ReflectionClass($this);
        $annotations = $class->getAttributes();
        foreach ($annotations as $annotation) {
            switch ($annotation->getName()) {
                case AllowAnonymous::class:
                    $this->allowAnonymous = $annotation->newInstance()->allowAnonymous;
                    break;
                case CsrfValidation::class:
                    $this->enableCsrfValidation = $annotation->newInstance()->enabled;
                    break;
            }
        }

        parent::init();
    }

    public function beforeAction($action): bool
    {
        $this->_enforceCsrfValidation($action);

        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->_enforceRequireAnnotations($action);

        return true;
    }

    private function _enforceCsrfValidation(Action $action): void
    {
        if (!$action instanceof InlineAction) {
            return;
        }
        $method = new ReflectionMethod($action->controller, $action->actionMethod);
        $attributes = $method->getAttributes();
        foreach ($attributes as $attribute) {
            match ($attribute->getName()) {
                CsrfValidation::class => $this->enableCsrfValidation = $attribute->newInstance()->enabled,
                default => null
            };
        }
    }

    private function _enforceRequireAnnotations(Action $action): void
    {
        if (!$action instanceof InlineAction) {
            return;
        }
        $method = new ReflectionMethod($action->controller, $action->actionMethod);
        $attributes = $method->getAttributes();
        foreach ($attributes as $attribute) {
            match ($attribute->getName()) {
                RequireLogin::class => $this->requireLogin(),
                RequirePostRequest::class => $this->requirePostRequest(),
                RequireAcceptsJson::class => $this->requireAcceptsJson(),
                default => null
            };
        }
    }
}