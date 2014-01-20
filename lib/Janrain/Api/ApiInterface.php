<?php

namespace Janrain\Api;

use Janrain\Client;

/**
 * API Interface
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 */
interface ApiInterface
{
	public function __construct(Client $client);
}
