# Composer History

Quickly see the composer commands you've run on your current git branch.

Any time you run:

 - `composer require` 
 - `composer install` 
 - `composer update` 
 - `composer remove`
 
It will be stored to a `.composer-history` file in your project. You can run
the `composer show-history` command to see all the history for your current
git branch, and run `composer show-history --executable` to get a block of
text that you can copy and run to re-run your history.

This often is *much* easier than dealing with `composer.lock` conflicts, as
you almost always want to just install an package or update one or two and
not affect any other changes that happened upstream.
