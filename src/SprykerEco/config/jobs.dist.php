<?php

$jobs = $jobs ?? [];

// Export order and customer data to Minubo every 15 minutes
$jobs[] = [
    'name' => 'minubo-export',
    'command' => '$PHP_BIN vendor/bin/console minubo:export:data',
    'schedule' => '*/15 * * * *',
    'enable' => true,
    'run_on_non_production' => false,
    'stores' => ['DE'],
];
