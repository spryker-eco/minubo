<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Dependency\Facade;

interface MinuboToOmsFacadeInterface
{
    /**
     * @param string $processName
     * @param string $stateName
     *
     * @return string[]
     */
    public function getStateFlags(string $processName, string $stateName): array;
}
