<?php

declare(strict_types=1);

namespace App\Helper;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class CrudHelper
{
    public static function generateReadRouteName(string $className): string
    {
        return sprintf('app_admin_create_%s', $className::getEntityName());
    }
}
