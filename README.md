# Michielfb/Magento2-Vatid
Remove unwanted characters (. , - and spaces) from entered VAT-numbers and remove the country prefix if it matches the entered country of the address.

This is usefull since the VAT-number checker of Magento marks VAT-numbers with a country prefix as invalid.

## Installation
Use composer to install this plug-in:

`composer require michielfb/magento2-vatid`