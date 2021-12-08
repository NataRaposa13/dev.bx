<?php

namespace Army\Weapon;

class BowArmory extends Armory
{
	public function createWeapon(): Weapon
	{
		return new Bow();
	}
}