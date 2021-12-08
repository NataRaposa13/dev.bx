<?php

namespace Army\Weapon;

interface Weapon
{
	public function hit(): void;
	public function damage(): int;

	public function val(): int;
}