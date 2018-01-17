# Laravel 5 Conversations

## Contents

- [Installation](#installation)
- [Configuration](#configuration)
    - [Swapping models](#overriding_models)
    - [Swapping invitation code](#swapping_invitation_code)
- [Usage](#usage)
- [Testing](#testing)
- [Events](#events)
- [Issues](#issues)
- [License](#license)

<a name="installation" />

## Installation

## For Laravel ~5

    composer require sasin91/laravel-conversations

As with any package, it's a good idea to refresh composer autoloader.
```bash
composer dump-autoload
```

<a name="configuration"/>

## Configuration

To publish `conversable.php` config file, run the following, `vendor:publish` command.

```bash
php artisan vendor:publish --provider="\Sasin91\LaravelConversations\ConversableServiceProvider"
```

You may configure the config file to your liking, however the defaults should work for most cases.

<a name="overriding_models" />

### Overriding models
You can override the default models permanently in the published config file.
Temporarily by setting the config value at runtime. 
```php
    config()->set('conversable.models.user', User::class);
```
additionally, as a convenience there are also config objects available,
taking models as example:
```php
    \Sasin91\LaravelConversations\Config\Models::swap('user', User::class);
```

<a name="swapping_invitation_code" />

### Swapping the InvitationCode
You may rebind the concrete of the InvitationCode in your service provider.
```php
    $this->app->singleton(\Sasin91\LaravelConversations\InvitationCode::class, Concrete::class);
```
as a convenience, the contract defines __invoke method to be defined,
which means it's possible to use a \Closure for the implementation.

<a name="policy_filters" />

### Policy filters
You may register global within scope of this package policy callbacks in your service provider,
```php
\Sasin91\LaravelConversations\Config\Policies::before(function ($user, $ability) {
    // return boolean
});

\Sasin91\LaravelConversations\Config\Policies::after(function ($user, $ability) {
    // return boolean
});
```

**And you are ready to go.**

<a name="usage" />

## Usage
This package provides the Eloquent portion plus some policies of a Conversations implementation.

<a name="events" />

## Events
The common eloquent events are available as usual.

Additionally, when an invitation is accepted & declined the following events are dispatched.
```php
		'accepted' => 'Sasin91\LaravelConversations\Events\InvitationAccepted',
		'declined' => 'Sasin91\LaravelConversations\Events\InvitationDeclined'
```
<a name="issues" />

## Issues 

If you discover any vulnerabilities, please e-mail them to me at jonas.kerwin.hansen@gmail.com.

For issues, open a issue on Github.

I'm currently aware of issues with proxy-driver-commands and testing.

<a name="license" />

## License

laravel-conversations is free software distributed under the terms of the MIT license.