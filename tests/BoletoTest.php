<?php
namespace Tests;

use Getnet\API\Transaction;
use Getnet\API\BoletoRespose;
use Getnet\API\Boleto;

final class BoletoTest extends TestBase
{

    /**
     *
     * @group e2e
     */
    public function testBoletoCreate(): BoletoRespose
    {
        $transaction = $this->generateMockTransaction(false);
        $transaction->setAmount(1096.88);

        $transaction->boleto("000001946598")
            ->setDocumentNumber("170500000019763")
            ->setExpirationDate(date('d/m/Y', strtotime("+2 days")))
            ->setProvider(Boleto::PROVIDER_SANTANDER)
            ->setInstructions("Não receber após o vencimento");

        $response = $this->getnetService()->boleto($transaction);
        
        if (!($response instanceof BoletoRespose)) {
            throw new \Exception($response->getResponseJSON());
        }

        // TODO
        $this->assertSame(Transaction::STATUS_PENDING, $response->status, $response->getResponseJSON());
        $this->assertSame('EM ABERTO', $response->getStatus(), $response->getResponseJSON());
        
        $this->assertSame($transaction->getOrder()->getOrderId(), $response->getOrderId());
        $this->assertNotEmpty($response->getPaymentId());
        $this->assertNotEmpty($response->getBoletoId());
        $this->assertNotEmpty($response->getBarCode());
        $this->assertNotEmpty(filter_var($response->getBoletoHtml(), FILTER_VALIDATE_URL));
        $this->assertNotEmpty(filter_var($response->getBoletoPdf(), FILTER_VALIDATE_URL));

        return $response;
    }
}