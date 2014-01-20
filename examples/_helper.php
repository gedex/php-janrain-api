<?php

/**
 * Get Client.
 *
 * @return Client Client Instance
 */
function getClient() {
	return require_once '_client.php';
}

/**
 * Common CRUD (create, read, update, and delete) actions to API.
 *
 * @param  Client $client    Client instance
 * @param  string $primaryId Primary ID (usually 'uuid')
 * @return void
 */
function apiCRUD($client, $primaryId = 'uuid', array $actions = array()) {
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'list';
	if (!in_array($action, array('list', 'view', 'delete', 'add', 'update'))) {
		$action = 'list';
	}

	switch ($action) {
		case 'add':
			$actions['add']($client);
			break;
		case 'view':
			$id = isset($_REQUEST[$primaryId]) ? $_REQUEST[$primaryId] : '';
			if (!$id) {
				header('Location: ?action=list');
			}
			$action_tpl = str_replace('{primaryId}', $primaryId,
			'
			<a href="?{primaryId}=%s&action=update">update</a> |
			<a href="?{primaryId}=%s&action=delete">delete</a> |
			<a href="?action=list">back to list</a>
			'
			);

			$actions['view']($id, $client);

			printf($action_tpl, $id, $id);
			break;
		case 'update':
			$id = isset($_REQUEST[$primaryId]) ? $_REQUEST[$primaryId] : '';
			if (!$id) {
				header('Location: ?action=list');
			}

			$actions['update']($id, $client);

			break;
		case 'delete':
			$id = isset($_REQUEST[$primaryId]) ? $_REQUEST[$primaryId] : '';
			if (!$id) {
				header('Location: ?action=list');
			}

			$actions['delete']($id, $client);

			break;
		case 'list':
		default:
			$actions['list']($primaryId, $client);
	}
}
