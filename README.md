# Composer History

[![Latest Stable Version](https://poser.pugx.org/glhd/composer-history/v)](https://packagist.org/packages/glhd/composer-history) [![Total Downloads](https://poser.pugx.org/glhd/composer-history/downloads)](https://packagist.org/packages/glhd/composer-history) [![Latest Unstable Version](https://poser.pugx.org/glhd/composer-history/v/unstable)](https://packagist.org/packages/glhd/composer-history) [![License](https://poser.pugx.org/glhd/composer-history/license)](https://packagist.org/packages/glhd/composer-history)

Quickly see the composer commands you've run on your current git branch.

Any time you run:

 - `composer require`  
 - `composer update` 
 - `composer remove`
 
It will be stored to a `.composer-history` file in your project. You can run
the `composer show-history` command to see all the history for your current
git branch, and run `composer show-history --executable` to get a block of
text that you can copy and run to re-run your history.

This often is *much* easier than dealing with `composer.lock` conflicts, as
you almost always want to just install an package or update one or two and
not affect any other changes that happened upstream.

## Usage

```shell script
$ composer require internachi/modular
Loading composer repositories with package information
Updating dependencies (including require-dev)
...

$ composer update laravel/framework
...

$ composer show-history

Command history for feature/history-demo

[2020-07-10 10:00:00] composer require internachi/modular
[2020-07-10 10:01:00] composer update laravel/framework

$ composer show-history --executable

Command history for feature/history-demo

composer require internachi/modular \
  && composer update laravel/framework
```
