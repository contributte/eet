<?php

namespace Contributte\EET;

use FilipSedivy;
use Ramsey;
use Nette;

class Receipt extends FilipSedivy\EET\Receipt
{
	public function __construct()
	{
		$this->uuid_zpravy = Ramsey\Uuid\Uuid::uuid4()->toString();
		$this->dat_trzby = new Nette\Utils\DateTime();
	}
}
