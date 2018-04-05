<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Dependency\Service;

use Generated\Shared\Transfer\FileSystemContentTransfer;

interface MinuboToFileSystemServiceInterface
{
    /**
     * @param \Generated\Shared\Transfer\FileSystemContentTransfer $fileSystemContentTransfer
     *
     * @throws \Spryker\Service\FileSystem\Dependency\Exception\FileSystemWriteException
     *
     * @return void
     */
    public function put(FileSystemContentTransfer $fileSystemContentTransfer): void;
}
