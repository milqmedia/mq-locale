mq-locale
=========

[![Build Status](https://travis-ci.org/milqmedia/mq-locale.svg?branch=master)](https://travis-ci.org/milqmedia/mq-locale)

A slimmed down version of a [SlmLocal](https://github.com/juriansluiman/SlmLocale) fork.

Introduction
------------
MQLocale is a Zend Framework 2 module to automatically detect a locale for your
application. It uses a variety of pluggable strategies to search for a valid
locale. MQLocale features a default locale, a set of supported locales and
locale aliases.

MQLocale supports out of the box several strategies to search for a locale.
Through interfaces, other strategies could be created. The set of default
strategy is:

 1. A part of the domain name (either the TLD or a subdomain)
 2. The first segment of the path of an uri
 
Furthermore, it provides a set of additional localisation features:

 1. A default locale, used as fallback
 2. A set of aliases, so you can map `.com` as "en-US" in the hostname strategy
 3. View helper and controller plugin to retrieve the current language 
 4. Doctrine Language entity to provide a reusable language object in projects 
 
Installation
---
Add "milqmedia/mq-locale" to your composer.json file and update your dependencies. Enable MQLocale in your `application.config.php`.

If you do not have a composer.json file in the root of your project, copy the
contents below and put that into a file called `composer.json` and save it in
the root of your project:

```
{
    "require": {
        "milqmedia/mq-locale": "dev-master"
    }
}
```

Then execute the following commands in a CLI:

```
curl -s http://getcomposer.org/installer | php
php composer.phar install
```

Now you should have a `vendor` directory, including a `milqmedia/mq-locale`. In your
bootstrap code, make sure you include the `vendor/autoload.php` file to properly
load the MQLocale module.

Usage
---
Set your default locale in the configuration:

```
'mq_locale' => array(
    'default' => 'nl-NL',
),
```

Set all your supported locales in the configuration:

```
'mq_locale' => array(
    'supported' => array('en-US', 'en-GB'),
),
```

And enable a strategy. The naming is made via the following list:

 * **host**: `MQLocale\Strategy\HostStrategy`
 * **url**: `MQLocale\Strategy\UrlStrategy`

```
'mq_locale' => array(
    'strategy' => 'host'
),
```

At this moment, the locale should be detected. The locale is stored inside php's
`Locale` object. Retrieve the locale with `Locale::getDefault()`. This is also
automated inside Zend Framework 2 translator objects and i18n view helpers (so
you do not need to set the locale yourself there).

### Set the locale's language in html
It is common to provide the html with the used locale. This can be set for example
in the `html` tag:

```
<html lang="en">
```

Inject the detected language here with the following code:

```
<html lang="<?= Locale::getPrimaryLanguage(Locale::getDefault())?>">
```

### Use the view helper or controller plugin

```
$locale = $this->parseDefaultLanguage();
echo $locale; #nl-NL

$language = $this->getCurrentLanguage(); // Returns a Application\Entity\Language object
echo $language->getDescription(); // Dutch
```

## Contributing

1. Fork it ( https://github.com/milqmedia/mq-locale/fork )
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create a new Pull Request
