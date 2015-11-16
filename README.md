# PommFoundation Bundle

A [pomm-project/foundation](https://github.com/pomm-project/Foundation) integration in [Symfony](http://symfony.com/).

This bundle provides the following services:

* `gnugat_pomm_foundation.query_manager`: creates a `QueryManagerInterface` implementation, to use in your services

It also provides the following event listeners

* `gnugat_pomm_foundation.closing_connection_listener`: closes the database connection once the request has been dealt with

Finally it provides the following commands:

* `gnugat-pomm-foundation:database:create`: creates the database
* `gnugat-pomm-foundation:database:drop`: drops the database

## Installation

First provide the database configuration:

```
# app/config/parameters.yml.dist
parameters:
    database_host: 127.0.0.1
    database_port: 5432
    database_name: gnugat_pomm_foundation
    database_user: postgres
    database_password: ~
```

Then install `gnugat/pomm-foundation-bundle` using [Composer](https://getcomposer.org/download/):

    composer require gnugat/pomm-foundation-bundle:^0.2

Finally register `Gnugat\PommFoundationBundle\GnugatPommFoundationBundle` in `AppKernel.php`.

## Further documentation

You can see the current and past versions using one of the following:

* the `git tag` command
* the [releases page on Github](https://github.com/gnugat/pomm-foundation-bundle/releases)
* the file listing the [changes between versions](CHANGELOG.md)

You can find more documentation at the following links:

* [copyright and MIT license](LICENSE)
* [versioning and branching models](VERSIONING.md)
* [contribution instructions](CONTRIBUTING.md)
