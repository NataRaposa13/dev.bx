<?php

namespace Adapter;

use Entity\Advertisement;
use Entity\AdvertisementResponse;
use External\VkAdvertisement;
use External\VkPublisher;
use Service\AdvertisementProviderInterface;

class VkAdvertisementProviderAdapter implements AdvertisementProviderInterface
{

	public function publish(Advertisement $advertisement): AdvertisementResponse
	{
		$vkAdvertisement = new VkAdvertisement();

		if (!$advertisement->getTitle())
		{
			$advertisement->setTitle("default");
		}
		$vkAdvertisement
			->setTitle($advertisement->getTitle())
			->setMessageBody($advertisement->getBody());

		$result = (new VkPublisher())->publish($vkAdvertisement);

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