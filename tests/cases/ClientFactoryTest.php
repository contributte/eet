<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte;
use FilipSedivy;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class ClientFactoryTest extends Tester\TestCase
{

	public function testCreateFactory(): void
	{
		$certificateFactory = new Contributte\EET\CertificateFactory(DATA_DIR . '/EET_CA1_Playground-CZ00000019.p12', 'eet');
		$clientFactory = new Contributte\EET\ClientFactory($certificateFactory, Contributte\EET\Dispatcher::PLAYGROUND_SERVICE, true);

		Assert::type(new Contributte\EET\Dispatcher($certificateFactory->create()), $clientFactory->create());
	}

	public function testCertificateBadPassword(): void
	{
		$certificateFactory = new Contributte\EET\CertificateFactory(DATA_DIR . '/EET_CA1_Playground-CZ00000019.p12', 'nothing');
		$clientFactory = new Contributte\EET\ClientFactory($certificateFactory, Contributte\EET\Dispatcher::PLAYGROUND_SERVICE, true);

		Assert::exception(static function () use ($clientFactory): void {
			$clientFactory->create();
		}, FilipSedivy\EET\Exceptions\Certificate\CertificateExportFailedException::class);
	}

	public function testCertificateNotFound(): void
	{
		$certificateFactory = new Contributte\EET\CertificateFactory(DATA_DIR . '/EET_CA1_Playground.p12', 'eet');
		$clientFactory = new Contributte\EET\ClientFactory($certificateFactory, Contributte\EET\Dispatcher::PLAYGROUND_SERVICE, true);

		Assert::exception(static function () use ($clientFactory): void {
			$clientFactory->create();
		}, FilipSedivy\EET\Exceptions\Certificate\CertificateNotFoundException::class);
	}

}

(new ClientFactoryTest())->run();
