# Nova Server Metrics

## Includes a card to display your server metrics

- Please note this package currently only supports Linux

[![Latest Version on Packagist](https://img.shields.io/packagist/v/llaski/nova-server-metrics.svg?style=flat-square)](https://packagist.org/packages/llaski/nova-server-metrics)
[![Total Downloads](https://img.shields.io/packagist/dt/llaski/nova-server-metrics.svg?style=flat-square)](https://packagist.org/packages/llaski/nova-server-metrics)

![Nova Scheduled Jobs Card Screenshot](https://raw.githubusercontent.com/llaski/screenshots/master/nova-server-metrics-card.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require llaski/nova-server-metrics
```

To setup the card, you must register the card with Nova. This is typically done in the `cards` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function cards()
{
    return [
        // ...
        new \Llaski\NovaServerMetrics\Card,
    ];
}
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email larry.laski@gmail.com instead of using the issue tracker.

## Credits

- [Larry Laski](https://github.com/llaski)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
