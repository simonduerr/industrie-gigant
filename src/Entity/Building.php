<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Building
 *
 * @ORM\Table(name="building")
 * @ORM\Entity
 */
class Building
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $category;
    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $price;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $terrains;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getTerrains(): string
    {
        return $this->terrains;
    }

    /**
     * @param string $terrains
     */
    public function setTerrains(string $terrains): void
    {
        $this->terrains = $terrains;
    }
}
