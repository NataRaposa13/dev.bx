<?php

namespace External;

class FacebookAdvertisementResult
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
	 * @return FacebookAdvertisementResult
	 */
	public function setTargetingName(string $targetingName): FacebookAdvertisementResult
	{
		$this->targetingName = $targetingName;
		return $this;
	}
}