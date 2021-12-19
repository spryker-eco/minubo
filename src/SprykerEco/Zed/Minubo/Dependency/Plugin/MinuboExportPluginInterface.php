<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Minubo\Dependency\Plugin;

interface MinuboExportPluginInterface
{
    /**
     * @api
     *
     * @return void
     */
    public function exportData(): void;
}
