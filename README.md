# Do Not Expose Your Symfony

[![Latest Stable Version](https://poser.pugx.org/pyrech/do-not-expose-your-symfony/v/stable)](https://packagist.org/packages/pyrech/do-not-expose-your-symfony)
[![Total Downloads](https://poser.pugx.org/pyrech/do-not-expose-your-symfony/downloads)](https://packagist.org/packages/pyrech/do-not-expose-your-symfony)
[![Build Status](https://travis-ci.org/pyrech/do-not-expose-your-symfony.svg?branch=master)](https://travis-ci.org/pyrech/do-not-expose-your-symfony)

This project main's goal is to help you not exposing your project uses Symfony
by changing some default configuration.

## Why?

Symfony already do not leak a lot of information about itself. However we can
still find clues to detect whether your project uses Symfony. Potential hacker
could use these information to find security breaches that could be exploited.

See this [french article](https://afsy.fr/avent/2017/15-comment-ne-pas-trop-exposer-symfony)
for a not exhaustive list of things that can be detected and that this bundle
aims to change. 

## Installation

- Use [Composer](http://getcomposer.org/) to install `DoNotExposeYourSymfony` in your project:

```shell
composer require "pyrech/do-not-expose-your-symfony"
```

- If you do not use Symfony Flex, you will also need to manually register the
bundle inside the kernel:

```php
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Pyrech\DoNotExposeYourSymfony\PyrechDoNotExposeYourSymfonyBundle(),
        ];
        
        // ...

        return $bundles;
    }
```

## Further documentation

You can see the current and past versions using one of the following:

* the `git tag` command
* the [releases page on Github](https://github.com/pyrech/do-not-expose-your-symfony/releases)
* the file listing the [changes between versions](CHANGELOG.md)

And some meta documentation:

* [versioning and branching models](VERSIONING.md)
* [contribution instructions](CONTRIBUTING.md)

## Credits

* [All contributors](https://github.com/pyrech/do-not-expose-your-symfony/graphs/contributors);
* Inspired from this [(french) article](https://afsy.fr/avent/2017/15-comment-ne-pas-trop-exposer-symfony)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file
for details.
