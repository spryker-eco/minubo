<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Business\Exporter;

use DateTime;
use Generated\Shared\Transfer\SpyMinuboRunEntityTransfer;
use SprykerEco\Zed\Minubo\Persistence\MinuboEntityManagerInterface;
use SprykerEco\Zed\Minubo\Persistence\MinuboRepository;

class Exporter implements ExporterInterface
{
    /**
     * @var \SprykerEco\Zed\Minubo\Persistence\MinuboEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboExportPluginInterface[]
     */
    protected $exportPlugins;

    /**
     * @param \SprykerEco\Zed\Minubo\Persistence\MinuboEntityManagerInterface $entityManager
     * @param \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboExportPluginInterface[] $exportPlugins
     */
    public function __construct(MinuboEntityManagerInterface $entityManager, array $exportPlugins)
    {
        $this->exportPlugins = $exportPlugins;
        $this->entityManager = $entityManager;
    }

    /**
     * @return void
     */
    public function exportData()
    {
        $minuboRunEntityTransfer = new SpyMinuboRunEntityTransfer();
        $minuboRunEntityTransfer->setRanAt((new DateTime())->format(MinuboRepository::LAST_RUN_DATETIME_FORMAT));

        foreach ($this->exportPlugins as $exportPlugin) {
            $exportPlugin->exportData();
        }

        $this->entityManager->createMinuboLastRun($minuboRunEntityTransfer);
    }
}
