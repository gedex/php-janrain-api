<?php

if (!isset($_REQUEST['uuid']) || !isset($_REQUEST['type_name'])) {
	header('Location: entity.php');
}

require_once '_helper.php';

$client = getClient();
$entity = $client->api('entity')->delete($_REQUEST['uuid'], array('type_name' => $_REQUEST['type_name']));

printf('<pre>%s</pre>', print_r($entity, true));
