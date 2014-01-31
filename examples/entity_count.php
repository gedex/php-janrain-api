<?php

require_once '_helper.php';

$client   = getClient();
$entities = $client->api('entity')->count(
	(isset($_REQUEST['type_name'])) ? $_REQUEST['type_name'] : 'user',
	(isset($_REQUEST['filter'])) ? $_REQUEST['filter'] : 'email is not null'
);

printf('<pre>%s</pre>', print_r($entities, true));
