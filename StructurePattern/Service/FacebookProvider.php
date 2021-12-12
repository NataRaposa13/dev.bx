<?php

namespace Service;

use Adapter\FacebookAdvertisementProviderAdapter;
use Entity\Advertisement;
use Entity\AdvertisementResponse;

class FacebookProvider extends AbstractAdvertisementProvider
{

	public function publish(Advertisement $advertisement): AdvertisementResponse
	{
		$advertisement->setBody($this->formatter->format($advertisement->getBody()));
		echo $advertisement->getBody();
		return (new FacebookAdvertisementProviderAdapter())->publish($advertisement);
	}

	public function prepare(Advertisement $advertisement)
	{
		if (!$advertisement->getTitle())
		{
			$advertisement->setTitle("welcome");
		}
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