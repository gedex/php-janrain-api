<?php

require_once '_helper.php';

$client = getClient();

$params = array(
	'type_name'  => (isset($_REQUEST['type_name'])) ? $_REQUEST['type_name'] : 'user',
	'attributes' => array(
		'familyName' => 'Smith',
		'givenName'  => 'Bob',
		'email'      => 'bob.smith@example.com',
	),
);
$entity = $client->api('entity')->create($params);

printf('<pre>%s</pre>', print_r($entity, true));
