<?php

use craft\console\Application as ConsoleApplication;
use craft\elements\Entry as EntryElement;
use craft\elements\User as UserElement;
use craft\events\RegisterCpNavItemsEvent;
use craft\services\Dashboard;
use craft\services\Elements;
use craft\web\Application as WebApplication;
use craft\web\twig\variables\Cp;
use panlatent\craft\annotations\event\annotations\Bootstrap;
use panlatent\craft\annotations\event\annotations\DefineBehaviors;
use panlatent\craft\annotations\event\annotations\RegisterComponentTypes;
use panlatent\craft\annotations\event\annotations\RegisterEvent;

/**
 * The class is a class template to register events.
 * @see panlatent\craft\annotations\event\EventsRegister
 */
class EventsConfig
{
    /**
     * On application bootstrap
     *
     * @param ConsoleApplication|WebApplication $app The application. The parameter type not is required.
     * @return void
     */
    #[Bootstrap]
    public function register(ConsoleApplication|WebApplication $app): void
    {

    }

    #[RegisterEvent(Cp::class, Cp::EVENT_REGISTER_CP_NAV_ITEMS)]
    public function registerCpEvents(RegisterCpNavItemsEvent $e): void
    {
        // $e->items[] = ['label' => 'xxx', 'url' => 'xxx'];
    }

    /**
     * Add new elements.
     * @return array
     */
    #[RegisterComponentTypes(Elements::class, Elements::EVENT_REGISTER_ELEMENT_TYPES)]
    public function getElements(): array
    {
        return [];
    }

    /*
     * Replace elements.
     *
     * @return array
     */
    #[RegisterComponentTypes(Dashboard::class, Dashboard::EVENT_REGISTER_WIDGET_TYPES, true)]
    public function getWidgets(): array
    {
        return [];
    }

    /**
     * Define behaviors into a class. The class name is first parameter of DefineBehaviors.
     *
     * @see DefineBehaviors
     * @return array
     */
    #[DefineBehaviors(UserElement::class)]
    public function registerBehaviors(): array
    {
        return [];
    }

    /**
     * Define behaviors into a class. The class name is first parameter type of the method.
     *
     * @param EntryElement $entry
     * @return array
     * @see DefineBehaviors
     */
    #[DefineBehaviors]
    public function registerEntryBehaviors(EntryElement $entry): array
    {

    }
}