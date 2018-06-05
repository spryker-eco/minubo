<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Minubo;

use Codeception\Test\Unit;
use Codeception\TestCase\Test;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Minubo\Business\DataExpander\OrderItemStateFlagExpander;
use SprykerEco\Zed\Minubo\Business\MinuboFacade;
use SprykerEco\Zed\Minubo\Business\Writer\FileWriter;
use SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface;
use SprykerEco\Zed\Minubo\MinuboDependencyProvider;
use SprykerEco\Zed\Minubo\Persistence\MinuboRepository;

class MinuboFacadeTest extends Unit
{
    /**
     * @var \SprykerEco\Zed\Minubo\Business\MinuboFacadeInterface
     */
    private $minuboFacade;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer
     */
    private $order;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $container = new Container();

        $dependencyProvider = new MinuboDependencyProvider();
        $dependencyProvider->provideBusinessLayerDependencies($container);
        $dependencyProvider->providePersistenceLayerDependencies($container);

        $this->minuboFacade = new MinuboFacade();

        $this->order = $this->tester->haveOrder([
            'unitPrice' => 100,
        ], 'DummyPayment01');

    }

    /**
     * @return void
     */
    public function testExpandOrderItemWithStateFlags()
    {
        $orders = (new MinuboRepository())
            ->getOrderDataUpdatedSinceLastRun();
        $result = $this->minuboFacade->expandOrderItemWithStateFlags($orders[0]);

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey(OrderItemStateFlagExpander::KEY_OMS_STATE_FLAGS, $result[OrderItemStateFlagExpander::KEY_ITEMS][0]);
    }
}