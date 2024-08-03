Jaxon Library for CakePHP
=========================

This package integrates the [Jaxon library](https://github.com/jaxon-php/jaxon-core) into the CakePHP framework.

Installation
------------

The version 4 of the package requires CakePHP version 4.

Install the package with `Composer`.

```bash
composer require jaxon-php/jaxon-cake ^5.0
```
Or
```json
{
    "require": {
        "jaxon-php/jaxon-cake": "^5.0",
    }
}
```
And run `composer install`.

Load the Jaxon plugin in the `src/Application.php` file.

```php
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        ...

        // Load more plugins here
        $this->addPlugin(\Jaxon\Cake\JaxonPlugin::class, ['routes' => true]);
    }
```

Load the Jaxon view helper in the `src\View\AppView.php` file.

```php
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadHelper('Jaxon/Cake.Jaxon');
    }
```

Routing and middlewares
-----------------------

This package provides two middlewares, one to load the Jaxon config, and the other to process Jaxon requests.
The Jaxon config middleware must be attached to the routes to all the pages where the Jaxon features are enabled,
while the later must be attached to the controller action that processes Jaxon requests.

```php
use Jaxon\Cake\Middleware\ConfigMiddleware as JaxonConfigMiddleware;

$routes->scope('/', function (RouteBuilder $builder) {
    // Register Jaxon middlewares
    $builder->registerMiddleware('jaxon.config', new JaxonConfigMiddleware());

    // Apply the "jaxon.config" middleware to routes to pages that require Jaxon.
    $builder->applyMiddleware('jaxon.config');

    ...
});

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

### The javascript and CSS code

The Jaxon view helper provides functions to insert the Jaxon javascript and CSS code into a page.

```php
<!-- The Jaxon CSS code -->
<?= $this->Jaxon->css() ?>
```

```php
<!-- The Jaxon javascript includes -->
<?= $this->Jaxon->js() ?>
```

```php
<!-- The Jaxon javascript code -->
<?= $this->Jaxon->script() ?>
```

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

Contribute
----------

- Issue Tracker: github.com/jaxon-php/jaxon-cake/issues
- Source Code: github.com/jaxon-php/jaxon-cake

License
-------

The package is licensed under the BSD license.
