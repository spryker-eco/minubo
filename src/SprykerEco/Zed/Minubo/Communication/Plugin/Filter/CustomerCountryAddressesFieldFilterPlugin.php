<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace SprykerEco\Zed\Minubo\Communication\Plugin\Filter;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface;

/**
 * @method \SprykerEco\Zed\Minubo\MinuboConfig getConfig()
 * @method \SprykerEco\Zed\Minubo\Communication\MinuboCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Minubo\Business\MinuboFacadeInterface getFacade()
 */
class CustomerCountryAddressesFieldFilterPlugin extends AbstractPlugin implements MinuboDataFilterInterface
{
    protected const KEY_ADDRESSES = 'Addresses';
    protected const KEY_COUNTRY = 'Country';
    protected const KEY_CUSTOMER_ADDRESSES = 'CustomerAddresses';
    /**
     * @param array $data
     *
     * @return array
     */
    public function filterData(array $data): array
    {
        if (array_key_exists(static::KEY_ADDRESSES, $data)) {
            foreach ($data[static::KEY_ADDRESSES] as $key => $address) {
                if (array_key_exists(static::KEY_COUNTRY, $address)) {
                    unset($data[static::KEY_ADDRESSES][$key][static::KEY_COUNTRY][static::KEY_CUSTOMER_ADDRESSES]);
                }
            }
        }

        return $data;
    }
}
