<?php

namespace Adapter;

use Entity\Advertisement;
use Entity\AdvertisementResponse;
use External\FacebookAdvertisement;
use External\FacebookPublisher;
use Service\AdvertisementProviderInterface;

class FacebookAdvertisementProviderAdapter implements AdvertisementProviderInterface
{

	public function publish(Advertisement $advertisement): AdvertisementResponse
	{
		$facebookAdvertisement = new FacebookAdvertisement();

		if (!$advertisement->getTitle())
		{
			$advertisement->setTitle("default");
		}
		$facebookAdvertisement
			->setTitle($advertisement->getTitle())
			->setMessageBody($advertisement->getBody());

		$result = (new FacebookPublisher())->publish($facebookAdvertisement);

		return (new AdvertisementResponse())->setTargeting($result->getTargetingName());
	}

	public function prepare(Advertisement $advertisement)
	{
		// TODO: Implement prepare() method.
	}

	public function check(Advertisement $advertisement)
	{
		// TODO: Implement check() method.
	}

	public function calculateDuration(Advertisement $advertisement)
	{
		// TODO: Implement calculateDuration() method.
	}
}