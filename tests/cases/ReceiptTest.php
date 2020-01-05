<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte;
use DateTime;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class ReceiptTest extends Tester\TestCase
{

	public function testDefaultReceipt(): void
	{
		$receipt = new Contributte\EET\Receipt();

		Assert::type('string', $receipt->uuid_zpravy);
		Assert::type(new DateTime(), $receipt->dat_trzby);
	}

}

(new ReceiptTest())->run();
