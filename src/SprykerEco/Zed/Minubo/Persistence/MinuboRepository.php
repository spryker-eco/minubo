<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Persistence;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerAddressTableMap;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Oms\Persistence\Map\SpyOmsOrderProcessTableMap;
use Orm\Zed\Oms\Persistence\Map\SpyOmsTransitionLogTableMap;
use Orm\Zed\ProductBundle\Persistence\Map\SpySalesOrderItemBundleTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderItemTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderTotalsTableMap;
use Orm\Zed\Sales\Persistence\Map\SpySalesShipmentTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Formatter\ArrayFormatter;
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
            ->leftJoinWithSpySalesShipment()
            ->leftJoinWithItem()
            ->useItemQuery(null, Criteria::LEFT_JOIN)
                ->leftJoinWithSalesOrderItemBundle()
                ->leftJoinWithProcess()
                ->leftJoinWithState()
                ->leftJoinWithTransitionLog()
            ->endUse()
            ->leftJoinBillingAddress('BillingAddress')
            ->with('BillingAddress')
            ->leftJoinShippingAddress('ShippingAddress')
            ->with('ShippingAddress')
            ->setFormatter(ArrayFormatter::class);

        if ($lastRunTime) {
            $query->addAnd(SpySalesOrderTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
            $query->addOr(SpySalesOrderTotalsTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
            $query->addOr(SpySalesOrderItemTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
            $query->addOr(SpySalesOrderItemBundleTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
            $query->addOr(SpyOmsOrderProcessTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
            $query->addOr(SpySalesShipmentTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
            $query->addOr(SpyOmsTransitionLogTableMap::COL_CREATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
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
            ->endUse()
            ->setFormatter(ArrayFormatter::class);

        if ($lastRunTime) {
            $query->addAnd(SpyCustomerTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL)
                ->addOr(SpyCustomerAddressTableMap::COL_UPDATED_AT, $lastRunTime, Criteria::GREATER_EQUAL);
        }
        return $query->find()->toArray();
    }
}
