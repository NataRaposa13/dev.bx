<?php

namespace Decorator;

use Service\Formatting\Formatter;

abstract class AbstractTextDecorator implements Formatter
{
	protected Formatter $formatter;
	protected string $text;

	/**
	 * @param Formatter $formatter
	 */
	public function __construct(Formatter $formatter)
	{
		$this->formatter = $formatter;
	}


}