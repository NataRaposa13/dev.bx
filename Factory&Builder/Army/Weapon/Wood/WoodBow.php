<?php

namespace Army\Weapon\Wood;

use Army\Weapon\Bow;
class WoodBow extends Bow
{
	public function damage(): int
	{
		return parent::damage() + 5;
	}

	public function val(): int
	{
		return parent::val() + 5;
	}
}