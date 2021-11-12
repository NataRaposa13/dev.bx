<?php

function printMessage(string $message)
{
	echo $message . "\n";
}

function escape(string $output): string
{
	return htmlspecialchars($output, ENT_QUOTES);
}

function formatMessage(string $text, int $textLength = 10): string
{
	if (mb_strlen($text, 'UTF-8') > $textLength)
	{
		$text = mb_substr($text, 0, $textLength, 'UTF-8') . "...";
	}

	return $text;
}

function getFileName($path): string
{
	return basename($path, ".php");
}