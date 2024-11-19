<?php

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ContainerInterface;

if (! function_exists('container')) {
    /**
     * 获取容器实例.
     */
    function container(): \Psr\Container\ContainerInterface
    {
        return ApplicationContext::getContainer();
    }
}

if (! function_exists('t')) {
    /**
     * 多语言函数.
     */
    function t(string $key, array $replace = []): string
    {
        return \Hyperf\Translation\__($key, $replace, "");
    }
}

if (! function_exists('blank')) {
    /**
     * 判断给定的值是否为空.
     */
    function blank(mixed $value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (! function_exists('filled')) {
    /**
     * 判断给定的值是否不为空.
     */
    function filled(mixed $value): bool
    {
        return ! blank($value);
    }
}