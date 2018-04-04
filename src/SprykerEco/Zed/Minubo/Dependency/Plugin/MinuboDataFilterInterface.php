<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Dependency\Plugin;

interface MinuboDataFilterInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function filterData(array $data): array;
}
