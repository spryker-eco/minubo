<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace SprykerEco\Zed\Minubo\Business\DataExpander;

interface OrderItemStateFlagExpanderInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function expandOrderItemWithStateFlags(array $data): array;
}
