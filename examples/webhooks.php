<?php

require_once '_helper.php';

$client = getClient();
apiCRUD($client, 'uuid', array(

	'add' => function($client) {
		$params = array(
			'callback'    => sprintf('%s%s', $_SERVER['HTTP_HOST'], $_SERVER['PHP_SELF']),
			'event_type'  => 'add',
			'entity_type' => 'user',
		);
		$resp = $client->api('webhooks')->add($params);
		if ('ok' !== $resp['stat']) {
 			printf('<pre>%s</pre>', print_r($resp, true));
 		} else {
 			header('Location: ?action=list');
 		}
	},

	'update' => function($id, $client) {
		$params = array(
			'callback' => sprintf('%s%s', $_SERVER['HTTP_HOST'], $_SERVER['PHP_SELF'])
		);
		$resp = $client->api('webhooks')->update($id, $params);
		if ('ok' === $resp['stat']) {
			header('Location: ?action=list');
		}
		printf('<pre>%s</pre>', print_r($resp, true));
	},

	'view' => function($id, $client) {
		$resp = $client->api('webhooks')->find($id);
		printf('<pre>%s</pre>', print_r($resp, true));
	},

	'delete' => function($id, $client) {
		$resp = $client->api('webhooks')->delete($id);
		if ('ok' === $resp['stat']) {
			header('Location: ?action=list');
		}
		printf('<pre>%s</pre>', print_r($resp, true));
	},

	'list' => function($primaryId, $client) {
		$list_renderer = function($webhooks) use($primaryId){
			if (!isset($webhooks['webhooks'])) {
				return '';
			}
			if (empty($webhooks['webhooks'])) {
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
			foreach($webhooks['webhooks'] as $webhook) {
				$list .= sprintf('<li><strong>%s</strong> %s</li>', $webhook['callback_hash'], sprintf($action_tpl, $webhook[$primaryId], $webhook[$primaryId], $webhook[$primaryId]));
			}
			return $list;
		};
		$webhooks = $client->api('webhooks')->getList();
		printf('<ul>%s</ul>', $list_renderer($webhooks)?: 'Empty. <a href="?action=add">Add one</a>.');
	}
));
