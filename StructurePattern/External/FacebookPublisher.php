<?php

namespace External;

class FacebookPublisher
{
	public function publish(FacebookAdvertisement $advertisement): FacebookAdvertisementResult
	{
		//...

		return (new FacebookAdvertisementResult())->setTargetingName("response");
	}
}