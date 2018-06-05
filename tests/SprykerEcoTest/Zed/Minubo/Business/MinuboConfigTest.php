<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Minubo;

use Codeception\Test\Unit;
use SprykerEco\Shared\Minubo\MinuboConstants;
use SprykerEco\Zed\Minubo\MinuboConfig;

class MinuboConfigTest extends Unit
{
    /**
     * @return \SprykerEco\Zed\Minubo\MinuboConfig
     */
    protected function getConfig()
    {
        return new MinuboConfig();
    }

    /**
     * @return void
     */
    public function testGetFileSystemNameShouldReturnString()
    {
        $this->assertTrue(is_string($this->getConfig()->getFileSystemName()));
    }

    /**
     * @return void
     */
    public function testGetBucketDirectoryShouldReturnString()
    {
        $this->assertTrue(is_string($this->getConfig()->getBucketDirectory()));
    }

    /**
     * @return void
     */
    public function testGetCustomerSecurityFieldsShouldReturnArray()
    {
        $this->assertTrue(is_array($this->getConfig()->getCustomerSecureFields()));
    }
}