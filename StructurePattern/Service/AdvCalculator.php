<?php

namespace Service;

use Entity\Advertisement;

class AdvCalculator implements Calculator
{
	private float $totalCost;
	private Advertisement $advertisement;

	/**
	 * @param Advertisement $advertisement
	 */
	public function __construct(Advertisement $advertisement)
	{
		$this->advertisement = $advertisement;
	}

	public function applyCost(): Calculator
	{
		$this->totalCost = $this->advertisement->getDuration() * 100;

		return $this;
	}

	public function getTotalCost(): float
	{
		return $this->totalCost;
	}
}