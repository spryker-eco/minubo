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
class RecursionFieldFilterPlugin extends AbstractPlugin implements MinuboDataFilterInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function filterData(array $data): array
    {
        return $this->unsetRecursionFields($data);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function unsetRecursionFields(array $data): array
    {
        $recursionValue = $this->getFactory()
            ->getConfig()
            ->getRecursionValue();
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                $data[$key] = $this->unsetRecursionFields($item);
                continue;
            }
            if ($item === $recursionValue) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
