<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \SprykerEco\Zed\Minubo\MinuboConfig getConfig()
 * @method \SprykerEco\Zed\Minubo\Persistence\MinuboEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Minubo\Persistence\MinuboRepositoryInterface getRepository()
 * @method \SprykerEco\Zed\Minubo\Business\MinuboFacadeInterface getFacade()
 */
class MinuboCommunicationFactory extends AbstractCommunicationFactory
{
}
