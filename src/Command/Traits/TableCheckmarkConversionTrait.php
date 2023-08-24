<?php

namespace Bytes\CommandBundle\Command\Traits;

trait TableCheckmarkConversionTrait
{
    private function boolToCheckmarkNullIsBlank(?bool $value): string
    {
        if (is_null($value)) {
            return '➖';
        }

        return $value ? '✔' : '❌';
    }

    private function boolToCheckmark(?bool $value): string
    {
        if (is_null($value)) {
            return '❗';
        }

        return $value ? '✔' : '❌';
    }

    private function nullToCheckmark($value): string
    {
        if (is_null($value)) {
            return '➖';
        }

        return $value;
    }
}
