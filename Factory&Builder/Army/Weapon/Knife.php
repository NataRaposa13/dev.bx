<?php

namespace Army\Weapon;

class Knife implements Weapon
{
	public function hit(): void
	{
		echo "Удар ножом!";
	}

	public function damage(): int
	{
		return 25;
	}

	public function val(): int
	{
		return 60;
	}
}