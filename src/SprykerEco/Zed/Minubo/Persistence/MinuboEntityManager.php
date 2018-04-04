<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Persistence;

use Generated\Shared\Transfer\SpyMinuboRunEntityTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

class MinuboEntityManager extends AbstractEntityManager implements MinuboEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpyMinuboRunEntityTransfer $minuboRunEntityTransfer
     *
     * @return \Generated\Shared\Transfer\SpyMinuboRunEntityTransfer
     */
    public function createMinuboLastRun(
        SpyMinuboRunEntityTransfer $minuboRunEntityTransfer
    ): SpyMinuboRunEntityTransfer {
        return $this->save($minuboRunEntityTransfer);
    }
}
