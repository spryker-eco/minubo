<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboExportPluginInterface;

/**
 * @method \SprykerEco\Zed\Minubo\Business\MinuboFacadeInterface getFacade()
 */
class MinuboOrderExportPlugin extends AbstractPlugin implements MinuboExportPluginInterface
{
    /**
     * @return void
     */
    public function exportData(): void
    {
        $this->getFacade()
            ->exportOrderData();
    }
}
