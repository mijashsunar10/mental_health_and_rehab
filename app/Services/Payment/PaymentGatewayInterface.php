<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    /**
     * Initiate Payment Gateway Transaction
     *
     * @param float $amount Amount requested for payment transaction
     * @param string $return_url Redirect url after payment transaction
     * @param array|null $arguments Additional dataset
     * @return mixed
     */
    public function initiate(float $amount, $return_url, ?array $arguments = null);

    /**
     * Payment status lookup request
     *
     * @param mixed $transaction_id Code provided by payment gateway vendor to uniquely identify payment transaction
     * @param array|null $arguments Additional dataset
     * @return array
     */
    public function inquiry($transaction_id, ?array $arguments = null): array;

    /**
     * Success status of payment transaction
     *
     * @param array $inquiry Payment transaction response
     * @param array|null $arguments Additional dataset
     * @return bool
     */
    public function isSuccess(array $inquiry, ?array $arguments = null): bool;

    /**
     * Requested amount to be registered
     *
     * @param array $inquiry Payment transaction response
     * @param array|null $arguments Additional dataset
     * @return float
     */
    public function requestedAmount(array $inquiry, ?array $arguments = null): float;
}
