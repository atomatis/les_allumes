<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: CategoryType::class)]
    #[ORM\OrderBy(['name'])]
    private CategoryType $categoryType;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategoryType(): CategoryType
    {
        return $this->categoryType;
    }

    public function setCategoryType(CategoryType $categoryType): self
    {
        $this->categoryType = $categoryType;

        return $this;
    }
}
