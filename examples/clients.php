<?php

require_once '_helper.php';

$client = getClient();
apiCRUD($client, 'client_id', array(

	'add' => function($client) {
		$params = array(
			'description' => 'Dummy client',
		);
		$resp = $client->api('clients')->add($params);
		if ('ok' !== $resp['stat']) {
 			printf('<pre>%s</pre>', print_r($resp, true));
 		} else {
 			header('Location: ?action=list');
 		}
	},

	'update' => function($id, $client) {
		// There's no update, but there are set_description and set_features.
		$resp = $client->api('clients')->setDescription($id, 'Description updated');
		if ('ok' !== $resp['stat']) {
			printf('<pre>%s</pre>', print_r($resp, true)); die;
		}
		$resp = $client->api('clients')->setFeatures($id, array('access_issuer', 'image_create'));
		if ('ok' !== $resp['stat']) {
			printf('<pre>%s</pre>', print_r($resp, true)); die;
		}
		header('Location: ?action=list');
	},

	'view' => function($id, $client) {
		// Capture Clients API doesn't have find/show to retrieve a single client information.
		$results = $client->api('clients')->all();
		foreach ($results['results'] as $result) {
			if ($result['client_id'] === $id)	{
				printf('<pre>%s</pre>', print_r($result, true));
				break;
			}
		}
	},

	'delete' => function($id, $client) {
		$resp = $client->api('clients')->delete($id);
		if ('ok' === $resp['stat']) {
			header('Location: ?action=list');
		}
		printf('<pre>%s</pre>', print_r($resp, true));
	},

	'list' => function($primaryId, $client) {
		$list_renderer = function($clients) use($primaryId){
			if (!isset($clients['results'])) {
				return '';
			}
			if (empty($clients['results'])) {
				return '';
			}
			$list       = '';
			$action_tpl = str_replace('{primaryId}', $primaryId,
			'
			<a href="?{primaryId}=%s&action=view">view</a> |
			<a href="?{primaryId}=%s&action=update">update</a> |
			<a href="?{primaryId}=%s&action=delete">delete</a>
			'
			);
			foreach($clients['results'] as $result) {
				$list .= sprintf('<li><p>%s<br><strong>%s</strong></p> %s</li>', $result['description'], $result['client_id'], sprintf($action_tpl, $result[$primaryId], $result[$primaryId], $result[$primaryId]));
			}
			return $list;
		};
		$results = $client->api('clients')->all();
		printf('<ul>%s</ul>', $list_renderer($results)?: 'Empty. <a href="?action=add">Add one</a>.');
	}
));
