<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait BulkSmsShippingMethodTrait
{
	/**
	 * @var string|null
	 * @ORM\Column(type="text", name="sms_text", nullable=true)
	 */
	private $smsText;

	public function getSmsText(): ?string
	{
		return $this->smsText;
	}

	public function setSmsText(?string $smsText): void
	{
		$this->smsText = $smsText;
	}
}
