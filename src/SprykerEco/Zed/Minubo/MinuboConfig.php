<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Minubo\MinuboConstants;

class MinuboConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getFileSystemName(): string
    {
        return $this->get(MinuboConstants::MINUBO_FILE_SYSTEM_NAME);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getBucketDirectory(): string
    {
        return $this->get(MinuboConstants::MINUBO_BUCKET_DIRECTORY);
    }

    /**
     * @api
     *
     * @return array
     */
    public function getCustomerSecureFields(): array
    {
        return $this->get(MinuboConstants::MINUBO_CUSTOMER_SECURE_FIELDS, []);
    }
}
