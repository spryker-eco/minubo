<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcotTest\Zed\Minubo;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\SpyMinuboRunEntityTransfer;
use Orm\Zed\Minubo\Persistence\SpyMinuboRun;
use SprykerEco\Zed\Minubo\Persistence\MinuboEntityManager;
use SprykerEco\Zed\Minubo\Persistence\MinuboRepository;

class MinuboRepositoryTest extends Unit
{
    private $minuboRepository;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    private $customer1;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    private $customer2;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer
     */
    private $order1;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer
     */
    private $order2;


    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->customer1 = $this->tester->haveCustomer();
        $this->order1 = $this->tester->haveOrder([
            'unitPrice' => 100
        ], 'DummyPayment01');
        $this->order3 = $this->tester->haveOrder([
            'unitPrice' => 100
        ], 'DummyPayment01');
        $this->setLastRunDateTime();
        $this->customer2 = $this->tester->haveCustomer();
        $this->order2 = $this->tester->haveOrder([
            'unitPrice' => 100
        ], 'DummyPayment01');

        $this->minuboRepository = new MinuboRepository();

    }

    /**
     * @return void
     */
    public function testGetCustomerDataUpdatedSinceLastRunShouldReturnOne()
    {
        $result = $this->minuboRepository->getCustomerDataUpdatedSinceLastRun();

        $this->assertTrue(is_array($result));
        $this->assertCount(1, $result);
        $this->assertSame($this->customer2->getCustomerReference(), $result[0]['customer_reference']);
    }

    /**
     * @return void
     */
    public function testGetOrderDataUpdatedSinceLastRunShouldReturnOne()
    {
        $result = $this->minuboRepository->getOrderDataUpdatedSinceLastRun();

        $this->assertTrue(is_array($result));
        $this->assertCount(1, $result);
        $this->assertSame($this->order2->getOrderReference(), $result[0]['order_reference']);
    }

    /**
     * @return void
     */
    protected function setLastRunDateTime()
    {
        $lastRunTransfer = new SpyMinuboRunEntityTransfer();
        $lastRunTransfer->setRanAt((new \DateTime())->format(MinuboRepository::LAST_RUN_DATETIME_FORMAT));
        (new MinuboEntityManager())->createMinuboLastRun($lastRunTransfer);
    }
}
