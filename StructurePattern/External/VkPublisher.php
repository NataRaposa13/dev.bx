<?php

namespace External;

class VkPublisher
{
	public function publish(VkAdvertisement $advertisement): VkAdvertisementResult
	{
		//...

		return (new VkAdvertisementResult())->setTargetingName("response");
	}
}