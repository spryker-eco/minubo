<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
