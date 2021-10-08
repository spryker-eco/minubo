<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Dependency\Facade;

interface MinuboToOmsFacadeInterface
{
    /**
     * @param string $processName
     * @param string $stateName
     *
     * @return array<string>
     */
    public function getStateFlags(string $processName, string $stateName): array;
}
