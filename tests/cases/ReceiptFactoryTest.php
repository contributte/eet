<?php declare(strict_types=1);

namespace Tests\Cases;

use Tester;
use Tester\Assert;
use Contributte;
use Nette;
use DateTime;

require __DIR__ . '/../bootstrap.php';

class ReceiptFactoryTest extends Tester\TestCase
{
	public function testCreateFactory(): void
	{
		$params = Nette\Utils\ArrayHash::from([]);
		$factory = new Contributte\EET\ReceiptFactory($params);

		Assert::type(new Contributte\EET\Receipt(), $factory->create());
	}

	public function testDefaultParams(): void
	{
		$params = Nette\Utils\ArrayHash::from([
			'dic_popl' => 'CZ1234'
		]);

		$factory = new Contributte\EET\ReceiptFactory($params);
		$receipt = $factory->create();

		Assert::same($receipt->dic_popl, 'CZ1234');
	}

	public function testDefaultReceipt(): void
	{
		$receipt = new Contributte\EET\Receipt();

		Assert::type('string', $receipt->uuid_zpravy);
		Assert::type(new DateTime(), $receipt->dat_trzby);
	}
}

(new ReceiptFactoryTest())->run();
