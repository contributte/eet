<?php declare(strict_types=1);

namespace Contributte\EET\DI;

use Contributte\EET\UnexpectedValueException;
use Nette\DI\CompilerExtension;
use FilipSedivy\EET;

class EETExtension extends CompilerExtension
{
	public $defaults = [
		'certificate' => [
			'file' => null,
			'password' => ''
		],

		'dispatcher' => [
			'service' => EET\Dispatcher::PLAYGROUND_SERVICE,
			'validate' => true
		]
	];

	public function loadConfiguration(): void
	{
		$config = $this->validateConfig($this->defaults, $this->config);

		$builder = $this->getContainerBuilder();

		if (empty($config['certificate']['file'])) {
			throw new UnexpectedValueException("Please configure certificate using the '{$this->name}:' section in your config file.");
		}

		$builder->addDefinition($this->prefix('certificate'))
			->setFactory(EET\Certificate::class, [
				$config['certificate']['file'],
				$config['certificate']['password']
			]);

		$builder->addDefinition($this->prefix('dispatcher'))
			->setFactory(EET\Dispatcher::class, [
				$this->prefix('@certificate'),
				$config['dispatcher']['service'],
				$config['dispatcher']['validate']
			]);
	}
}
