<?php namespace Aamant\Distance\Providers;

interface ProviderInterface
{
	public function getDistanceData($address1, $address2);
}