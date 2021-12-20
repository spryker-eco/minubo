<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Minubo\Business\MinuboBusinessFactory getFactory()
 * @method \SprykerEco\Zed\Minubo\Persistence\MinuboEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Minubo\Persistence\MinuboRepositoryInterface getRepository()
 */
class MinuboFacade extends AbstractFacade implements MinuboFacadeInterface
{
    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
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
     * {@inheritDoc}
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
     * {@inheritDoc}
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
