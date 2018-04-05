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
class CustomerSecureFieldFilterPlugin extends AbstractPlugin implements MinuboDataFilterInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function filterData(array $data): array
    {
        $secureFields = $this->getConfig()
            ->getCustomerSecureFields();
        foreach ($data as $key => $value) {
            if (in_array($key, $secureFields)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
