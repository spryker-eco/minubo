<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Minubo\Business\MinuboBusinessFactory getFactory()
 */
class MinuboFacade extends AbstractFacade implements MinuboFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function exportData()
    {
        $this->getFactory()
            ->createDataExporter()
            ->exportData();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function exportOrderData()
    {
        $this->getFactory()
            ->createOrderDataExporter()
            ->exportData();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function exportCustomerData()
    {
        $this->getFactory()
            ->createCustomerDataExporter()
            ->exportData();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $data
     *
     * @return array
     */
    public function expandOrderItemWithStateFlags(array $data): array
    {
        return $this->getFactory()
            ->createOrderItemStateFlagExpander()
            ->expandOrderItemWithStateFlags($data);
    }
}
