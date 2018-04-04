<?php

use Spryker\Service\FlysystemAws3v3FileSystem\Plugin\Flysystem\Aws3v3FilesystemBuilderPlugin;
use Spryker\Shared\FileSystem\FileSystemConstants;
use SprykerEco\Shared\Minubo\MinuboConstants;

$config[FileSystemConstants::FILESYSTEM_SERVICE] = [
    'minubo' => [
        'sprykerAdapterClass' => Aws3v3FilesystemBuilderPlugin::class,
        'root' => '/minubo/',
        'path' => 'data/',
        'key' => '..',
        'secret' => '..',
        'bucket' => '..',
        'version' => 'latest',
        'region' => '..',
    ],
];

$config[MinuboConstants::MINUBO_FILE_SYSTEM_NAME] = 'minubo';
$config[MinuboConstants::MINUBO_BUCKET_DIRECTORY] = '/minubo/data/';
$config[MinuboConstants::MINUBO_CUSTOMER_SECURE_FIELDS] = [
    'Password',
    'RestorePasswordKey',
    'RestorePasswordDate',
    'RegistrationKey',
];
$config[MinuboConstants::MINUBO_RECURSION_VALUE] = '*RECURSION*';
