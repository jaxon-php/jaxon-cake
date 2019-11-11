Jaxon Library for CakePHP
=========================

This package integrates the [Jaxon library](https://github.com/jaxon-php/jaxon-core) into the CakePHP 3 framework.

Features
--------

- Read Jaxon options from a file in CakePHP config format.
- Automatically register Jaxon classes from a preset directory.

Installation
------------

First install CakePHP version 3.

Create the `composer.json` file into the installation dir with the following content.
```json
{
    "require": {
        "jaxon-php/jaxon-cake": "~3.0",
    }
}
```

Add the Jaxon plugin in the `vendor/cakephp-plugins.php` file.
```php
return [
    'plugins' => [
        ...
        'Jaxon/Cake' => $baseDir . '/vendor/jaxon-php/jaxon-cake/',
    ]
];
```

Load the Jaxon plugin in the controller or in the bootstrap file.
```php
Plugin::load('Jaxon/Cake', array('autoload' => true, 'routes' => true));
```

Load the Jaxon component in the controller.
```php
$this->loadComponent('Jaxon/Cake.Jaxon');
```

Configuration
------------

The settings in the `config/jaxon.php` config file are separated into two sections.
The options in the `lib` section are those of the Jaxon core library, while the options in the `app` sections are those of the CakePHP application.

The following options can be defined in the `app` section of the config file.

| Name | Description |
|------|---------------|
| directories | An array of directory containing Jaxon application classes |
| views   | An array of directory containing Jaxon application views |
| | | |

By default, the `views` array is empty. Views are rendered from the framework default location.
There's a single entry in the `directories` array with the following values.

| Name | Default value | Description |
|------|---------------|-------------|
| directory | ROOT . '/jaxon/Controller' | The directory of the Jaxon classes |
| namespace | \Jaxon\App  | The namespace of the Jaxon classes |
| separator | .           | The separator in Jaxon class names |
| protected | empty array | Prevent Jaxon from exporting some methods |
| | | |

Usage
-----

This is an example of a CakePHP controller using the Jaxon library.

```php
namespace App\Controller;

class DemoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        // Load the Jaxon component
        $this->loadComponent('Jaxon/Cake.Jaxon');
    }

    public function index()
    {
        // Call the Jaxon module
        $this->Jaxon->register();

        $this->set('jaxonCss', $this->Jaxon->css());
        $this->set('jaxonJs', $this->Jaxon->js());
        $this->set('jaxonScript', $this->Jaxon->script());
        $this->render('demo');
    }
}
```

Before it prints the page, the controller calls the `$this->Jaxon->css()`, `$this->Jaxon->js()` and `$this->Jaxon->script()` functions to get the CSS and javascript codes generated by Jaxon, which it inserts into the page.

### The Jaxon classes

The Jaxon classes can inherit from `\Jaxon\CallableClass`.
By default, they are located in the `ROOT/jaxon/Classes` dir of the CakePHP application, and the associated namespace is `\Jaxon\App`.

This is an example of a Jaxon class, defined in the `ROOT/jaxon/Classes/HelloWorld.php` file.

```php
namespace Jaxon\App;

class HelloWorld extends \Jaxon\CallableClass
{
    public function sayHello()
    {
        $this->response->assign('div2', 'innerHTML', 'Hello World!');
        return $this->response;
    }
}
```

### Request processing

By default, the Jaxon request are handled by the controller in the `src/Controller/JaxonController.php` file.
The `/jaxon` route is defined in the `config/routes.php` file, and linked to the `JaxonController::index()` method.

Contribute
----------

- Issue Tracker: github.com/jaxon-php/jaxon-cake/issues
- Source Code: github.com/jaxon-php/jaxon-cake

License
-------

The package is licensed under the BSD license.
