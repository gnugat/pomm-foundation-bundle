# CHANGELOG

## v0.1.1: Fixed Commands

* fixed condition to set database password
* fixed CommandTest by preventing auto exit

## v0.1.0

This first version provides a `QueryManagerInterface` implementation with the following features:

* it will open a new database connection the first time `query` is called (lazy database connection)
* it has a `shutdown` method that closes the database connection (called on `kernel.response` event by `ClosingConnectionListener`)

It also provides a command to create the database and one to close it.
