<?php
namespace Tests;

final class AppTest extends TestBase
{

    /**
     *
     * @group e2e
     */
    public function testCredentials(): void
    {
        $this->assertInstanceOf(\Getnet\API\Getnet::class, $this->getnetService());
    }
}