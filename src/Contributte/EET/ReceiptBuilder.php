<?php declare(strict_types = 1);

namespace Contributte\EET;

use DateTime;
use FilipSedivy\EET\Receipt;
use Nette;
use Ramsey\Uuid\Uuid;

class ReceiptBuilder
{

	/** @var Receipt */
	private $receipt;

	public static function create(string $idStore, string $idCashRegister, string $serialNumber, string $taxPayer): self
	{
		$instance = new self();
		$instance->receipt->uuid_zpravy = Uuid::uuid4()->toString();
		$instance->receipt->dat_trzby = Nette\Utils\DateTime::from('now');
		$instance->receipt->id_provoz = $idStore;
		$instance->receipt->id_pokl = $idCashRegister;
		$instance->receipt->dic_popl = $taxPayer;
		$instance->receipt->porad_cis = $serialNumber;

		return $instance;
	}

	public function __construct()
	{
		$this->receipt = new Receipt();
	}

	public function setSalesDate(DateTime $date): self
	{
		$this->receipt->dat_trzby = $date;

		return $this;
	}

	public function getSalesDate(): DateTime
	{
		return $this->receipt->dat_trzby;
	}

	public function setAmountRevenue(float $amount): self
	{
		$this->receipt->celk_trzba = $amount;

		return $this;
	}

	public function getAmountRevenue(): ?float
	{
		return $this->receipt->celk_trzba;
	}

	public function receipt(): Receipt
	{
		return $this->receipt;
	}

}
