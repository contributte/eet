![](https://heatbadger.now.sh/github/readme/contributte/thumbator/?deprecated=1)

<p align=center>
    <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
    <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
    <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>

<p align=center>
    Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

## Disclaimer

| :warning: | This project is no longer being maintained.
|---|---|

| Composer | [`contributte/eet`](https://packagist.org/contributte/eet) |
|---|------------------------------------------------------------|
| Version | ![](https://badgen.net/packagist/v/contributte/eet)      |
| PHP | ![](https://badgen.net/packagist/php/contributte/eet)    |
| License | ![](https://badgen.net/github/license/contributte/eet)   |

## Usage

To install the latest version of `contributte/eet` use [Composer](https://getcomposer.org).

```bash
composer require contributte/eet
```

## Documentation

### Setup

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

### Configuration

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

### Usage

#### Client usage

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

## Development

This package was maintained by these authors.

<a href="https://github.com/f3l1x">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>
<a href="https://github.com/filipsedivy">
  <img width="80" height="80" src="https://avatars0.githubusercontent.com/u/5647591?s=80&v=4">
</a>

-----

Consider to [support](https://contributte.org/partners.html) **contributte** development team.
Also thank you for using this package.
