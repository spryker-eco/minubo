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
use SprykerEco\Zed\Minubo\Communication\Plugin\Filter\CustomerCountryAddressesFieldFilterPlugin;
use SprykerEco\Zed\Minubo\Communication\Plugin\Filter\CustomerSecureFieldFilterPlugin;
use SprykerEco\Zed\Minubo\Communication\Plugin\Filter\RecursionFieldFilterPlugin;
use SprykerEco\Zed\Minubo\Communication\Plugin\MinuboCustomerExportPlugin;
use SprykerEco\Zed\Minubo\Communication\Plugin\MinuboOrderExportPlugin;
use SprykerEco\Zed\Minubo\Dependency\Facade\MinuboToOmsFacadeBridge;
use SprykerEco\Zed\Minubo\Dependency\Service\MinuboToFileSystemServiceBridge;
use SprykerEco\Zed\Minubo\Dependency\Service\MinuboToUtilEncodingServiceBridge;

class MinuboDependencyProvider extends AbstractBundleDependencyProvider
{
    const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';
    const SERVICE_FILE_SYSTEM = 'SERVICE_FILE_SYSTEM';

    const FACADE_OMS = 'FACADE_OMS';

    const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';
    const PROPEL_QUERY_SALES_ORDER = 'PROPEL_QUERY_SALES_ORDER';

    const MINUBO_EXPORT_PLUGINS_STACK = 'MINUBO_EXPORT_PLUGINS_STACK';

    const MINUBO_CUSTOMER_DATA_FILTER_PLUGINS_STACK = 'MINUBO_CUSTOMER_DATA_FILTER_PLUGINS_STACK';
    const MINUBO_ORDER_DATA_FILTER_PLUGINS_STACK = 'MINUBO_ORDER_DATA_FILTER_PLUGINS_STACK';

    const MINUBO_CUSTOMER_DATA_EXPANDER_PLUGINS_STACK = 'MINUBO_CUSTOMER_DATA_EXPANDER_PLUGINS_STACK';
    const MINUBO_ORDER_DATA_EXPANDER_PLUGINS_STACK = 'MINUBO_ORDER_DATA_EXPANDER_PLUGINS_STACK';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
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
    public function providePersistenceLayerDependencies(Container $container)
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
        $container[static::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new MinuboToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFileSystemService(Container $container): Container
    {
        $container[static::SERVICE_FILE_SYSTEM] = function (Container $container) {
            return new MinuboToFileSystemServiceBridge($container->getLocator()->fileSystem()->service());
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOmsFacade(Container $container): Container
    {
        $container[static::FACADE_OMS] = function (Container $container) {
            return new MinuboToOmsFacadeBridge($container->getLocator()->oms()->facade());
        };
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addCustomerQuery(Container $container)
    {
        $container[static::PROPEL_QUERY_CUSTOMER] = function (Container $container) {
            return SpyCustomerQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addSalesOrderQuery(Container $container)
    {
        $container[static::PROPEL_QUERY_SALES_ORDER] = function (Container $container) {
            return SpySalesOrderQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addExportPlugins(Container $container)
    {
        $container[static::MINUBO_EXPORT_PLUGINS_STACK] = function (Container $container) {
            return $this->getMinuboExportPluginStack();
        };

        return $container;
    }

    /**
     * @return \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboExportPluginInterface[]
     */
    protected function getMinuboExportPluginStack()
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
    protected function addCustomerDataFilterPlugins($container)
    {
        $container[static::MINUBO_CUSTOMER_DATA_FILTER_PLUGINS_STACK] = function (Container $container) {
            return $this->getCustomerDataFilterPluginStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOrderDataFilterPlugins($container)
    {
        $container[static::MINUBO_ORDER_DATA_FILTER_PLUGINS_STACK] = function (Container $container) {
            return $this->getOrderDataFilterPluginStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerDataExpanderPlugins($container)
    {
        $container[static::MINUBO_CUSTOMER_DATA_EXPANDER_PLUGINS_STACK] = function (Container $container) {
            return $this->getCustomerDataExpanderPluginStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOrderDataExpanderPlugins($container)
    {
        $container[static::MINUBO_ORDER_DATA_EXPANDER_PLUGINS_STACK] = function (Container $container) {
            return $this->getOrderDataExpanderPluginStack();
        };

        return $container;
    }

    /**
     * @return \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface[]
     */
    protected function getCustomerDataFilterPluginStack()
    {
        return [
            new CustomerSecureFieldFilterPlugin(),
            new CustomerCountryAddressesFieldFilterPlugin(),
            new RecursionFieldFilterPlugin(),
        ];
    }

    /**
     * @return \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface[]
     */
    protected function getOrderDataFilterPluginStack()
    {
        return [
            new RecursionFieldFilterPlugin(),
        ];
    }

    /**
     * @return \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface[]
     */
    protected function getCustomerDataExpanderPluginStack()
    {
        return [];
    }

    /**
     * @return \SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataExpanderInterface[]
     */
    protected function getOrderDataExpanderPluginStack()
    {
        return [
            new StateFlagExpanderPlugin(),
        ];
    }
}
