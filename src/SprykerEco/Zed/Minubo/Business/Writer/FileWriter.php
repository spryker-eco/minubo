<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace SprykerEco\Zed\Minubo\Business\Writer;

use Generated\Shared\Transfer\FileSystemContentTransfer;
use SprykerEco\Zed\Minubo\Dependency\Service\MinuboToFileSystemServiceInterface;
use SprykerEco\Zed\Minubo\Dependency\Service\MinuboToUtilEncodingServiceInterface;
use SprykerEco\Zed\Minubo\MinuboConfig;

class FileWriter implements WriterInterface
{
    /**
     * @var \SprykerEco\Zed\Minubo\Dependency\Service\MinuboToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \SprykerEco\Zed\Minubo\Dependency\Service\MinuboToFileSystemServiceInterface
     */
    protected $fileSystemService;

    /**
     * @var \SprykerEco\Zed\Minubo\MinuboConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Minubo\Dependency\Service\MinuboToUtilEncodingServiceInterface $utilEncodingService
     * @param \SprykerEco\Zed\Minubo\Dependency\Service\MinuboToFileSystemServiceInterface $fileSystemService
     * @param \SprykerEco\Zed\Minubo\MinuboConfig $config
     */
    public function __construct(
        MinuboToUtilEncodingServiceInterface $utilEncodingService,
        MinuboToFileSystemServiceInterface $fileSystemService,
        MinuboConfig $config
    ) {
        $this->utilEncodingService = $utilEncodingService;
        $this->fileSystemService = $fileSystemService;
        $this->config = $config;
    }

    /**
     * @param array $data
     * @param string $filePrefix
     *
     * @return void
     */
    public function writeData(array $data, string $filePrefix): void
    {
        $content = '';
        foreach ($data as $item) {
            $content .= $this->utilEncodingService->encodeJson($item) . PHP_EOL;
        }

        $this->writeContentToFile($content, $filePrefix);
    }

    /**
     * @param string $content
     * @param string $filePrefix
     *
     * @return void
     */
    protected function writeContentToFile(string $content, string $filePrefix): void
    {
        $fileSystemContentTransfer = new FileSystemContentTransfer();
        $fileSystemContentTransfer->setFileSystemName($this->config->getFileSystemName());
        $fileSystemContentTransfer->setContent($content);
        $fileSystemContentTransfer->setPath($this->getFileName($filePrefix));

        $this->fileSystemService->put($fileSystemContentTransfer);
    }

    /**
     * @param string $filePrefix
     *
     * @return string
     */
    protected function getFileName(string $filePrefix): string
    {
        return $this->config->getBucketDirectory() . $filePrefix . '_' . time() . '.json';
    }
}
