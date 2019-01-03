<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Model;

use MangoSylius\BulkSmsPlugin\Entity\BulkSms;

interface BulkSmsChannelInterface
{
	public function getBulkSms(): ?BulkSms;
}
