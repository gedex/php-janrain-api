<?php

namespace Janrain\Api\Engage;

use Janrain\Api\AbstractApi;
use Janrain\Exception\MissingArgumentException;

class ConfigureRP extends AbstractApi
{
	/**
	 * Appends domains to the current whitelist for an application.
	 *
	 * @param string $domains A comman separated list of domains that will be used
	 *                        as a whitelist for the website
	 * @param string $format  Either 'json' or 'xml'
	 */
	public function addDomainPatterns($domains, $format = 'json')
	{
		return $this->post('add_domain_patterns', compact('domains', 'format'));
	}

	/**
	 * Returns a list of all domains currently whitelisted for an application.
	 *
	 * @param string $format Either 'json' or 'xml'
	 */
	public function getDomainPatterns($format = 'json')
	{
		return $this->post('get_domain_patterns', compact('format'));
	}

	/**
	 * Replaces the current whitelist for an application.
	 *
	 * @param string $domains A comma separated list of domains used as a whitelist for the
	 *                        website.
	 * @param string $format  Either 'json' or 'xml'
	 */
	public function setDomainPatterns($domains, $format = 'json')
	{
		return $this->post('set_domain_patterns', compact('domains', 'format'));
	}

	/**
	 * Queries Backplane server to verify that Backplane credentials have been set
	 * up. If the proper credentials are in place, details are returned. If not,
	 * no details are returned.
	 *
	 * @param string $format Either 'json' or 'xml'
	 */
	public function getBackplaneProperties($format = 'json')
	{
		return $this->post('get_backplane_properties', compact('format'));
	}

	/**
	 * Configures Backplane server used to communicate with all of the Backplane
	 * enabled widgets on a page.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/configure-rp/set_backplane_properties/
	 */
	public function setBackplaneProperties(array $params)
	{
		if (!isset($params['server'])) {
			throw new MissingArgumentException('server');
		}

		if (!isset($params['bus'])) {
			throw new MissingArgumentException('bus');
		}

		return $this->post('set_backplane_properties', $params);
	}

	/**
	 * Returns the variables needed for Engage interaction using only the API key.
	 *
	 * @param array $params
	 *
	 * @link http://developers.janrain.com/documentation/api-methods/engage/configure-rp/lookup_rp/
	 */
	public function lookupRP(array $params)
	{
		return $this->post('lookup_rp', $params);
	}
}
