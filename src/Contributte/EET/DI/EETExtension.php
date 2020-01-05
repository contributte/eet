<?php declare(strict_types = 1);

namespace Contributte\EET\DI;

use Contributte;
use FilipSedivy;
use Nette;
use Nette\Schema\Expect;
use stdClass;

/**
 * @property      stdClass $config
 */
class EETExtension extends Nette\DI\CompilerExtension
{

	public function getConfigSchema(): Nette\Schema\Schema
	{
		return Expect::structure([
			'certificate' => Expect::structure([
				'file' => Expect::string()->required(),
				'password' => Expect::string()->required(),
			]),

			'dispatcher' => Expect::structure([
				'service' => Expect::string(FilipSedivy\EET\Dispatcher::PLAYGROUND_SERVICE),
				'validate' => Expect::bool(true),
			]),

			'receipt' => Expect::array(),
		]);
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('certificateFactory'))
			->setFactory(Contributte\EET\CertificateFactory::class, [
				$this->config->certificate->file,
				$this->config->certificate->password,
			]);

		$builder->addDefinition($this->prefix('clientFactory'))
			->setFactory(Contributte\EET\ClientFactory::class, [
				$this->prefix('@certificateFactory'),
				$this->config->dispatcher->service,
				$this->config->dispatcher->validate,
			]);

		$builder->addDefinition($this->prefix('receiptFactory'))
			->setFactory(Contributte\EET\ReceiptFactory::class, [
				Nette\Utils\ArrayHash::from((array) $this->config->receipt),
			]);
	}

}
