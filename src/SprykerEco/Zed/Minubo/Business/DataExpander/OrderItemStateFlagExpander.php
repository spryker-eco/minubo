<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace SprykerEco\Zed\Minubo\Business\DataExpander;

use SprykerEco\Zed\Minubo\Dependency\Facade\MinuboToOmsFacadeInterface;

class OrderItemStateFlagExpander implements OrderItemStateFlagExpanderInterface
{
    const KEY_ITEMS = 'Items';
    const KEY_PROCESS = 'Process';
    const KEY_STATE = 'State';
    const KEY_NAME = 'Name';
    const KEY_OMS_STATE_FLAGS = 'OmsStateFlags';

    /**
     * @var array
     */
    protected static $stateFlags;

    /**
     * @var \SprykerEco\Zed\Minubo\Dependency\Facade\MinuboToOmsFacadeInterface
     */
    protected $omsFacade;

    /**
     * @param \SprykerEco\Zed\Minubo\Dependency\Facade\MinuboToOmsFacadeInterface $omsFacade
     */
    public function __construct(MinuboToOmsFacadeInterface $omsFacade)
    {
        $this->omsFacade = $omsFacade;
        static::$stateFlags = [];
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function expandOrderItemWithStateFlags(array $data): array
    {
        foreach ($data[static::KEY_ITEMS] as $key => $item) {
            $processName = $item[static::KEY_PROCESS][static::KEY_NAME];
            $stateName = $item[static::KEY_STATE][static::KEY_NAME];
            $data[static::KEY_ITEMS][$key][static::KEY_OMS_STATE_FLAGS] = $this->getOmsStateFlags($processName, $stateName);
        }
        return $data;
    }

    /**
     * @param string $processName
     * @param string $stateName
     *
     * @return array
     */
    protected function getOmsStateFlags(string $processName, string $stateName): array
    {
        if (!isset(static::$stateFlags[$processName])) {
            static::$stateFlags[$processName] = [];
        }

        if (!isset(static::$stateFlags[$processName][$stateName])) {
            static::$stateFlags[$processName][$stateName] = $this->omsFacade->getStateFlags($processName, $stateName);
        }

        return static::$stateFlags[$processName][$stateName];
    }
}
