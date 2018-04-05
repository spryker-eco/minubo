<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
