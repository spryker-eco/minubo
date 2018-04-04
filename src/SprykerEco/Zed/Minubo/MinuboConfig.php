<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Minubo\MinuboConstants;

class MinuboConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getFileSystemName(): string
    {
        return $this->get(MinuboConstants::MINUBO_FILE_SYSTEM_NAME);
    }

    /**
     * @return string
     */
    public function getBucketDirectory(): string
    {
        return $this->get(MinuboConstants::MINUBO_BUCKET_DIRECTORY);
    }

    /**
     * @return string
     */
    public function getRecursionValue(): string
    {
        return $this->get(MinuboConstants::MINUBO_RECURSION_VALUE);
    }

    /**
     * @return array
     */
    public function getCustomerSecureFields(): array
    {
        return $this->get(MinuboConstants::MINUBO_CUSTOMER_SECURE_FIELDS);
    }
}
