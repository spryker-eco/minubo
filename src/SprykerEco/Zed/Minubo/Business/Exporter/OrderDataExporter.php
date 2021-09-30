<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
    protected $repository;

    /**
     * @var array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface>
     */
    protected $filterPlugins;

    /**
     * @var array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface>
     */
    protected $expanderPlugins;

    /**
     * @var \SprykerEco\Zed\Minubo\Business\Writer\WriterInterface
     */
    protected $writer;

    /**
     * @param \SprykerEco\Zed\Minubo\Persistence\MinuboRepositoryInterface $repository
     * @param array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface> $filterPlugins
     * @param array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface> $expanderPlugins
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
     * @param array<mixed> $orders
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
     * @param array<mixed> $orders
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
