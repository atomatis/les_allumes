<?php

declare(strict_types=1);

namespace App\Entity;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
// For twig template
interface CrudInterface
{
    public function getId(): int;
    public function getName(): string;
    public static function getEntityName(): string;
}
