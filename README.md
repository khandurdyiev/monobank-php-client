# Monobank PHP Client

<a href="https://packagist.org/packages/khandurdyiev/monobank-php-client"><img src="https://img.shields.io/packagist/dt/khandurdyiev/monobank-php-client" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/khandurdyiev/monobank-php-client"><img src="https://img.shields.io/packagist/v/khandurdyiev/monobank-php-client" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/khandurdyiev/monobank-php-client"><img src="https://img.shields.io/packagist/l/khandurdyiev/monobank-php-client" alt="License"></a>
<a href="https://packagist.org/packages/khandurdyiev/monobank-php-client"><img src="https://img.shields.io/packagist/php-v/khandurdyiev/monobank-php-client" alt="PHP Version"></a>

Monobank php client helps you to use [Monobank API](https://api.monobank.ua/docs/) easily.

## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Monobank php client.

```bash
$ composer require khandurdyiev/monobank-php-client
```

## Important
*All money amounts in dime (according to Monobank API)*

## Basic Usage (Public Data)
```php
<?php

use Khandurdyiev\MonoClient\MonoClient;

// create a monobank client instance
$mono = new MonoClient();
$currencies = $mono->currency()->all();

foreach ($currencies as $currency) {
    $currencyA = $currency->getCurrencyA(); // USD
    $currencyB = $currency->getCurrencyB(); // UAH
    $date = $currency->getDate(); // returns Carbon instance with date
    // ...
}
```

## Usage with token (Private Data)

```php
<?php

use Carbon\Carbon;
use Khandurdyiev\MonoClient\MonoClient;

// create a monobank client instance
$mono = new MonoClient('your_monobank_api_token'); // you can get from https://api.monobank.ua

// Get client info
$clientInfo = $mono->clientInfo();
$name = $clientInfo->getName();
$accounts = $clientInfo->getAccounts()->all();

foreach ($accounts as $account) {
    $balance = $account->getBalance(); // 123456
    $creditLimit = $account->getCreditLimit(); // 654321
    $currency = $account->getCurrency(); // UAH
    
    // ...
}

// Get statements of concrete account
$from = Carbon::now()->subMonth();
$to = Carbon::now();
$statements = $mono->statements($from, $to, 'account_id')->all();

foreach ($statements as $statement) {
    $amount = $statement->getAmount(); // 123456
    $cashbackAmount = $statement->getCashbackAmount(); // 123456
    $currency = $statement->getCurrency(); // UAH
    // ...
}
```


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.