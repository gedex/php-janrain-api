<?php

require_once '_helper.php';

$client = getClient();

$params = array(
	'type_name'  => (isset($_REQUEST['type_name'])) ? $_REQUEST['type_name'] : 'user',
	'filter'     => (isset($_REQUEST['filter'])) ? $_REQUEST['filter'] : "email='test.first@example.com' or email='test.second@example.com'",
	'commit'     => 'true',
);
$result = $client->api('entity')->bulkDelete($params);

printf('<pre>%s</pre>', print_r($result, true));
