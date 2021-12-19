<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboExportPluginInterface;

/**
 * @method \SprykerEco\Zed\Minubo\MinuboConfig getConfig()
 * @method \SprykerEco\Zed\Minubo\Communication\MinuboCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Minubo\Business\MinuboFacadeInterface getFacade()
 */
class MinuboCustomerExportPlugin extends AbstractPlugin implements MinuboExportPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function exportData(): void
    {
        $this->getFacade()
            ->exportCustomerData();
    }
}
