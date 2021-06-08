# VAULT/ShipmentCourier

Class wrapper for various shipment couriers, e.g. Aramex, The Courier Guys, etc.

# INSTALLATION and SETUP:

Create a packages folder in the root of your laravel project directory, followed by creating a vault directory:
~/packages/vault

Clone this repository into shipment_courier directory as follows:
git clone https://github.com/gmlrie001/shipment_courier.git shipment_courier

Once done append to your projects main composer.json file with the following:
"repositories": [
  {
    "type": "path",
    "url": "packages/vault/shipment_courier"
  }
}

Finally, run the following composer command to install the package:
composer require vault/shipment_courier -o --profile -vvv

_OR_

{php_versioned} composer.phar require vault/shipment_courier -o --profile -vvv

# USAGE:

  ### Client-side

  ### Server-side
