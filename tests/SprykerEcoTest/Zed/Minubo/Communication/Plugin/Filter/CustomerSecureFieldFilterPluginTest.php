<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Minubo;

use Codeception\Test\Unit;
use SprykerEco\Zed\Minubo\Communication\Plugin\Filter\CustomerSecureFieldFilterPlugin;
use SprykerEco\Zed\Minubo\MinuboConfig;
use SprykerEco\Zed\Minubo\Persistence\MinuboRepository;

class CustomerSecureFieldFilterPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    private $customer;

    /**
     * @var \SprykerEco\Zed\Minubo\Communication\Plugin\Filter\CustomerSecureFieldFilterPlugin
     */
    private $plugin;

    /**
     * @var \SprykerEco\Zed\Minubo\MinuboConfig
     */
    private $minuboConfig;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->customer = $this->tester->haveCustomer();
        $this->plugin = new CustomerSecureFieldFilterPlugin();
        $this->minuboConfig = new MinuboConfig();
    }

    /**
     * @return void
     */
    public function testFilterDataShouldReturnDataWithoutSecureFields()
    {
        $customerData = (new MinuboRepository())
            ->getCustomerDataUpdatedSinceLastRun();

        $result = $this->plugin->filterData($customerData[0]);

        $secureFields = $this->minuboConfig->getCustomerSecureFields();

        foreach ($secureFields as $field) {
            $this->assertArrayNotHasKey($field, $result);
        }
    }
}