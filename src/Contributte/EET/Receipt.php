<?php declare(strict_types = 1);

namespace Contributte\EET;

use FilipSedivy;
use Nette;
use Ramsey;

class Receipt extends FilipSedivy\EET\Receipt
{

	public function __construct()
	{
		$this->uuid_zpravy = Ramsey\Uuid\Uuid::uuid4()->toString();
		$this->dat_trzby = new Nette\Utils\DateTime();
	}

}
