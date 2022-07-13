<?php
namespace Tests;

use Getnet\API\Credit;
use Getnet\API\Card;
use Getnet\API\AuthorizeResponse;
use Getnet\API\Transaction;

final class AuthorizeTest extends TestBase
{

    /**
     *
     * @group e2e
     */
    public function testAuthorizeCreate(): AuthorizeResponse
    {
        $transaction = $this->generateMockTransaction();
        $transaction->setAmount(857.96);

        // Generate token card
        $tokenCard = new \Getnet\API\Token("5155901222280001", $transaction->getCustomer()->getCustomerId(), $this->getnetService());

        // Add payment
        $transaction->credit()
            ->setAuthenticated(false)
            ->setDynamicMcc("1799")
            ->setSoftDescriptor("LOJA*TESTE*COMPRA-123")
            ->setDelayed(false)
            ->setPreAuthorization(false)
            ->setNumberInstallments(2)
            ->setSaveCardData(false)
            ->setTransactionType(Credit::TRANSACTION_TYPE_INSTALL_NO_INTEREST)
            ->card($tokenCard)
            ->setBrand(Card::BRAND_MASTERCARD)
            ->setExpirationMonth("12")
            ->setExpirationYear(date('y') + 1)
            ->setCardholderName("Jax Teller")
            ->setSecurityCode("123");

        $response = $this->getnetService()->authorize($transaction);

        if (!($response instanceof AuthorizeResponse)) {
            throw new \Exception($response->getResponseJSON());
        }
        
        $this->assertSame(Transaction::STATUS_APPROVED, $response->getStatus(), $response->getResponseJSON());
        $this->assertSame($transaction->getAmount(), $response->getAmount());
        $this->assertSame($transaction->getOrder()->getOrderId(), $response->getOrderId());
        $this->assertNotEmpty($response->getPaymentId());

        return $response;
    }

    /**
     *
     * @group e2e
     * @depends testAuthorizeCreate
     */
    public function testAuthorizeCancel(AuthorizeResponse $response): void
    {
        $result = $this->getnetService()->authorizeCancel($response->getPaymentId(), $response->getAmount());

        $this->assertInstanceOf(AuthorizeResponse::class, $result);
        $this->assertSame(Transaction::STATUS_CANCELED, $result->getStatus(),$response->getResponseJSON());
        $this->assertSame($response->getAmount(), $result->getAmount());
        $this->assertSame($response->getPaymentId(), $result->getPaymentId());
    }
}