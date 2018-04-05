<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Business\Exporter;

use SprykerEco\Zed\Minubo\Business\Writer\WriterInterface;
use SprykerEco\Zed\Minubo\Persistence\MinuboRepositoryInterface;

class CustomerDataExporter implements DataExporterInterface
{
    const FILE_PREFIX = 'Customers';

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
        $customers = $this->repository
            ->getCustomerDataUpdatedSinceLastRun();

        $customers = $this->filterData($customers);

        $customers = $this->expandData($customers);

        $this->writer->writeData($customers, static::FILE_PREFIX);
    }

    /**
     * @param array $customers
     *
     * @return array
     */
    protected function filterData(array $customers): array
    {
        foreach ($customers as $key => $data) {
            foreach ($this->filterPlugins as $filter) {
                $customers[$key] = $filter->filterData($customers[$key]);
            }
        }

        return $customers;
    }

    /**
     * @param array $customers
     *
     * @return array
     */
    protected function expandData(array $customers): array
    {
        foreach ($customers as $key => $data) {
            foreach ($this->expanderPlugins as $expander) {
                $customers[$key] = $expander->expandData($customers[$key]);
            }
        }

        return $customers;
    }
}
