<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Form\Extension;

use MangoSylius\BulkSmsPlugin\Form\BulkSmsType;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class BulkSmsChannelTypeExtension extends AbstractTypeExtension
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder->add('bulkSms', BulkSmsType::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtendedType(): string
	{
		return ChannelType::class;
	}
}
