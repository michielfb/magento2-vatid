# Michielfb/Magento2-Vatid
Remove unwanted characters (. , - and spaces) from EU VAT-numbers and remove the country prefix if it matches the entered country of the address.

This is usefull since the VAT-number checker of Magento marks VAT-numbers with a country prefix as invalid.

## Installation
Use composer to install this plug-in:

`composer require michielfb/magento2-vatid`

## Example
On a address a VAT-number is entered as NL123456789B01 combined with the country NL. By default Magento will mark this as invalid.

When this plug-in is used the country prefix will be stripped from the VAT-number resulting in the VAT-number 123456789B01. Magento will mark this VAT-number as valid\*.

\* please note that the VAT-number is an example. VAT-numbers will only be marked as valid if they actually exists.
