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
    private $secureFields = [
        'password',
        'restore_password_date',
        'restore_password_key',
        'registration_key',
    ];

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    private $customer;

    /**
     * @var \SprykerEco\Zed\Minubo\Communication\Plugin\Filter\CustomerSecureFieldFilterPlugin
     */
    private $plugin;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->customer = $this->tester->haveCustomer();
        $this->plugin = new CustomerSecureFieldFilterPlugin();
    }

    /**
     * @return void
     */
    public function testFilterDataShouldReturnDataWithoutSecureFields()
    {
        $customerData = (new MinuboRepository())
            ->getCustomerDataUpdatedSinceLastRun();

        $result = $this->plugin->filterData($customerData[0]);

        foreach ($this->secureFields as $field) {
            $this->assertArrayNotHasKey($field, $result);
        }
    }
}