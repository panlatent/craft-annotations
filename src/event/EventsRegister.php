<?php

namespace panlatent\craft\annotations\event;

use Craft;
use craft\events\DefineBehaviorsEvent;
use craft\events\RegisterComponentTypesEvent;
use panlatent\craft\annotations\event\annotations\Bootstrap;
use panlatent\craft\annotations\event\annotations\DefineBehaviors;
use panlatent\craft\annotations\event\annotations\RegisterComponentTypes;
use panlatent\craft\annotations\event\annotations\RegisterEvent;
use ReflectionClass;
use ReflectionFunctionAbstract;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\base\InvalidConfigException;

class EventsRegister extends Component implements BootstrapInterface
{
    public string $path = '@config/events.php';

    public ?object $configClass = null;

    public array $configFunctions = [];

    public array $handlers = [];

    public function init(): void
    {
        $path = Craft::getAlias($this->path);
        if (is_file($path)) {
            $config = require $path;
            if (is_object($config)) {
                $this->configClass = $config;
            } elseif (is_string($config) || (is_array($config) && (isset($config['class']) || isset($config['__class']))) || is_callable($config)) {
                $this->configClass = Craft::createObject($this->path);
            } elseif (is_array($config)) {
                $this->configFunctions = $config;
            } else {
                throw new InvalidConfigException();
            }
        }

        if ($this->configClass !== null) {
            foreach ((new ReflectionClass($this->configClass))->getMethods(\ReflectionMethod::IS_PUBLIC) as $refMethod) {
                $this->resolveFunction($this->wrapMethod($refMethod, $this->configClass));
            }
        } else {
            foreach ($this->configFunctions as $function) {
                $this->resolveFunction(new \ReflectionFunction($function));
            }
        }
    }

    public function bootstrap($app): void
    {
        $this->applyHandlers();
    }

    public function resolveFunction(ReflectionFunctionAbstract $fn): void
    {
        foreach ($fn->getAttributes() as $attribute) {
            switch ($attribute->getName()) {
                case Bootstrap::class:
                    $fn->invoke(Craft::$app);
                    break;
                case RegisterEvent::class:
                    $instance = $attribute->newInstance();
                    $this->handlers[] = [$instance->class, $instance->event, $fn->getClosure()];
                    break;
                case RegisterComponentTypes::class:
                    $instance = $attribute->newInstance();
                    $this->handlers[] = [$instance->class, $instance->event, fn(RegisterComponentTypesEvent $e) => $e->types = $instance->replace ? $fn->invoke() : array_merge($e->types, $fn->invoke())];
                    break;
                case DefineBehaviors::class:
                    $instance = $attribute->newInstance();
                    if ($instance->class === '') {
                        $refParams = $fn->getParameters();
                        if (!isset($refParams[0])) {
                            throw new \Exception('DefineBehaviors method ' . $fn->getName() . ' must have 1 parameter when class is null');
                        }
                        $instance->class = $refParams[0]->getType()->getName();
                    }
                    $this->handlers[] = [$instance->class, $instance->event, fn(DefineBehaviorsEvent $e) => $e->behaviors = $instance->replace ? $fn->invoke($e->sender) : array_merge($e->behaviors, $fn->invoke($e->sender))];
                    break;
            }
        }
    }

    public function applyHandlers(): void
    {
        foreach ($this->handlers as [$class, $event, $handler]) {
            Event::on($class, $event, $handler);
        }
    }

    private function wrapMethod(\ReflectionMethod $method, object $object)
    {
        return new class($method, $object) extends \ReflectionFunctionAbstract {
            public function __construct(private \ReflectionMethod $method, private $object) {}

            public static function export() {}

            public function __toString()
            {
                return $this->method->__toString();
            }

            public function invoke(...$args)
            {
                return $this->method->invoke($this->object, ...$args);
            }

            public function getClosure(): \Closure
            {
                return $this->method->getClosure($this->object);
            }

            public function __call($name, $args)
            {
                return $this->method->$name(...$args);
            }

            public function getAttributes(?string $name = null, int $flags = 0): array
            {
                return $this->method->getAttributes($name, $flags);
            }

            public function getParameters(): array
            {
                return $this->method->getParameters();
            }
        };
    }
}