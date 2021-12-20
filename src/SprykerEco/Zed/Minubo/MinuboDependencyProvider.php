<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Minubo\Communication\Plugin\Expander\StateFlagExpanderPlugin;
use SprykerEco\Zed\Minubo\Communication\Plugin\Filter\CustomerSecureFieldFilterPlugin;
use SprykerEco\Zed\Minubo\Communication\Plugin\MinuboCustomerExportPlugin;
use SprykerEco\Zed\Minubo\Communication\Plugin\MinuboOrderExportPlugin;
use SprykerEco\Zed\Minubo\Dependency\Facade\MinuboToOmsFacadeBridge;
use SprykerEco\Zed\Minubo\Dependency\Service\MinuboToFileSystemServiceBridge;
use SprykerEco\Zed\Minubo\Dependency\Service\MinuboToUtilEncodingServiceBridge;

/**
 * @method \SprykerEco\Zed\Minubo\MinuboConfig getConfig()
 */
class MinuboDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @var string
     */
    public const SERVICE_FILE_SYSTEM = 'SERVICE_FILE_SYSTEM';

    /**
     * @var string
     */
    public const FACADE_OMS = 'FACADE_OMS';

    /**
     * @var string
     */
    public const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';

    /**
     * @var string
     */
    public const PROPEL_QUERY_SALES_ORDER = 'PROPEL_QUERY_SALES_ORDER';

    /**
     * @var string
     */
    public const MINUBO_EXPORT_PLUGINS_STACK = 'MINUBO_EXPORT_PLUGINS_STACK';

    /**
     * @var string
     */
    public const MINUBO_CUSTOMER_DATA_FILTER_PLUGINS_STACK = 'MINUBO_CUSTOMER_DATA_FILTER_PLUGINS_STACK';

    /**
     * @var string
     */
    public const MINUBO_ORDER_DATA_FILTER_PLUGINS_STACK = 'MINUBO_ORDER_DATA_FILTER_PLUGINS_STACK';

    /**
     * @var string
     */
    public const MINUBO_CUSTOMER_DATA_EXPANDER_PLUGINS_STACK = 'MINUBO_CUSTOMER_DATA_EXPANDER_PLUGINS_STACK';

    /**
     * @var string
     */
    public const MINUBO_ORDER_DATA_EXPANDER_PLUGINS_STACK = 'MINUBO_ORDER_DATA_EXPANDER_PLUGINS_STACK';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addEncodingService($container);
        $container = $this->addFileSystemService($container);
        $container = $this->addOmsFacade($container);
        $container = $this->addExportPlugins($container);
        $container = $this->addCustomerDataFilterPlugins($container);
        $container = $this->addOrderDataFilterPlugins($container);
        $container = $this->addCustomerDataExpanderPlugins($container);
        $container = $this->addOrderDataExpanderPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = $this->addCustomerQuery($container);
        $container = $this->addSalesOrderQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new MinuboToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFileSystemService(Container $container): Container
    {
        $container->set(static::SERVICE_FILE_SYSTEM, function (Container $container) {
            return new MinuboToFileSystemServiceBridge($container->getLocator()->fileSystem()->service());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOmsFacade(Container $container): Container
    {
        $container->set(static::FACADE_OMS, function (Container $container) {
            return new MinuboToOmsFacadeBridge($container->getLocator()->oms()->facade());
        });

        return $container;
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected function getCustomerQuery(): SpyCustomerQuery
    {
        return SpyCustomerQuery::create();
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addCustomerQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_CUSTOMER, function (Container $container) {
            return $this->getCustomerQuery();
        });

        return $container;
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
     */
    protected function getSalesOrderQuery(): SpySalesOrderQuery
    {
        return SpySalesOrderQuery::create();
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addSalesOrderQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_SALES_ORDER, function (Container $container) {
            return $this->getSalesOrderQuery();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addExportPlugins(Container $container): Container
    {
        $container->set(static::MINUBO_EXPORT_PLUGINS_STACK, function (Container $container) {
            return $this->getMinuboExportPluginStack();
        });

        return $container;
    }

    /**
     * @return array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboExportPluginInterface>
     */
    protected function getMinuboExportPluginStack(): array
    {
        return [
            new MinuboCustomerExportPlugin(),
            new MinuboOrderExportPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerDataFilterPlugins($container): Container
    {
        $container->set(static::MINUBO_CUSTOMER_DATA_FILTER_PLUGINS_STACK, function (Container $container) {
            return $this->getCustomerDataFilterPluginStack();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOrderDataFilterPlugins($container): Container
    {
        $container->set(static::MINUBO_ORDER_DATA_FILTER_PLUGINS_STACK, function (Container $container) {
            return $this->getOrderDataFilterPluginStack();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerDataExpanderPlugins($container): Container
    {
        $container->set(static::MINUBO_CUSTOMER_DATA_EXPANDER_PLUGINS_STACK, function (Container $container) {
            return $this->getCustomerDataExpanderPluginStack();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOrderDataExpanderPlugins($container): Container
    {
        $container->set(static::MINUBO_ORDER_DATA_EXPANDER_PLUGINS_STACK, function (Container $container) {
            return $this->getOrderDataExpanderPluginStack();
        });

        return $container;
    }

    /**
     * @return array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface>
     */
    protected function getCustomerDataFilterPluginStack(): array
    {
        return [
            new CustomerSecureFieldFilterPlugin(),
        ];
    }

    /**
     * @return array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface>
     */
    protected function getOrderDataFilterPluginStack(): array
    {
        return [];
    }

    /**
     * @return array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface>
     */
    protected function getCustomerDataExpanderPluginStack(): array
    {
        return [];
    }

    /**
     * @return array<\SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface>
     */
    protected function getOrderDataExpanderPluginStack(): array
    {
        return [
            new StateFlagExpanderPlugin(),
        ];
    }
}
