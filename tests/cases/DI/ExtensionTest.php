<?php declare(strict_types = 1);

namespace Tests\Cases\DI;

use Contributte\EET\DI\EETExtension;
use Contributte\EET\Exception\UnexpectedValueException;
use FilipSedivy\EET\Certificate;
use FilipSedivy\EET\Dispatcher;
use FilipSedivy\EET\Exceptions\Certificate\CertificateExportFailedException;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

class ExtensionTest extends TestCase
{

	public function testEmptyParameters(): void
	{
		Assert::exception(function (): void {
			$this->buildContainer([], __METHOD__);
		}, UnexpectedValueException::class, "Please configure certificate using the 'eet' section in your config file.");
	}

	public function testBadPassword(): void
	{
		$container = $this->buildContainer([
			'eet' => [
				'certificate' => [
					'file' => DATA_DIR . '/EET_CA1_Playground-CZ00000019.p12',
					'password' => 'bad-password',
				],
			],
		], __METHOD__);

		Assert::exception(static function () use ($container): void {
			$container->getService('eet.dispatcher');
		}, CertificateExportFailedException::class);
	}

	public function testSuccessImplement(): void
	{
		$container = $this->buildContainer([
			'eet' => [
				'certificate' => [
					'file' => DATA_DIR . '/EET_CA1_Playground-CZ00000019.p12',
					'password' => 'eet',
				],
			],
		], __METHOD__);

		Assert::type(Certificate::class, $container->getService('eet.certificate'));
		Assert::type(Dispatcher::class, $container->getService('eet.dispatcher'));
	}

	/**
	 * @param mixed[] $config
	 */
	private function buildContainer(array $config = [], ?string $key = null): Container
	{
		$loader = new ContainerLoader(TEMP_DIR, true);
		$class = $loader->load(static function (Compiler $compiler) use ($config): void {
			$compiler
				->addExtension('eet', new EETExtension())
				->addConfig($config);
		}, $key);

		return new $class();
	}

}

($extensionTest = new ExtensionTest())->run();
