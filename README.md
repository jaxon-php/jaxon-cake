Jaxon Library for CakePHP
=========================

This package integrates the [Jaxon library](https://github.com/jaxon-php/jaxon-core) into the CakePHP framework.

Features
--------

- Read Jaxon options from a file in CakePHP config format.
- Automatically register Jaxon classes from a preset directory.

Installation
------------

The version 4 of the package requires CakePHP version 4.

Install the package with `Composer`.

```bash
composer require jaxon-php/jaxon-cake ^4.0
```
Or
```json
{
    "require": {
        "jaxon-php/jaxon-cake": "^4.0",
    }
}
```
And run `composer install`.

Routing and middlewares
-----------------------

```php
use Jaxon\Cake\Middleware\AjaxMiddleware as JaxonAjaxMiddleware;
use Jaxon\Cake\Middleware\ConfigMiddleware as JaxonConfigMiddleware;

$routes->scope('/', function (RouteBuilder $builder) {
    // Register Jaxon middlewares
    $builder->registerMiddleware('jaxon.ajax', new JaxonAjaxMiddleware());
    $builder->registerMiddleware('jaxon.config', new JaxonConfigMiddleware());

    // Apply the "jaxon.config" middleware to routes to pages that require Jaxon.
    $builder->applyMiddleware('jaxon.config');

    // Define the route that processes Jaxon requests, and apply the "jaxon.ajax" middleware.
    $builder->scope('/ajax', function (RouteBuilder $builder) {
        // Jaxon ajax middleware.
        $builder->applyMiddleware('jaxon.ajax');

        // Jaxon ajax route. Provide an empty controller method.
        $builder->post('/', ['controller' => 'Jaxon', 'action' => 'ajax', '_name' => 'jaxon']);
    });

    ...
```

Usage
-----

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
| directory | ROOT . '/jaxon/App' | The directory of the Jaxon classes |
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
    // Remove the return type (void) if you are using CakePHP 3.
    public function initialize(): void
    {
        parent::initialize();
        // Load the Jaxon component
        $this->loadComponent('Jaxon/Cake.Jaxon');
    }

    public function index()
    {
        $this->set('jaxonCss', $this->Jaxon->css());
        $this->set('jaxonJs', $this->Jaxon->js());
        $this->set('jaxonScript', $this->Jaxon->script());
        $this->render('demo');
    }
}
```

Before it prints the page, the controller calls the `$this->Jaxon->css()`, `$this->Jaxon->js()` and `$this->Jaxon->script()` functions to get the CSS and javascript codes generated by Jaxon, which it inserts into the page.

### The Jaxon classes

The Jaxon classes can inherit from `\Jaxon\App\CallableClass`.
By default, they are located in the `ROOT/jaxon/App` dir of the CakePHP application, and the associated namespace is `\Jaxon\App`.

This is an example of a Jaxon class, defined in the `ROOT/jaxon/App/HelloWorld.php` file.

```php
namespace Jaxon\App;

class HelloWorld extends \Jaxon\App\CallableClass
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
