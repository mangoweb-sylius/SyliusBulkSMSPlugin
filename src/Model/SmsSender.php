<?php

declare(strict_types=1);

namespace MangoSylius\BulkSmsPlugin\Model;

use MangoSylius\BulkSmsPlugin\Entity\BulkSmsInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;

class SmsSender implements SmsSenderInterface
{
	public const API_ROUTE_SEND = 'https://api.bulksms.com/v1/messages';

	/** @var LoggerInterface */
	private $logger;

	public function __construct(
		LoggerInterface $logger
	) {
		$this->logger = $logger;
	}

	public function sendSms(ShipmentInterface $shipment): void
	{
		$order = $shipment->getOrder();
		assert($order !== null);
		$trackingNumber = $shipment->getTracking();

		$channel = $order->getChannel();
		assert($channel !== null);
		assert($channel instanceof BulkSmsChannelInterface);

		$shipmentMethod = $shipment->getMethod();
		assert($shipmentMethod !== null);

		$orderLocale = $order->getLocaleCode();
		assert($orderLocale !== null);
		$translation = $shipmentMethod->getTranslation($orderLocale);
		assert($translation !== null);
		assert($translation instanceof BulkSmsShippingMethodInterface);

		if ($translation->getLocale() === $orderLocale) {
			$smsText = $translation->getSmsText();
			$smsApi = $channel->getBulkSms();
			if ($smsText !== null && $smsApi !== null && $smsApi->isEnabled()) {
				$this->doSendGetSms($smsApi, $order, $smsText, $trackingNumber);
			}
		}
	}

	private function getPhoneNumber(OrderInterface $order): ?string
	{
		$phoneNumber = null;

		$address = $order->getShippingAddress();
		if ($address !== null && $address->getPhoneNumber() !== null) {
			$phoneNumber = $address->getPhoneNumber();
		}

		$address = $order->getBillingAddress();
		if ($phoneNumber === null && $address !== null && $address->getPhoneNumber() !== null) {
			$phoneNumber = $address->getPhoneNumber();
		}

		if ($phoneNumber === null) {
			return null;
		}

		$phoneNumber = trim($phoneNumber);
		$phoneNumber = preg_replace('/\s/', '', $phoneNumber);

		assert($phoneNumber !== null);

		if (substr($phoneNumber, 0, 2) === '00') {
			$phoneNumber = substr($phoneNumber, 2);
		}

		if (substr($phoneNumber, 0, 1) !== '+') {
			$phoneNumber = '+' . $phoneNumber;
		}

		$pattern = '/^\+\d+$/';
		if (!preg_match($pattern, $phoneNumber)) {
			$this->logger->error('No SMS send, bad number format: ' . $phoneNumber);

			return null;
		}

		return $phoneNumber;
	}

	private function getMessage(OrderInterface $order, string $smsText, ?string $trackingNumber): string
	{
		$address = $order->getShippingAddress();
		assert($address !== null);

		$smsText = str_replace('{{ orderNumber }}', $order->getNumber() ?? '', $smsText);
		$smsText = str_replace('{{ address.street }}', $address->getStreet() ?? '', $smsText);
		$smsText = str_replace('{{ address.city }}', $address->getCity() ?? '', $smsText);
		$smsText = str_replace('{{ address.company }}', $address->getCompany() ?? '', $smsText);
		$smsText = str_replace('{{ address.countryCode }}', $address->getCountryCode() ?? '', $smsText);
		$smsText = str_replace('{{ address.fullName }}', $address->getFullName() ?? '', $smsText);
		$smsText = str_replace('{{ address.postCode }}', $address->getPostcode() ?? '', $smsText);
		$smsText = str_replace('{{ address.provinceCode }}', $address->getProvinceCode() ?? '', $smsText);
		$smsText = str_replace('{{ address.provinceName }}', $address->getProvinceName() ?? '', $smsText);
		$smsText = str_replace('{{ trackingNumber }}', $trackingNumber ?? '', $smsText);

		return $smsText;
	}

	private function doSendGetSms(BulkSmsInterface $smsApi, OrderInterface $order, string $smsText, ?string $trackingNumber): void
	{
		$number = $this->getPhoneNumber($order);
		if ($number === null) {
			return;
		}

		$message = [
			'to' => $number,
			'body' => $this->getMessage($order, $smsText, $trackingNumber),
		];

		$sender = $smsApi->getSender();
		if ($sender !== null) {
			$message['from'] = $sender;
		}
		$message = json_encode($message);

		$token = $smsApi->getToken();
		$tokenSecret = $smsApi->getTokenSecret();

		if (!$message || $token === null || $tokenSecret === null) {
			$this->logger->error('Missing token.');

			return;
		}

		$result = $this->sendMessage($message, self::API_ROUTE_SEND, $token, $tokenSecret);

		if ((int) $result['http_status'] !== 201) {
			$errMessage = 'Error sending HTTP status ' . $result['http_status'] . ' Response was ' . $result['server_response'];
			$this->logger->error($errMessage);
		}
	}

	private function sendMessage(string $postBody, string $url, string $username, string $password): array
	{
		$ch = curl_init();
		$headers = [
			'Content-Type:application/json',
			'Authorization:Basic ' . base64_encode("$username:$password"),
		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
		// Allow cUrl functions 20 seconds to execute
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		// Wait 10 seconds while trying to connect
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$output = [];
		$output['server_response'] = curl_exec($ch);
		$curl_info = curl_getinfo($ch);
		$output['http_status'] = $curl_info['http_code'];
		curl_close($ch);

		return $output;
	}
}
