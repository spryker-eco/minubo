<?php

/**
 * MIT License
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
