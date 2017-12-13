# CHANGELOG

## v0.4.0: Symfony 4

* added Symfony 4 support
* removed Symfony 3 support

> **BC break**: the service alias `gnugat_pomm_foundation.query_manager` has been removed,
> use service ID `PommProject\Foundation\QueryManager\QueryManagerInterface` instead

## v0.3.1: Symfony 4 tree

* Used Symfony 4 directory tree structure

## v0.3.0: PHP 7.1

* bumped requirement to PHP 7.1
* removed addClassesToCompile for Symfony 4 compatibility
* created service `PommProject\Foundation\QueryManager\QueryManagerInterface`
  (`gnugat_pomm_foundation.query_manager` is now an alias of this service,
  to keep BC, but it will drop in future versions)

> **BC break**: void return type hints are used, making this bundle incompatible
> with applications running on PHP < 7.1

## v0.2.1: fixed CreateDatabae

Previously `CreateDatabase` would try to list databases (in order to check if it already exists)
without setting the database user, which could cause the following PostgreSQL error:

```
psql: FATAL:  role "<database_user>" does not exist
```

Now fixed!

## v0.2.0: terminate

This second version delays the closing of the database connection to the very last moment.

* fixed `gnugat-pomm-foundation:database:create` to work even if the database already exists
* fixed `gnugat-pomm-foundation:database:drop` to work even if the database doesn't exists
* added Symfony 3 support

> **BC break**: `ClosingConnectionListener` now listens to `kernel.terminate` instead of `kernel.response`.

## v0.1.1: Fixed Commands

* fixed condition to set database password
* fixed CommandTest by preventing auto exit

## v0.1.0

This first version provides a `QueryManagerInterface` implementation with the following features:

* it will open a new database connection the first time `query` is called (lazy database connection)
* it has a `shutdown` method that closes the database connection (called on `kernel.response` event by `ClosingConnectionListener`)

It also provides a command to create the database and one to close it.
