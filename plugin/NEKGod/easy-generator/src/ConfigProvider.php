<?php
namespace Plugin\NEK\CodeGenerator;


class ConfigProvider
{
    public function __invoke()
    {
        // Initial configuration
        return [
            // 合并到  config/autoload/annotations.php 文件
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'swagger'   =>  [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ]
            ]
        ];
    }
}