<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Business\Exporter;

use SprykerEco\Zed\Minubo\Business\Writer\WriterInterface;
use SprykerEco\Zed\Minubo\Persistence\MinuboRepositoryInterface;

class OrderDataExporter implements DataExporterInterface
{
    const FILE_PREFIX = 'Orders';

    /**
     * @var \SprykerEco\Zed\Minubo\Persistence\MinuboRepositoryInterface
     */
    private $repository;

    /**
     * @var \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface[]
     */
    private $filterPlugins;

    /**
     * @var \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface[]
     */
    private $expanderPlugins;

    /**
     * @var \SprykerEco\Zed\Minubo\Business\Writer\WriterInterface
     */
    private $writer;

    /**
     * @param \SprykerEco\Zed\Minubo\Persistence\MinuboRepositoryInterface $repository
     * @param \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface[] $filterPlugins
     * @param \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface[] $expanderPlugins
     * @param \SprykerEco\Zed\Minubo\Business\Writer\WriterInterface $writer
     */
    public function __construct(
        MinuboRepositoryInterface $repository,
        array $filterPlugins,
        array $expanderPlugins,
        WriterInterface $writer
    ) {

        $this->repository = $repository;
        $this->filterPlugins = $filterPlugins;
        $this->expanderPlugins = $expanderPlugins;
        $this->writer = $writer;
    }

    /**
     * @return void
     */
    public function exportData(): void
    {
        $orders = $this->repository
            ->getOrderDataUpdatedSinceLastRun();

        $orders = $this->filterData($orders);

        $orders = $this->expandData($orders);

        $this->writer->writeData($orders, static::FILE_PREFIX);
    }

    /**
     * @param array $orders
     *
     * @return array
     */
    protected function filterData(array $orders): array
    {
        foreach ($orders as $key => $data) {
            foreach ($this->filterPlugins as $filter) {
                $orders[$key] = $filter->filterData($orders[$key]);
            }
        }

        return $orders;
    }

    /**
     * @param array $orders
     *
     * @return array
     */
    protected function expandData(array $orders): array
    {
        foreach ($orders as $key => $data) {
            foreach ($this->expanderPlugins as $expander) {
                $orders[$key] = $expander->expandData($orders[$key]);
            }
        }

        return $orders;
    }
}
