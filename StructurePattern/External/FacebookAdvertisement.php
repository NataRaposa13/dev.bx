<?php

namespace External;

class FacebookAdvertisement
{
	private string $title;
	private string $messageBody;

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return FacebookAdvertisement
	 */
	public function setTitle(string $title): FacebookAdvertisement
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMessageBody(): string
	{
		return $this->messageBody;
	}

	/**
	 * @param string $messageBody
	 * @return FacebookAdvertisement
	 */
	public function setMessageBody(string $messageBody): FacebookAdvertisement
	{
		$this->messageBody = $messageBody;
		return $this;
	}
}