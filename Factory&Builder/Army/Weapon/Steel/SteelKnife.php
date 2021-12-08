<?php

namespace Army\Weapon\Steel;

use Army\Weapon\Knife;
class SteelKnife extends Knife
{
	public function damage(): int
	{
		return parent::damage() + 25;
	}

	public function val(): int
	{
		return parent::val() + 40;
	}
}