Installation
============

Step 1: Download the Bundle
---------------------------

Update your composer.json:

```
"require": {
    ... ,
    "hardfaqcafe/furl-bundle" : "dev-master"
},
"repositories" : [{
    "type" : "vcs",
    "url" : "https://github.com/ox160d05d/FurlBundle.git"
}, ...],
```

Then:

```bash
$ composer update hardfaqcafe/furl-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.


Step 2: Enable the bundle
-------------------------

Enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new HardFAQCafe\FurlBundle\HardFAQCafeFurlBundle(),
        );

        // ...
    }

    // ...
}
```


Step 3: Update database schema
-------------------------

```bash
$ bin/console doctrine:schema:update --force
```


Step 4: Import FurlBundle routes
-------------------------

```yml
# app/config/routing.yml
hard_faq_cafe_furl:
    resource: "@HardFAQCafeFurlBundle/Resources/config/routing.yml"
    # prefix: 'f' # use prefix to avoid conflicts with app routes
```


Step 5: Configure the bundle
-------------------------

FurlBundle uses gmp functions (http://php.net/manual/en/book.gmp.php) for converting between different number bases.
GMP installation instruction available here: http://php.net/manual/en/gmp.installation.php

The bundle also provides pure php base converter for cases when gmp functions are not available;
If you wish to use pure php base converter, you have to update your config:


```yml
# app/config/config.yml

hard_faq_cafe_furl:
    url_encoder_service_id: 'hard_faq_cafe_furl.phpbase62endec'
```

You also can disable url validation:

```yml
hard_faq_cafe_furl:
    url_validator_service_id: null
```

If you would like to use a different library to url validation and base converting, you may do so by defining
your own services. The services classes must implements HardFAQCafe\FurlBundle\Interfaces\UrlValidatorInterface or
HardFAQCafe\FurlBundle\Interfaces\IntegerEncoderDecoderInterface accordingly

Then you must update your bundle configuration so that FurlBundle will use it. An example is listed below.


```yml
hard_faq_cafe_furl:
    url_validator_service_id: 'app.custom_url_validator_service'
    url_encoder_service_id: 'app.custom_encoder_service'
```