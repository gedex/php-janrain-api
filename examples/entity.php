<?php

$posted = false;
if ('POST' === strtoupper($_SERVER['REQUEST_METHOD'])) {
	foreach (array('type_name', 'filter') as $field) {
		if (isset($_POST[$field]) && !empty($_POST[$field])) {
			$posted = true;
		}
	}
}
?>
<html>
	<head>
		<title>Entity find example</title>
		<style>
		dl {border-bottom: 1px solid gray;}
		dt {font-weight: bold;}
		dd {font-size: 80%;}
		#add-new {font-size: 75%; padding-left: 1em;}
		</style>
	</head>
	<body>
		<?php if (!$posted): ?>
		<form method="post">
			<p>
				<label for="type_name">type_name</label>
				<input type="text" name="type_name" id="type_name" value="user">
			</p>
			<p>
				<label for="filter">filter</label>
				<input type="text" name="filter" id="filter" value="email is not null">
			</p>
			<p>
				<label for="sort_on">sort on</label>
				<input type="text" name="sort_on" id="sort_on">
			</p>
			<p>
				<label>attributes</label>
				<ul id="attributes">
					<li><input type="text" name="attributes[]" value="uuid"></li>
					<li><input type="text" name="attributes[]" value="displayName"></li>
					<li><input type="text" name="attributes[]" value="email"></li>
				</ul>
				<a href="#" id="add-new">Add new attribute</a>
			</p>
			<input type="submit">
		</form>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>
		(function($){
			$(function(){
				$('#add-new').on('click', function(e){
					e.preventDefault();
					var $li = $('#attributes li:last').clone();

					$('#attributes').append($li);
				})
			})
		}(jQuery));
		</script>
		<?php else: ?>
			<?php
			require_once '_helper.php';

			$client = getClient();

			$results = $client->api('entity')->find($_POST);
			if (isset($results['results'])) {
				$actions_tpl =
				'
				<dt>actions</dt>
				<dd>
					<a href="entity_view.php?uuid=%s&type_name=%s">view</a> |
					<a href="entity_delete.php?uuid=%s&type_name=%s">delete</a>
				</dd>
				';
				foreach ($results['results'] as $result) {
					echo '<dl>';
					foreach ($result as $key => $val) {
						printf('<dt>%s</dt><dd>%s</dd>', $key, is_array($val) ? sprintf('<pre>%s</pre>', print_r($val, true)) : $val);
					}
					printf($actions_tpl, $result['uuid'], $_POST['type_name'], $result['uuid'], $_POST['type_name']);
					echo '</dl>';
				}
			}
			?>
		<?php endif; ?>
	</body>
</html>
