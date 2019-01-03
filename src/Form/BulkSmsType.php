<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Form;

use MangoSylius\BulkSmsPlugin\Entity\BulkSmsInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class BulkSmsType extends AbstractResourceType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('enabled', CheckboxType::class, [
				'label' => 'mango-sylius.admin.form.bulkSms.enabled',
				'required' => false,
			])
			->add('token', TextType::class, [
				'label' => 'mango-sylius.admin.form.bulkSms.token',
				'required' => false,
				'constraints' => [
					new NotBlank(['groups' => ['mango_bulk_sms_enabled']]),
				],
			])
			->add('tokenSecret', TextType::class, [
				'label' => 'mango-sylius.admin.form.bulkSms.tokenSecret',
				'required' => false,
				'constraints' => [
					new NotBlank(['groups' => ['mango_bulk_sms_enabled']]),
				],
			])
			->add('sender', TextType::class, [
				'label' => 'mango-sylius.admin.form.bulkSms.sender',
				'required' => false,
			])
			->add('routingGroup', ChoiceType::class, [
				'label' => 'mango-sylius.admin.form.bulkSms.routingGroup',
				'required' => true,
				'choices' => [
					BulkSmsInterface::ROUTING_GROUP_ECONOMY => BulkSmsInterface::ROUTING_GROUP_ECONOMY,
					BulkSmsInterface::ROUTING_GROUP_STANDARD => BulkSmsInterface::ROUTING_GROUP_STANDARD,
					BulkSmsInterface::ROUTING_GROUP_PREMIUM => BulkSmsInterface::ROUTING_GROUP_PREMIUM,
				],
			])
			->add('messageClass', ChoiceType::class, [
				'label' => 'mango-sylius.admin.form.bulkSms.messageClass',
				'required' => true,
				'choices' => [
					BulkSmsInterface::MESSAGE_CLASS_FLASH_SMS => BulkSmsInterface::MESSAGE_CLASS_FLASH_SMS,
					BulkSmsInterface::MESSAGE_CLASS_ME_SPECIFIC => BulkSmsInterface::MESSAGE_CLASS_ME_SPECIFIC,
					BulkSmsInterface::MESSAGE_CLASS_SIM_SPECIFIC => BulkSmsInterface::MESSAGE_CLASS_SIM_SPECIFIC,
					BulkSmsInterface::MESSAGE_CLASS_TE_SPECIFIC => BulkSmsInterface::MESSAGE_CLASS_TE_SPECIFIC,
				],
			])
			->add('protocolId', ChoiceType::class, [
				'label' => 'mango-sylius.admin.form.bulkSms.protocolId',
				'required' => true,
				'choices' => [
					BulkSmsInterface::PROTOCOL_ID_IMPLICIT => BulkSmsInterface::PROTOCOL_ID_IMPLICIT,
					BulkSmsInterface::PROTOCOL_ID_SHORT_MESSAGE_TYPE_0 => BulkSmsInterface::PROTOCOL_ID_SHORT_MESSAGE_TYPE_0,
					BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_1 => BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_1,
					BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_2 => BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_2,
					BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_3 => BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_3,
					BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_4 => BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_4,
					BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_5 => BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_5,
					BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_6 => BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_6,
					BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_7 => BulkSmsInterface::PROTOCOL_ID_REPLACE_MESSAGE_7,
					BulkSmsInterface::PROTOCOL_ID_RETURN_CALL => BulkSmsInterface::PROTOCOL_ID_RETURN_CALL,
					BulkSmsInterface::PROTOCOL_ID_ME_DOWNLOAD => BulkSmsInterface::PROTOCOL_ID_ME_DOWNLOAD,
					BulkSmsInterface::PROTOCOL_ID_ME_DEPERSONALIZE => BulkSmsInterface::PROTOCOL_ID_ME_DEPERSONALIZE,
					BulkSmsInterface::PROTOCOL_ID_SIM_DOWNLOAD => BulkSmsInterface::PROTOCOL_ID_SIM_DOWNLOAD,
				],
			])

		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => $this->dataClass,
			'validation_groups' => function (FormInterface $form) {
				/** @var BulkSmsInterface $entity */
				$entity = $form->getData();

				$groups = $this->validationGroups;
				if ($entity->isEnabled()) {
					$groups = array_merge($groups, ['mango_bulk_sms_enabled']);
				}

				return $groups;
			},
		]);
	}

	public function getBlockPrefix(): string
	{
		return 'mango_bulk_sms';
	}
}
