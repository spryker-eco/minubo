<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \SprykerEco\Zed\Minubo\Business\MinuboFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Minubo\Persistence\MinuboRepositoryInterface getRepository()
 * @method \SprykerEco\Zed\Minubo\Communication\MinuboCommunicationFactory getFactory()
 */
class MinuboConsole extends Console
{
    /**
     * @var string
     */
    public const COMMAND_NAME = 'minubo:export:data';

    /**
     * @var string
     */
    public const DESCRIPTION = 'Run export of data to Minubo';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $this->getFacade()
            ->exportData();

        return static::CODE_SUCCESS;
    }
}
