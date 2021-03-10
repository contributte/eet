# EET

## Content

- [Setup](#setup)
- [Configuration](#configuration)
- [Usage](#usage)

## Setup

Install package

```bash
composer require contributte/eet
```

Register extension

```neon
extensions:
	eet: Contributte\EET\DI\EETExtension

eet:
	certificate:
		path: %appDir%/../eet.p12
		password: my-password
```

## Configuration

```neon
eet:
	certificate:
		path: %appDir%/../eet.p12
		password: my-password

	dispatcher:
		# Dispatcher setting
		service: production / playground
		validate: true / false

	receipt:
		# Set default receipt values
		id_pokl: 19903
		dic_popl: CZ1234
```

## Usage

### Client usage

```php
use Contributte\EET;
use FilipSedivy;
use Nette;

final class SomePresenter extends Nette\Application\UI\Presenter
{
	/** @var EET\Dispatcher */
	private $client;

	/** @var EET\ReceiptFactory */
	private $receiptFactory;

	public function injectClientFactory(EET\ClientFactory $factory)
	{
		$this->client = $factory->create();
	}

	public function injectReceiptFactory(EET\ReceiptFactory $factory)
	{
		$this->receiptFactory = $factory;
	}

	public function processPayment()
	{
		$receipt = $this->receiptFactory->create();
		$receipt->porad_cis = '1';
		$receipt->celk_trzba = 500;

		try {
			$this->client->send($receipt);

			$this->payment->eet->save_success($this->client->getFik(), $this->client->getPkp());

		} catch (FilipSedivy\EET\Exceptions\EET\ClientException $clientException) {
			$this->payment->eet->save_error($clientException->getPkp(), $clientException->getBkp());

		}  catch (FilipSedivy\EET\Exceptions\EET\ErrorException $errorException) {
			echo '(' . $errorException->getCode() . ') ' . $errorException->getMessage();

		} catch(FilipSedivy\EET\Exceptions\Receipt\ConstraintViolationException $constraintViolationException){
			echo implode('<br>', $constraintViolationException->getErrors());

		}
	}
}
```
