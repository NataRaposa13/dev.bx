<?php

namespace App\Operation;

class Settings
{
	protected $isBeforeActionsEnabled = true;

	public function disableBeforeSaveActions(): self
	{
		$this->isBeforeActionsEnabled = false;

		return $this;
	}

	public function isBeforeActionsEnabled(): bool
	{
		return $this->isBeforeActionsEnabled;
	}
}