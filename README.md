<p align="center">
    <a href="https://www.mangoweb.cz/en/" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/38423357?s=200&v=4"/>
    </a>
</p>
<h1 align="center">BulkSMS Plugin</h1>

## Features

* Use https://www.bulksms.com account to send SMS to customers
* Inform your customers with a text message that the package has been sent
* Custom text for every shipping method and language
* Use variables to personalise the text

<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusBulkSMSPlugin/master/doc/admin.png"/>
</p>

## Installation

1. Run `$ composer require mangoweb-sylius/sylius-bulksms-plugin`.
2. Register `\MangoSylius\BulkSmsPlugin\MangoSyliusBulkSmsPlugin` in your Kernel.
3. Import `@MangoSyliusBulkSmsPlugin/Resources/config/resources.yml` in the config.yml.
4. Your Entity `Channel` has to implement `\MangoSylius\BulkSmsPlugin\Model\BulkSmsChannelInterface`. You can use Trait `MangoSylius\BulkSmsPlugin\Model\BulkSmsChannelTrait`.
5. Your Entity `ShippingMethodTranslation` has to implement `\MangoSylius\BulkSmsPlugin\Model\BulkSmsShippingMethodInterface`. You can use Trait `MangoSylius\BulkSmsPlugin\Model\BulkSmsShippingMethodTrait`.
6. Include template `@MangoSyliusBulkSmsPlugin/channelSmsSegmentForm.html.twig` in `@SyliusAdmin/Channel/_form.html.twig`.
6. Include template `@MangoSyliusBulkSmsPlugin/shippingMethodSmsForm.html.twig` in `@SyliusAdmin/ShippingMethod/_form.html.twig`.
For guide to use your own entity see [Sylius docs - Customizing Models](https://docs.sylius.com/en/1.3/customization/model.html)

### Usage

First enter BulkSMS credentials and other parameters in channel settings, then enter SMS text for each shipping method. If the text is blank, no SMS will be sent.

You can use the following variables in the text:

```
{{ orderNumber }}
{{ trackingNumber }}
{{ address.fullName }}
{{ address.company }}
{{ address.street }}
{{ address.postCode }}
{{ address.city }}
{{ address.provinceCode }}
{{ address.provinceName }}
{{ address.countryCode }}
```

<p align="center">
	<img src="https://raw.githubusercontent.com/mangoweb-sylius/SyliusBulkSMSPlugin/master/doc/smstext.png"/>
</p>

## Development

### Usage

- Create symlink from .env.dist to .env or create your own .env file
- Develop your plugin in `/src`
- See `bin/` for useful commands

### Testing

After your changes you must ensure that the tests are still passing.
* Easy Coding Standard
  ```bash
  bin/ecs.sh
  ```
* PHPStan
  ```bash
  bin/phpstan.sh
  ```
License
-------
This library is under the MIT license.

Credits
-------
Developed by [manGoweb](https://www.mangoweb.eu/).
