<?php

namespace Army\Weapon;

abstract class AbstractArmory
{
	abstract public function createBow(): Bow;
	abstract public function createKnife(): Knife;
}