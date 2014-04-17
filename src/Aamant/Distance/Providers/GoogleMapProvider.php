<?php namespace Aamant\Distance\Providers;

use Aamant\Distance\Providers\ProviderInterface;
use Geocoder\HttpAdapter\HttpAdapterInterface;

class GoogleMapProvider implements ProviderInterface
{
	const END_POINT_URL = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins=%s&destinations=%s&mode=%s&language=%s&sensor=false';
	const MODE_DRIVING = 'driving';
	const MODE_WALKING = 'walking';
	const MODE_BICYCLING = 'bicycling';

	/**
	 *
	 * @var Geocoder\HttpAdapter\HttpAdapterInterface
	 */
	protected $adapter = null;

	protected $language = null;
	protected $mode = null;

	public function __construct(HttpAdapterInterface $adapter, $language = "fr-FR", $mode = self::MODE_WALKING)
	{
		$this->adapter = $adapter;
		$this->language = $language;
		$this->mode = $mode;
	}

	public function getAdapter()
	{
		return $this->adapter;
	}

	public function getDistanceData($address1, $address2)
	{
		if (is_array($address1)){
			foreach ($address1 as $key => $value) $address1[$key] = rawurlencode($value);
			$address1 = implode('|', $address1);
		} else {
			$address1 = rawurlencode($address1);
		}

		if (is_array($address2)){
			foreach ($address2 as $key => $value) $address2[$key] = rawurlencode($value);
			$address2 = implode('|', $address2);
		} else {
			$address2 = rawurlencode($address2);
		}

		$query = sprintf(self::END_POINT_URL,
			$address1,
			$address2,
			$this->mode,
			$this->language
		);

		$raw = $this->getAdapter()->getContent($query);
		$content = json_decode($raw);

		switch ($content->status) {
			case 'OK':
				return $content->rows;
				break;
			case 'OVER_QUERY_LIMIT':
				throw new QueryLimitException($content->error_message, 10);
		}

		return false;
	}
}