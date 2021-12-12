<?php

namespace Service;

use Entity\Advertisement;
use Entity\AdvertisementResponse;

interface AdvertisementProviderInterface
{
	public function publish(Advertisement $advertisement): AdvertisementResponse;
	public function prepare(Advertisement $advertisement);
	public function check(Advertisement $advertisement);
	public function calculateDuration(Advertisement $advertisement);
}