<?php

namespace Contributte\EET;

class ClientFactory
{
	/** @var CertificateFactory */
	private $certificateFactory;

	/** @var string */
	private $service;

	/** @var bool */
	private $validate;

	public function __construct(CertificateFactory $certificateFactory, string $service, bool $validate)
	{
		$this->certificateFactory = $certificateFactory;
		$this->service = $service;
		$this->validate = $validate;
	}

	public function create(): Dispatcher
	{
		$certificate = $this->certificateFactory->create();

		return new Dispatcher($certificate, $this->service, $this->validate);
	}
}
