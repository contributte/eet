<?php

namespace Contributte\EET;

use FilipSedivy;

class CertificateFactory
{
	/** @var string */
	private $file;

	/** @var string */
	private $password;

	public function __construct(string $file, string $password)
	{
		$this->file = $file;
		$this->password = $password;
	}

	public function create(): FilipSedivy\EET\Certificate
	{
		return new FilipSedivy\EET\Certificate($this->file, $this->password);
	}
}
