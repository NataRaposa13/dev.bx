<?php

namespace Decorator;

use Service\Calculator;

abstract class AbstractCostDecorator implements Calculator
{
	protected Calculator $calculator;
	protected float $totalCost;

	/**
	 * @param Calculator $calculator
	 */
	public function __construct(Calculator $calculator)
	{
		$this->calculator = $calculator;
	}


}