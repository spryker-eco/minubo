<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Persistence;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Minubo\Persistence\SpyMinuboRunQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use SprykerEco\Zed\Minubo\MinuboDependencyProvider;

/**
 * @method \SprykerEco\Zed\Minubo\MinuboConfig getConfig()
 */
class MinuboPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Minubo\Persistence\SpyMinuboRunQuery
     */
    public function createMinuboRunQuery()
    {
        return new SpyMinuboRunQuery();
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(MinuboDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function getSalesOrderQuery(): SpySalesOrderQuery
    {
        return $this->getProvidedDependency(MinuboDependencyProvider::PROPEL_QUERY_SALES_ORDER);
    }
}
