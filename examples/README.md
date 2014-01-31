Examples
========

These examples are runnable through web browser.

# Setup

1. Copy `_client.php.dist` to `_client.php` and adjust your settings in `_client.php`.
2. Install dependencies: `composer install`.

# Examples

Assuming these examples accessible via http://my.dev/php-janrain-api/examples/

## Capture

### Clients

* Opening http://my.dev/php-janrain-api/examples/clients.php will list all your clients.
  Each client has action links to view, update, and delete. Clicking on update link will
  update the description with 'Description updated'.
* Opening http://my.dev/php-janrain-api/examples/clients.php?action=add will create a client
  with description 'Dummy client'.

### Entity

* Opening http://my.dev/php-janrain-api/examples/entity.php will present you a form to find
  entities. Submitting will finding entities match with passed filter. Each entity will have
  view and delete links.
* Opening http://my.dev/php-janrain-api/examples/entity_add.php will create a new entity
  with:
  ```
  familyName: Smith
  givenName: Bob
  email: bob.smith@example.com
  ```
* Opening http://my.dev/php-janrain-api/examples/entity_bulk_create.php will create two
  entities:
  ```
  familyName: Test
  givenName: First
  email: test.first@example.com

  familyName: Test
  givenName: Second
  email: test.second@example.com
  ```
* Opening http://my.dev/php-janrain-api/examples/entity_count.php will return the number
  of records in given `type_name` (default to 'user'). You can pass query string 'filter'
  and/or 'type_name', for instance `?type_name=user&filter=displayName is not null`.
* Opening http://my.dev/php-janrain-api/examples/entity_bulk_delete.php will delete two
  entities created by http://my.dev/php-janrain-api/examples/entity_bulk_create.php.

### Webhooks

* Opening

## Engage

TODO

### Configure RP

TODO

### Legacy Sharing

TODO

### Mapping

TODO

### Sharing

TODO

## Partner

TODO

### Admin

TODO

### App

TODO
