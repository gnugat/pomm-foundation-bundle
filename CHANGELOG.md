# CHANGELOG

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
