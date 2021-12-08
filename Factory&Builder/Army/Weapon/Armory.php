<?php

namespace Army\Weapon;

abstract class Armory
{
	abstract public function createWeapon(): Weapon;
}