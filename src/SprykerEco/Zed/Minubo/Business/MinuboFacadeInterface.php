<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Business;

interface MinuboFacadeInterface
{
    /**
     * Specification:
     *  - Executes all minubo data export plugins.
     *  - Writes date and time of last run to database.
     *
     * @api
     *
     * @return void
     */
    public function exportData();

    /**
     * Specification:
     *  - Reads orders that were updated from last export run.
     *  - Exports order data as json file to S3 bucket.
     *
     * @api
     *
     * @return void
     */
    public function exportOrderData();

    /**
     * Specification:
     *  - Reads customers that were updated from last export run.
     *  - Exports customer data as json file to S3 bucket.
     *
     * @api
     *
     * @return void
     */
    public function exportCustomerData();

    /**
     * Specification:
     *  - Expands order item data with flags that specified to item OMS state.
     *
     * @api
     *
     * @param array $data
     *
     * @return array
     */
    public function expandOrderItemWithStateFlags(array $data): array;
}
