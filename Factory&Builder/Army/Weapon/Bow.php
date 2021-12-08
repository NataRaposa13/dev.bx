<?php

namespace Army\Weapon;

class Bow implements Weapon
{
	public function hit(): void
	{
		echo "Выстрел из лука!";
	}

	public function damage(): int
	{
		return 20;
	}

	public function val(): int
	{
		return 50;
	}
}