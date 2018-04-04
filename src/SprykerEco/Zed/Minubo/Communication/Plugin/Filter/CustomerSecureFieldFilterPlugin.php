<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Minubo\Communication\Plugin\Filter;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\Minubo\Dependency\Plugin\MinuboDataFilterInterface;

/**
 * @method \SprykerEco\Zed\Minubo\Communication\MinuboCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Minubo\Business\MinuboFacadeInterface getFacade()
 */
class CustomerSecureFieldFilterPlugin extends AbstractPlugin implements MinuboDataFilterInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function filterData(array $data): array
    {
        $secureFields = $this->getFactory()
            ->getConfig()
            ->getCustomerSecureFields();
        foreach ($data as $key => $value) {
            if (in_array($key, $secureFields)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
