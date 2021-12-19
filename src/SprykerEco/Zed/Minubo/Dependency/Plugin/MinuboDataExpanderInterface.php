<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Dependency\Plugin;

interface MinuboDataExpanderInterface
{
    /**
     * @api
     *
     * @param array $data
     *
     * @return array
     */
    public function expandData(array $data): array;
}
