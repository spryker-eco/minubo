<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Persistence;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerAddressTableMap;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Oms\Persistence\Map\SpyOmsOrderProcessTableMap;
use Orm\Zed\ProductBundle\Persistence\Map\SpySalesOrderItemBundleTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderAddressTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderItemTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderTotalsTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesShipmentTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerEco\Zed\Minubo\Persistence\MinuboPersistenceFactory getFactory()
 */
class MinuboRepository extends AbstractRepository implements MinuboRepositoryInterface
{
    const LAST_RUN_DATETIME_FORMAT = 'Y-m-d H:i:s.u';

    /**
     * @return null|string
     */
    public function getLastMinuboRunTime(): ?string
    {
        $lastRun = $this->getFactory()
            ->createMinuboRunQuery()
            ->orderByRanAt(Criteria::DESC)
            ->findOne();

        if ($lastRun) {
            return $lastRun->getRanAt(static::LAST_RUN_DATETIME_FORMAT);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getOrderDataUpdatedSinceLastRun(): array
    {
        $lastRunTime = $this->getLastMinuboRunTime();

        $query = $this->getFactory()
            ->getSalesOrderQuery()
            ->leftJoinWithOrderTotal()
            ->leftJoinWithLocale()
            ->leftJoinWithItem()
            ->leftJoinWithSpySalesShipment()
            ->useItemQuery(null, Criteria::LEFT_JOIN)
                ->leftJoinWithSalesOrderItemBundle()
                ->leftJoinWithProcess()
                ->leftJoinWithState()
            ->endUse()
            ->leftJoinBillingAddress('BillingAddress')
            ->with('BillingAddress')
            ->leftJoinShippingAddress('ShippingAddress')
            ->with('ShippingAddress');

        if ($lastRunTime) {
            $query->addAnd(SpySalesOrderTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL)
                ->addOr(SpySalesOrderTotalsTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL)
                ->addOr(SpySalesOrderItemTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL)
                ->addOr(SpySalesOrderAddressTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL)
                ->addOr(SpySalesOrderItemBundleTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL)
                ->addOr(SpyOmsOrderProcessTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL)
                ->addOr(SpySalesShipmentTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
        }

        return $query->find()->toArray();
    }

    /**
     * @return array
     */
    public function getCustomerDataUpdatedSinceLastRun(): array
    {
        $lastRunTime = $this->getLastMinuboRunTime();

        $query = $this->getFactory()
            ->getCustomerQuery()
            ->leftJoinWithLocale()
            ->leftJoinWithAddress()
            ->useAddressQuery(null, Criteria::LEFT_JOIN)
                ->leftJoinWithRegion()
                ->leftJoinWithCountry()
            ->endUse();

        if ($lastRunTime) {
            $query->addAnd(SpyCustomerTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL)
                ->addOr(SpyCustomerAddressTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
        }
        return $query->find()->toArray();
    }
}
