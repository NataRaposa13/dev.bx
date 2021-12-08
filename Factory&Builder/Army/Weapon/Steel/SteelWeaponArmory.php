<?php

namespace Army\Weapon\Steel;

use Army\Weapon\AbstractArmory;
use Army\Weapon\Knife;
class SteelWeaponArmory
{
	public function createKnife(): Knife
	{
		return new SteelKnife();
	}
}