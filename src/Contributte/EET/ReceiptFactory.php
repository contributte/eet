<?php

namespace Contributte\EET;

use Nette\Utils\ArrayHash;

class ReceiptFactory
{
	/** @var ArrayHash */
	private $params;

	public function __construct(ArrayHash $params)
	{
		$this->params = $params;
	}

	public function create(): Receipt
	{
		$receipt = new Receipt();

		foreach ($this->params as $property => $value) {
			if ($value !== null && is_string($property) && property_exists($receipt, $property)) {
				$receipt->{$property} = $value;
			}
		}

		return $receipt;
	}
}
