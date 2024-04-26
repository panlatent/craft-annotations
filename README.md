Craft Annotations
=================

Craft Annotations aims to use PHP annotation features to bring a new development experience to CraftCMS and Yii Framework.

> Notice: This library is experimental and there will undoubtedly be some performance impact (but probably minimal) from using it,
> as parsing annotations requires leveraging the reflection API.

Craft Annotations are not intrusive. It uses inheritance to implement functionality. 
Use it on demand or as a middle layer between your application and Craft/Yii.

Features
-------
+ Events Register
+ Controller Access Control

Requirements
------------
+ PHP 8.0.2 or later.

Installation
------------

Then tell Composer to load the library

```bash
composer require panlatent/craft-annotations
```

Usages
------

### Events Register
The Events Register provides a configuration with annotations to register event handlers in a unified way.

1. Add `EventsRegister` to application config file `config/app.php` and set `bootstrap`.
    ```php
    use panlatent\craft\annotations\event\EventsRegister;
    
    return [
        'bootstrap' => [EventsRegister::class]
    ]
    ```

2. Add `events.php` to `config` directory. This configuration file supports 3 methods:

    Function array:
    ```php
    <?php
    return [
        #[RegisterComponentTypes(Elements::class, Elements::EVENT_REGISTER_ELEMENT_TYPES)]
        function(): array {
            return [YourElement::class];
        },
    ];
    ```
    
    Class object
    ```php
    <?php
    return new class {};  // or return new YourClass()
    ```
    
    Class config by `Yii::createObject()` / `Craft::createObject()`
    ```php
    <?php
    return ['class' => YourClass::class]
    ```
3. Register event using annotations [class demo](demo/EventsConfig.php)

+ [#Bootstrap](src%2Fevent%2Fannotations%2FBootstrap.php)
+ [#DefineBehaviors](src%2Fevent%2Fannotations%2FDefineBehaviors.php)
+ [#RegisterComponentTypes](src%2Fevent%2Fannotations%2FRegisterComponentTypes.php)
+ [#RegisterEvent](src%2Fevent%2Fannotations%2FRegisterEvent.php)

```



Documentation
------------

| Attribute             | Targets          | Scopes | Supports                                                                                                                                                                                   |
|-----------------------|------------------|--------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| #[AllowAnonymous]     | Controller       | Class  | [![Craft](https://img.shields.io/badge/Craft-orange.svg?style=flat)](https://craftcms.com/) [![Yii](https://img.shields.io/badge/Yii-green.svg?style=flat)](https://www.yiiframework.com/) |
| #[RequireLogin]       | ControllerAction | Method | [![Craft](https://img.shields.io/badge/Craft-orange.svg?style=flat)](https://craftcms.com/)                                                                                                |                                                                                         
| #[RequirePostRequest] | ControllerAction | Method | [![Craft](https://img.shields.io/badge/Craft-orange.svg?style=flat)](https://craftcms.com/)                                                                                                |                                                                                      
| #[RequireAcceptsJson] | ControllerAction | Method | [![Craft](https://img.shields.io/badge/Craft-orange.svg?style=flat)](https://craftcms.com/)                                                                                                |                                                                                    

License
-------
The Element Messages is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
