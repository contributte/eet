<?php declare(strict_types = 1);

namespace Tests\Cases\DI;

use Contributte;
use Nette;
use Tester;
use Tester\Assert;
use Tester\FileMock;

require __DIR__ . '/../../bootstrap.php';

class EETExtensionTest extends Tester\TestCase
{

	public function testNoParameters(): void
	{
		$loader = new Nette\DI\ContainerLoader(TEMP_DIR, true);

		Assert::exception(function () use ($loader): void {
			$loader->load(function (Nette\DI\Compiler $compiler): void {
				$compiler->addExtension('eet', new Contributte\EET\DI\EETExtension());
			}, [getmygid(), __METHOD__]);
		}, Nette\DI\InvalidConfigurationException::class);
	}

	public function testRequireParameters(): void
	{
		$loader = new Nette\DI\ContainerLoader(TEMP_DIR, true);
		$class = $loader->load(function (Nette\DI\Compiler $compiler): void {
			$compiler->addExtension('eet', new Contributte\EET\DI\EETExtension());
			$compiler->loadConfig(FileMock::create('
			eet:
				certificate:
					file: Playground.p12
					password: eet
			', 'neon'));
		}, [getmygid(), __METHOD__]);

		/** @var Nette\DI\Container $container */
		$container = new $class();

		Assert::type(Contributte\EET\ClientFactory::class, $container->getByType(Contributte\EET\ClientFactory::class));
		Assert::type(Contributte\EET\ReceiptFactory::class, $container->getByType(Contributte\EET\ReceiptFactory::class));
	}

	public function testDefaultReceiptParams(): void
	{
		$loader = new Nette\DI\ContainerLoader(TEMP_DIR, true);
		$class = $loader->load(function (Nette\DI\Compiler $compiler): void {
			$compiler->addExtension('eet', new Contributte\EET\DI\EETExtension());
			$compiler->loadConfig(FileMock::create('
			eet:
				certificate:
					file: Playground.p12
					password: eet

				receipt:
					id_provoz: 1234
					dic_popl: CZ1234
			', 'neon'));
		}, [getmygid(), __METHOD__]);

		/** @var Nette\DI\Container $container */
		$container = new $class();

		$receipt = $container->getByType(Contributte\EET\ReceiptFactory::class)->create();

		Assert::same($receipt->id_provoz, 1234);
		Assert::same($receipt->dic_popl, 'CZ1234');
	}

}

(new EETExtensionTest())->run();
