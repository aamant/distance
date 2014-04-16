Distance
========

Calculating the distance between differents points

Installation
------------

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "aamant/distance": "@stable"
    }
}
```

Usage
-----

``` php
	$distance = new Distance(new GoogleMapProvider(new CurlHttpAdapter, 'fr-FR', GoogleMapProvider::MODE_BICYCLING));
	$result = $distance->distance(array('montpellier'), array('paris', 'perpignan', 'lyon'));
```
