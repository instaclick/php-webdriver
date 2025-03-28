# W3C WebDriver Client

This "classic" W3C WebDriver client implementation is based on the
[php-webdriver](https://github.com/instaclick/php-webdriver/tree/upstream)
project by Justin Bishop. Originally conceived as a thin wrapper around the
JSON Wire Protocol, the client has been refactored to work with the W3C
WebDriver Protocol, with some fallback/emulation for older drivers. We'll
continue to track changes to the specs but there are no immediate plans to add
WebDriver-BiDi support.

If you are starting a new project (using PHP 7.3 or above), you should
consider using Meta/Facebook's completely rewritten (and more actively
maintained)
[php-webdriver](https://github.com/php-webdriver/php-webdriver).

### Distinguishing features:

* Up-to-date with:
  * [WebDriver: W3C Working Draft 13 December 2023](https://www.w3.org/TR/webdriver2)
  * [Federated Credential Management API: Editor's Draft, 25 March 2025](https://w3c-fedid.github.io/FedCM/)
  * [Web Authentication: An API for accessing Public Key Credentials, Level 2: W3C Recommendation, 8 April 2021](https://www.w3.org/TR/webauthn-2/)
* In the *master* branch, class names and file organization follow PSR-0
  conventions for namespaces.
* Coding style follows PSR-1, PSR-2, and Symfony2 conventions.

[![Latest Stable Version](https://poser.pugx.org/instaclick/php-webdriver/v/stable.png)](https://packagist.org/packages/instaclick/php-webdriver)
[![Total Downloads](https://poser.pugx.org/instaclick/php-webdriver/downloads.png)](https://packagist.org/packages/instaclick/php-webdriver)

## Links

* [Packagist](http://packagist.org/packages/instaclick/php-webdriver)
* [Github](https://github.com/instaclick/php-webdriver)
* [W3C/WebDriver](https://github.com/w3c/webdriver)

## Notes

* The *1.x* branch is up-to-date with the legacy
  [Selenium 2 JSON Wire Protocol](https://www.selenium.dev/documentation/legacy/json_wire_protocol/).
* The *5.2.x* branch is no longer maintained. This branch features class
  names and file re-organization that follow PEAR/ZF1 conventions. Bug fixes
  and enhancements from the master branch likely won't be backported.
