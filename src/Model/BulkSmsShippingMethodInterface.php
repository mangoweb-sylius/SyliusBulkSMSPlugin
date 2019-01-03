<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Model;

interface BulkSmsShippingMethodInterface
{
	public function getSmsText(): ?string;
}
