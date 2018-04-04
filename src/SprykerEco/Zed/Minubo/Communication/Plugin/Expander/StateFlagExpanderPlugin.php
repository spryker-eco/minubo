<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace  SprykerEco\Zed\Minubo\Communication\Plugin\Expander;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface;

/**
 * @method \SprykerEco\Zed\Minubo\Communication\MinuboCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Minubo\Business\MinuboFacadeInterface getFacade()
 */
class StateFlagExpanderPlugin extends AbstractPlugin implements MinuboDataExpanderInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function expandData(array $data): array
    {
        return $this->getFacade()
            ->expandOrderItemWithStateFlags($data);
    }
}
