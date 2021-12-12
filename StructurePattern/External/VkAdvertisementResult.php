<?php

namespace External;

class VkAdvertisementResult
{
	public string $targetingName;

	/**
	 * @return string
	 */
	public function getTargetingName(): string
	{
		return $this->targetingName;
	}

	/**
	 * @param string $targetingName
	 * @return VkAdvertisementResult
	 */
	public function setTargetingName(string $targetingName): VkAdvertisementResult
	{
		$this->targetingName = $targetingName;
		return $this;
	}

}