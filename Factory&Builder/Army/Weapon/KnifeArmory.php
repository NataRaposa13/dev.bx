<?php

namespace Army\Weapon;

class KnifeArmory extends Armory
{
	public function createWeapon(): Weapon
	{
		return new Knife();
	}
}