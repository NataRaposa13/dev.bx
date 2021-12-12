<?php

spl_autoload_register(function ($class) {
	include __DIR__ . '/' . str_replace("\\", "/",  $class) . '.php';
});


$advertisement = (new \Entity\Advertisement())
	->setBody("test")
	->setTitle("test")
	->setDuration(10);

$calculator = new \Service\AdvCalculator($advertisement);
$calculator->applyCost();

$calculator = new \Decorator\VatCostDecorator($calculator);
var_dump($calculator->applyCost()->getTotalCost());


$formatter = new \Service\Formatting\PlainTextFormatter($advertisement);
var_dump($formatter->format("test1"));

$formatter = (new \Decorator\HtmlTextDecorator($formatter))
	->setTitleText("Внимание")
	->setFooterText("Ждём вас");

var_dump($formatter->format("test2"));
