<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Model;

use Sylius\Component\Core\Model\ShipmentInterface;

interface SmsSenderInterface
{
	public function sendSms(ShipmentInterface $shipment): void;
}
