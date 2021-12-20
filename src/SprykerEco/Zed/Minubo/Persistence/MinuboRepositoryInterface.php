<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Persistence;

interface MinuboRepositoryInterface
{
    /**
     * @return string|null
     */
    public function getLastMinuboRunTime(): ?string;

    /**
     * @return array
     */
    public function getOrderDataUpdatedSinceLastRun(): array;

    /**
     * @return array
     */
    public function getCustomerDataUpdatedSinceLastRun(): array;
}
