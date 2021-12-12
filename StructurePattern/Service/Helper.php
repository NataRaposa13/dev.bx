<?php

namespace Service;

use Entity\Advertisement;

class Helper
{
	public static function runVkAdvertisement(Advertisement $advertisement)
	{
		$vkProvider = new VkProvider((new \Service\Formatting\PlainTextFormatter()));
		$vkProvider->check($advertisement);
		$vkProvider->calculateDuration($advertisement);
		$vkProvider->prepare($advertisement);
		$vkProvider->publish($advertisement);
	}

	public static function runFacebookAdvertisement(Advertisement $advertisement)
	{
		$facebookProvider = new FacebookProvider((new \Service\Formatting\PlainTextFormatter()));
		$facebookProvider->check($advertisement);
		$facebookProvider->calculateDuration($advertisement);
		$facebookProvider->prepare($advertisement);
		$facebookProvider->publish($advertisement);
	}
}