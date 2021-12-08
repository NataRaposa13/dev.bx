<?php

namespace Army\Weapon\Wood;

use Army\Weapon\AbstractArmory;
use Army\Weapon\Knife;
use Army\Weapon\Bow;
class WoodWeaponArmory
{
	public function createKnife(): Knife
	{
		return new WoodKnife();
	}

	public function createBow(): Bow
	{
		return new WoodBow();
	}
}