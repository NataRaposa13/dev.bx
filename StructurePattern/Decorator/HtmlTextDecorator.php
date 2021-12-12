<?php

namespace Decorator;

use Service\Formatting\Formatter;

class HtmlTextDecorator extends AbstractTextDecorator
{
	protected string $titleText;
	protected string $footerText;

	public function format(string $text): string
	{
		$title = "<h1>". $this->titleText . "</h1>";
		$footer = "<h4>". $this->footerText . "</h4>";
		$this->text = $title . $this->formatter->format($text) . $footer;
		return $this->text;
	}

	public function setTitleText(string $titleText): HtmlTextDecorator
	{
		$this->titleText = $titleText;
		return $this;
	}

	public function setFooterText(string $footerText): HtmlTextDecorator
	{
		$this->footerText = $footerText;
		return $this;
	}
}