<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Model;

use Doctrine\ORM\Mapping as ORM;
use MangoSylius\BulkSmsPlugin\Entity\BulkSms;

trait BulkSmsChannelTrait
{
	/**
	 * @var BulkSms|null
	 * @ORM\OneToOne(targetEntity="MangoSylius\BulkSmsPlugin\Entity\BulkSms", cascade={"persist"}, fetch="EXTRA_LAZY")
	 */
	private $bulkSms;

	public function getBulkSms(): ?BulkSms
	{
		return $this->bulkSms ?? new BulkSms();
	}

	public function setBulkSms(?BulkSms $bulkSms): void
	{
		$this->bulkSms = $bulkSms;
	}
}
