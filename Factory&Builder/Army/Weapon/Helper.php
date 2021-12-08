<?php

namespace Army\Weapon;

class Helper
{
	public static function getArmory(string $type)
	{
		switch($type)
		{
			case 'bow':
				return new BowArmory();
			case 'knife':
				return new KnifeArmory();
		}
	}
}