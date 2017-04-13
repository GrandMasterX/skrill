# PHP5 package for Skrill QuickCheckout interface

[![Latest Stable Version](https://poser.pugx.org/grandmasterx/php-skrill-quick-checkout/v/stable)](https://packagist.org/packages/grandmasterx/php-skrill-quick-checkout)
[![Total Downloads](https://poser.pugx.org/grandmasterx/php-skrill-quick-checkout/downloads)](https://packagist.org/packages/grandmasterx/php-skrill-quick-checkout)
[![License](https://poser.pugx.org/grandmasterx/php-skrill-quick-checkout/license)](https://packagist.org/packages/grandmasterx/php-skrill-quick-checkout)

Simple and useful PHP5 library to make payments via Skrill QuickCheckout interface

Containing:
- Payment model with each parameter description
- Payment form generator based on payment model
- Skrill status response model with signature verifier
- [Ips for whitelist](#IpsForWhitelist)

### Installation

Add to your composer.json

```
"require": {
    "grandmasterx/skrill": "*"
}
```

And run

```sh
$ composer update
```

### Usage

```php
use grandmasterx\Skrill\Models\QuickCheckout;

$quickCheckout = new QuickCheckout([
    'pay_to_email' => 'mymoneybank@mail.com',
    'amount' => 100500,
    'currency' => 'EUR'
]);

/*
You can also use setters to bind parameters to model
If you want to see all list of parameters just open QuickCheckout file
Each class attribute has description
*/
$quickCheckout->setReturnUrl('https://my-domain.com');
$quickCheckout->setReturnUrlTarget(QuickCheckout::URL_TARGET_BLANK);
```

Build and render form

```php
use grandmasterx\Skrill\Models\QuickCheckoutForm;

$form = new QuickCheckoutForm($quickCheckout);

echo $form->open([
    'class' => 'skrill-form'
]);

/*
By default all fields will be rendered as hidden inputs
If you need to render some field as visible (i.e. amount of payment) you should specify it in $exclude
Excluded fields will not be rendered at all - you should render them by yourself
*/
$exclude = ['amount'];
echo $form->renderHidden($exclude);
<input type="text" name="amount"> .....
echo $form->renderSubmit('Pay', ['class' => 'btn']);
echo $form->close();
```

In your status_url listener:

```php
use grandmasterx\Skrill\Models\SkrillStatusResponse;
use grandmasterx\Skrill\Components\SkrillException;

try {
    $response = new SkrillStatusResponse($_POST);
} catch (SkrillException $e) {
    # something bad in request
}

/*
SkrillStatusResponse model contains attributes only for required Skrill response parameters
To get all of them use:
*/
$allParams = $response->getRaw();

if ($response->verifySignature('your Skrill secret word') && $response->isProcessed()) {
    # bingo! You need to return anything with 200 OK code! Otherwise, Skrill will retry request
}

# Or:

if ($response->isFailed()) {
    # Note that you should enable receiving failure code in Skrill account before
    # It will not provided with default settings
    $errorCode = $response->getFailedReasonCode();
}

/*
Also you can retrieve any Skrill response parameter and make extra validation you want.
To see all Skrill response parameters just view SkrillStatusResponse class attributes
For example:
*/
if ($response->getPayToEmail() !== 'mymoneybank@mail.com') {
    // hum, it's very strange ...
}

/* Also you can log Skrill response data using simple built-in logger */
$response->log('/path/to/writable/file');
```

### Information

- Based on Skrill API version - **7.4**
- [Skrill QuickCheckout documentation](https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf)
- Skrill test merchant email: **demoqco@sun-fish.com**
- Skrill test card numbers: VISA: **4000001234567890** | MASTERCARD: **5438311234567890** | AMEX: **371234500012340**

- demoqco@sun-fish.com mqi: skrill123, secretword: skrill Fixed Payment Options (Fixed
Split Gateway)
- demoqcoflexible@sun-fish.com mqi: skrill123, secretword: skrill Flexible Payment Options
(Flexible Split Gateway)
- demoqcofixedhh@sun-fish.com mqi: skrill123, secretword: skrill Fixed Payment Options (Fixed
Split Gateway) with Reduced
header option enabled.


Ips for whitelist <a name="IpsForWhitelist"></a>
------------------------------------------------


### IP Range:

- 91.208.28.0/24
- 93.191.174.0/24
- 193.105.47.0/24
- 195.69.173.0/24

- 91.208.28.0/24,  91.208.28.5,  91.208.28.6,  91.208.28.7,  91.208.28.8,  91.208.28.9
- 93.191.174.4, 93.191.174.5, 93.191.174.6, 93.191.174.7, 93.191.174.8, 93.191.174.9
- 193.105.47.4, 193.105.47.5, 193.105.47.6, 193.105.47.7, 193.105.47.8, 193.105.47.9 93.191.174.15 93.191.174.16 195.69.173.0/24

Supported ports:

- 80, 81, 82, 83, 88, 90, 178, 419, 433, 443, 444, 448, 451, 666, 800, 888,
1025, 1430, 1680, 1888, 1916, 1985, 2006, 2221, 3000, 4111, 4121, 4423,
4440, 4441, 4442, 4443, 4450, 4451, 4455, 4567, 5443, 5507, 5653, 5654,
5656, 5678, 6500, 7000, 7001, 7022, 7102, 7777, 7878, 8000, 8001, 8002,
8011, 8014, 8015, 8016, 8027, 8070, 8080, 8081, 8082, 8085, 8086, 8088,
8090, 8097, 8180, 8181, 8443, 8449, 8680, 8843, 8888, 8989, 9006, 9088,
9443, 9797, 10088, 10443, 12312, 18049, 18079, 18080, 18090, 18443,
20202, 20600, 20601, 20603, 20607, 20611, 21301, 22240, 26004, 27040,
28080, 30080, 37208, 37906, 40002, 40005, 40080, 50001, 60080, 60443
