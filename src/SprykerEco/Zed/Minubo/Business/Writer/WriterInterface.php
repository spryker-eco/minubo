<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Business\Writer;

interface WriterInterface
{
    /**
     * @param array $data
     * @param string $filePrefix
     *
     * @return void
     */
    public function writeData(array $data, string $filePrefix): void;
}
