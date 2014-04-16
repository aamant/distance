<?php namespace Aamant\Distance;

use Aamant\Distance\Providers\ProviderInterface;

class Distance implements DistanceInterface
{
	/**
	 *
	 * @var Aamant\Distance\Providers\ProviderInterface
	 */
	protected $provider = null;

	public function __construct(ProviderInterface $provider)
	{
		$this->provider = $provider;
	}

	public function getProvider()
	{
		return $this->provider;
	}

	public function distance($address1, $address2)
	{
		return $this->getProvider()->getDistanceData($address1, $address2);
	}
}