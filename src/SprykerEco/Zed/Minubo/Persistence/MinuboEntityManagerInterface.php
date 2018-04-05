<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Persistence;

use Generated\Shared\Transfer\SpyMinuboRunEntityTransfer;

interface MinuboEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpyMinuboRunEntityTransfer $minuboRunEntityTransfer
     *
     * @return \Generated\Shared\Transfer\SpyMinuboRunEntityTransfer
     */
    public function createMinuboLastRun(
        SpyMinuboRunEntityTransfer $minuboRunEntityTransfer
    ): SpyMinuboRunEntityTransfer;
}
