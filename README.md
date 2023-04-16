# Interakt PHP SDK (Unofficial)

[Interakt](https://www.interakt.shop/) PHP SDK. Read their [docs](https://www.interakt.shop/resource-center) for more information.

## Installation

Run [composer](http://getcomposer.org)

```bash
composer require agyson/interakt-php-sdk
```

## Usage

### Getting API Key (Authentication)
Inside your app, you’ll want to set your `api_key` before making any track calls:

To find your API key,

- go to your interakt account's Settings --> Developer Settings

- copy the Secret Key.

- Use this key

### Standalone usage

Make sure you already have Interakt Account and API Key

```php
require 'vendor/autoload.php';

use Agyson\InteraktPhpSdk\Interakt;

$sms = new Interakt(env('api_key'));

// Get All Users
$interakt->get_users(
      $offset = 0,
      $limit = 100,
      $filter_start_date = "2010-01-01",
      $filter_end_date = "2023-01-01"
);

// Creating & Updating Users
$interakt->track_user(
      $userId = null,
      $fullPhoneNumber = null,
      $phoneNumber = null,
      $countryCode = null,
      $traits = [],
      $tags = []
);

// Assign Events to Specific Users
$interakt->track_event(
     $userId = null,
     $fullPhoneNumber = null,
     $phoneNumber = null,
     $countryCode = null,
     $event = null,
     $traits = []
);

// Send Message Templates
$interakt->send_template(
    $fullPhoneNumber = null,
    $phoneNumber = null, 
    $countryCode = null,
    $callbackData = null,
    $templateName = null,
    $templateLanguageCode = null
    $headerValues = [],
    $bodyValues = [],
    $buttonValues = [],
);

```

Read their [Postman API Documentation](https://documenter.getpostman.com/view/14760594/UVeCRUdm) for more detailed information on using the API.

## License

MIT © [Agy Nurwicaksono](https://www.agyson.com)
