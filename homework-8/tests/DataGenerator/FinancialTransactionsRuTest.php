<?php

class FinancialTransactionsRuTest extends \PHPUnit\Framework\TestCase
{
	public function getValidateFailSamples(): array
	{
		return [
			'empty' => [
				[],
			],
			'filled but empty' => [
				[
					'Name' => '',
					'PersonalAcc' => '',
					'BankName' => '',
					'BIC' => '',
					'CorrespAcc' => '',
				]
			],
		];
	}

	/**
	 * @dataProvider getValidateFailSamples
	 *
	 * @param array $fields
	 */
	public function testValidateFail(array $fields): void
	{
		$dataGenerator = new \App\DataGenerator\FinancialTransactionsRu();

		$dataGenerator->setFields($fields);

		$result = $dataGenerator->validate();

		static::assertFalse($result->isSuccess());
	}

	public function testThatValidateSuccess(): void
	{
		$dataGenerator = new \App\DataGenerator\FinancialTransactionsRu();

		$dataGenerator->setFields([]);

		$dataGenerator
			->setName('Name')
			->setBIC('BIC')
			->setBankName('BankName')
			->setCorrespondentAccount('CorrespondentAccount')
			->setPersonalAccount('CorrespondentAccount')
		;

		$result = $dataGenerator->validate();

		static::assertTrue($result->isSuccess());
	}

	public function testGetData(): void
	{
		$dataGenerator = new \App\DataGenerator\FinancialTransactionsRu();

		$dataGenerator->setFields([]);

		$data = $dataGenerator->getData();

		static::assertEquals('ST00012|Name=|PersonalAcc=|BankName=|BIC=|CorrespAcc=', $data);
	}


	public function getGetDataDelimiterDefaultSamples(): array
	{
		return [
			'empty' => [
				[]
			],
			'filled without |' => [
				['Персефона', '~', 'Деметра', '&', 'Зевс'],
				['%', 'НДС']
			],
			'filled with |' => [
				['|'],
				['|', '~', '_', '#', '$' , '^', '&', '*', '/', '`', '@', '%']
			]
		];
	}

	/**
	 * @dataProvider getGetDataDelimiterDefaultSamples
	 *
	 * @param array $fields
	 */
	public function testGetDataDelimiterDefault(array $fields): void
	{
		$dataGenerator = new \App\DataGenerator\FinancialTransactionsRu();

		$dataGenerator->setFields($fields);

		$data = $dataGenerator->getData();

		static::assertStringContainsString('|', mb_substr($data, 0, 8));
	}


	public function getGetDataChangeDelimiterSamples(): array
	{
		return [
			'filled with |' => [
				['Персефона', '_', 'Аид', '|', 'Зевс'],
				['%', 'НДС', '|']
			]
		];
	}

	/**
	 * @dataProvider getGetDataChangeDelimiterSamples
	 *
	 * @param array $fields
	 */
	public function testGetDataChangeDelimiter(array $fields): void
	{
		$dataGenerator = new \App\DataGenerator\FinancialTransactionsRu();

		$dataGenerator->setFields($fields);

		$data = $dataGenerator->getData();
		$delimiter = mb_substr($data, 7, 1);
		$possibleDelimiters = ['|', '~', '_', '#', '$' , '^', '&', '*', '/', '`', '@', '%'];

		static::assertNotEquals('|', $delimiter) && static::assertContains($delimiter, $possibleDelimiters);
	}
}
