<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Entity;

interface BulkSmsInterface
{
	public const ROUTING_GROUP_ECONOMY = 'ECONOMY';
	public const ROUTING_GROUP_STANDARD = 'STANDARD';
	public const ROUTING_GROUP_PREMIUM = 'PREMIUM';

	public const MESSAGE_CLASS_FLASH_SMS = 'FLASH_SMS';
	public const MESSAGE_CLASS_ME_SPECIFIC = 'ME_SPECIFIC';
	public const MESSAGE_CLASS_SIM_SPECIFIC = 'SIM_SPECIFIC';
	public const MESSAGE_CLASS_TE_SPECIFIC = 'TE_SPECIFIC';

	public const PROTOCOL_ID_IMPLICIT = 'IMPLICIT';
	public const PROTOCOL_ID_SHORT_MESSAGE_TYPE_0 = 'SHORT_MESSAGE_TYPE_0';
	public const PROTOCOL_ID_REPLACE_MESSAGE_1 = 'REPLACE_MESSAGE_1';
	public const PROTOCOL_ID_REPLACE_MESSAGE_2 = 'REPLACE_MESSAGE_2';
	public const PROTOCOL_ID_REPLACE_MESSAGE_3 = 'REPLACE_MESSAGE_3';
	public const PROTOCOL_ID_REPLACE_MESSAGE_4 = 'REPLACE_MESSAGE_4';
	public const PROTOCOL_ID_REPLACE_MESSAGE_5 = 'REPLACE_MESSAGE_5';
	public const PROTOCOL_ID_REPLACE_MESSAGE_6 = 'REPLACE_MESSAGE_6';
	public const PROTOCOL_ID_REPLACE_MESSAGE_7 = 'REPLACE_MESSAGE_7';
	public const PROTOCOL_ID_RETURN_CALL = 'RETURN_CALL';
	public const PROTOCOL_ID_ME_DOWNLOAD = 'ME_DOWNLOAD';
	public const PROTOCOL_ID_ME_DEPERSONALIZE = 'ME_DEPERSONALIZE';
	public const PROTOCOL_ID_SIM_DOWNLOAD = 'SIM_DOWNLOAD';

	public function getToken(): ?string;

	public function getTokenSecret(): ?string;

	public function getSender(): ?string;

	public function getRoutingGroup(): string;

	public function getMessageClass(): string;

	public function getProtocolId(): string;

	public function isEnabled(): bool;
}
