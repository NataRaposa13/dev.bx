<?php

namespace Army\Weapon\Wood;

use Army\Weapon\Knife;
class WoodKnife extends Knife
{
	public function damage(): int
	{
		return parent::damage() + 5;
	}

	public function val(): int
	{
		return parent::val() + 10;
	}
}