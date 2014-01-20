PHP Janrain API
===============

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

* Api\Engage
* Api\Partner
* Unit tests
* doc
* examples
* Once unit tests are complete put add .travis.yml
* Send to packagist

# Credits

* Nicely architectured library [php-github-api](https://github.com/KnpLabs/php-github-api) by [KNPLabs](https://github.com/KnpLabs) where this library borrows the design.

# License

MIT License - see [LICENSE file](LICENSE).
