<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Table(name="mango_bulk_sms")
 * @ORM\Entity
 */
class BulkSms implements BulkSmsInterface, ResourceInterface
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", name="token", nullable=true)
	 */
	private $token;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", name="token_secret", nullable=true)
	 */
	private $tokenSecret;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", name="sender", nullable=true)
	 */
	private $sender;

	/**
	 * @var string
	 * @ORM\Column(type="string", name="routing_group", nullable=true)
	 */
	private $routingGroup = self::ROUTING_GROUP_STANDARD;

	/**
	 * @var string
	 * @ORM\Column(type="string", name="message_class", nullable=true)
	 */
	private $messageClass = self::MESSAGE_CLASS_SIM_SPECIFIC;

	/**
	 * @var string
	 * @ORM\Column(type="string", name="protocol_id", nullable=true)
	 */
	private $protocolId = self::PROTOCOL_ID_IMPLICIT;

	/**
	 * @var bool
	 *
	 * @ORM\Column(type="boolean", name="enabled", nullable=true)
	 */
	private $enabled = false;

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getToken(): ?string
	{
		return $this->token;
	}

	public function setToken(?string $token): void
	{
		$this->token = $token;
	}

	public function getTokenSecret(): ?string
	{
		return $this->tokenSecret;
	}

	public function setTokenSecret(?string $tokenSecret): void
	{
		$this->tokenSecret = $tokenSecret;
	}

	public function getSender(): ?string
	{
		return $this->sender;
	}

	public function setSender(?string $sender): void
	{
		$this->sender = $sender;
	}

	public function getRoutingGroup(): string
	{
		return $this->routingGroup;
	}

	public function setRoutingGroup(string $routingGroup): void
	{
		$this->routingGroup = $routingGroup;
	}

	public function getMessageClass(): string
	{
		return $this->messageClass;
	}

	public function setMessageClass(string $messageClass): void
	{
		$this->messageClass = $messageClass;
	}

	public function getProtocolId(): string
	{
		return $this->protocolId;
	}

	public function setProtocolId(string $protocolId): void
	{
		$this->protocolId = $protocolId;
	}

	public function isEnabled(): bool
	{
		return $this->enabled;
	}

	public function setEnabled(bool $enabled): void
	{
		$this->enabled = $enabled;
	}
}
