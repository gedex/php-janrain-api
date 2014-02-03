PHP Janrain API
===============

[![Build Status](https://travis-ci.org/gedex/php-janrain-api.png?branch=master)](https://travis-ci.org/gedex/php-janrain-api)
[![Coverage Status](https://coveralls.io/repos/gedex/php-janrain-api/badge.png?branch=master)](https://coveralls.io/r/gedex/php-janrain-api?branch=master)

A simple Object Oriented wrapper for [Janrain API](http://developers.janrain.com/documentation/api/), written with PHP5.

# Usage

## Find Entity

~~~php
require_once 'vendor/autoload.php';

$client = Janrain\Client();
$client->setOption('base_url',      'https://example.janraincapture.com');
$client->setOption('client_id',     'xxx');
$client->setOption('client_secret', 'xxx');

$entities = $client->api('entity')->find(array(
	'type_name'  => 'user',
	'filter'     => 'emailVerified is not null',
	'attributes' => array('uuid', 'displayName', 'email'),
));
~~~

## Add Entity
~~~php
$result = $client->api('entity')->create(array(
	'type_name'  => 'user',
	'attributes' => array(
		'firstName' => 'Akeda',
		'lastName'  => 'Bagus',
	),
));
~~~

See [doc](doc/README.md) and [examples](examples/README.md) for complete references.

# TODO

* Unit tests
* examples
* Once unit tests are complete put add .travis.yml
* Send to packagist

# Credits

* [Janrain API documentation](http://developers.janrain.com/documentation/api/)
* Nicely architectured library [php-github-api](https://github.com/KnpLabs/php-github-api) by [KNPLabs](https://github.com/KnpLabs) where this library borrows the design.

# License

MIT License - see [LICENSE file](LICENSE).
