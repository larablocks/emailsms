https://travis-ci.org/larablocks/emailsms.svg?branch=master

EmailSMS
===============
EmailSMS is a simple package that facilitates sending free text messages from email accounts. Simply pass an object that binds to the interface (EmailSMSInterface) to send a text message to the phone number specified in the object

## Installation

Add `larablocks/emailsms` as a requirement to `composer.json`:

```javascript
{
    "require": {
        "larablocks/emailsms": "5.0.*"
    }
}
```

Note: All Larablocks packages will have versions in line with the laravel framework.

Update your packages with `composer update` or install with `composer install`.

## Laravel Integration

To wire this up in your Laravel project you need to add the service provider. Open `app.php`, and add a new item to the providers array.

```php
'Larablocks\EmailSMS\EmailSMSServiceProvider',
```

Then, add a Facade for more convenient usage. In your `app.php` config file add the following line to the `aliases` array.
Note: The EmailSMS facade will load automatically, so you don't have to add it to the `app.php` file but you may still want to keep record of the alias.

```php
'EmailSMS' => 'Larablocks\EmailSMS\EmailSMS',
```

To publish the default config file `config/emailsms.php` along with the default email view files use the artisan command: 

`vendor:publish --vendor="Larablocks\EmailSMS\EmailSMSServiceProvider"`

If you do not want to publish the view files and only publish the config then use the artisan command:

`vendor:publish --vendor="Larablocks\EmailSMS\EmailSMSServiceProvider" --tag="config"`

## Usage as a Facade to send a text message

####Send Message:
```php
EmailSMS::send($objectThatImplements_EmailSMSInterface);
```

## License

EmailSMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
