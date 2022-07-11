<?php
namespace Getnet\API;

/**
 * Class Pix
 *
 * @package Getnet\API
 * @link https://developers.getnet.com.br/api#tag/PIX%2Fpaths%2F~1v1~1payments~1qrcode~1pix%2Fpost
 */
class PixTransaction implements \JsonSerializable
{
    use TraitEntity;

    private $amount;

    private $currency = "BRL";

    private $order_id;

    private $customer_id;

    public function __construct($amount = null)
    {
        if (! is_null($amount)) {
            $this->setAmount($amount);
        }
    }

    // gets and sets
    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = (int) ($amount * 100);

        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;

        return $this;
    }
}