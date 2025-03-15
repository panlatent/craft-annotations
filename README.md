Craft Annotations
=================

Craft Annotations aims to use PHP annotation features to bring a new development experience to CraftCMS and Yii Framework.

⚠️ This project has been transferred to another repository [Craft Attribute](https://github.com/panlatent/craft-attribute). 

> Notice: This library is experimental and there will undoubtedly be some performance impact (but probably minimal) from using it,
> as parsing annotations requires leveraging the reflection API.

Craft Annotations are not intrusive. It uses inheritance to implement functionality. 
Use it on demand or as a middle layer between your application and Craft/Yii.

Features
-------
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
