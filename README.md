# PommFoundation Bundle

A [pomm-project/foundation](https://github.com/pomm-project/Foundation)
integration in [Symfony](http://symfony.com/).

This bundle provides Console Commands for your database, as well as a
Pomm's `QueryManagerInterface` service to be able to make SQL queries in your
Symfony application.

The provided `QueryManagerInterface` implementation is tied to a Connection:

1. the first time it is called, opens a new connection
2. the next times it is called, uses the existing connection
3. if shutdown is called, closes the connection and goes back to step 1

This allows to keep a 1 to 1 relation between a HTTP request and a database
Connection, which is important when the application is a long running process
(e.g. tests, FastCGI, AMQP consumer, etc).
 
It also provides support parameter conversion for:

* booleans: from `false` to `'f'` and from `true` to `'t'`
* `\DateTime`: string formatted as `Y-m-d H:i:s T`

## Integrations

This bundle provides provides the following:

* the service `PommProject\Foundation\QueryManager\QueryManagerInterface`
* the event listener `Gnugat\PommFoundationBundle\EventListener\ClosingConnectionListener`
* the console commands:
    * `gnugat-pomm-foundation:database:check-existence` (`g:p:ch`)
    * `gnugat-pomm-foundation:database:close-connections` (`g:p:cl`)
    * `gnugat-pomm-foundation:database:create` (`g:p:cr`)
    * `gnugat-pomm-foundation:database:drop` (`g:p:dr`)
    * `gnugat-pomm-foundation:database:dump` (`g:p:du`)
    * `gnugat-pomm-foundation:database:execute-file` (`g:p:ex`)
    * `gnugat-pomm-foundation:database:launch-console` (`g:p:la`)
    * `gnugat-pomm-foundation:database:query` (`g:p:qu`)

## Installation

First provide the database configuration:

```
# config/parameters.yaml.dist
parameters:
    database_host: 127.0.0.1
    database_port: 5432
    database_name: gnugat_pomm_foundation
    database_user: postgres
    database_password: ~
```

Then install `gnugat/pomm-foundation-bundle` using [Composer](https://getcomposer.org/download/):

```
composer require gnugat/pomm-foundation-bundle:^0.5
```

Finally add the following in your `config/bundles.php`:

```
<?php

return [
    // Your other bundles...

    \Gnugat\PommFoundationBundle\GnugatPommFoundationBundle::class => ['all' => true],
];
```

## Usage

Inject the `PommProject\Foundation\QueryManager\QueryManagerInterface` service in your own services:

```
<?php

use PommProject\Foundation\QueryManager\QueryManagerInterface;

class MyService
{
    private const NO_RESULTS = [];

    private $queryManager;

    public function __construct(QueryManagerInterface $queryManager)
    {
        $this->queryManager = $queryManager;
    }

    public function myMethod(int $id, bool $isDeleted): array
    {
        $results = iterator_to_array($this->queryManager->query(
            'SELECT * FROM my_table WHERE id = $* AND is_deleted = $*',
            [
                $id,
                $isDeleted,
            ]
        ));
        if (self::NO_RESULTS === $results) {
            throw new \Exception("Nothing found in my_table for ID \"$id\"");
        }

        return $results;
    }
}
```

## Further documentation

You can see the current and past versions using one of the following:

* the `git tag` command
* the [releases page on Github](https://github.com/gnugat/pomm-foundation-bundle/releases)
* the file listing the [changes between versions](CHANGELOG.md)

You can find more documentation at the following links:

* [copyright and MIT license](LICENSE)
* [versioning and branching models](VERSIONING.md)
* [contribution instructions](CONTRIBUTING.md)
