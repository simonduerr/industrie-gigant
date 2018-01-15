<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tile
 *
 * @ORM\Table(name="tile")
 * @ORM\Entity
 */
class Tile
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
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $x;
    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $y;
    /**
     * @var int|null
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $built_object;
    /**
     * @var int|null
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $terrain;
    /**
     * @var int|null
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $resource;
    /**
     * @var int|null
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $infrastructure;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    /**
     * @return int|null
     */
    public function getBuiltObject(): ?int
    {
        return $this->built_object;
    }

    /**
     * @param int $built_object
     */
    public function setBuiltObject(?int $built_object): void
    {
        $this->built_object = $built_object;
    }

    /**
     * @return int|null
     */
    public function getTerrain(): ?int
    {
        return $this->terrain;
    }

    /**
     * @param int $terrain
     */
    public function setTerrain(?int $terrain): void
    {
        $this->terrain = $terrain;
    }

    /**
     * @return int|null
     */
    public function getResource(): ?int
    {
        return $this->resource;
    }

    /**
     * @param int $resource
     */
    public function setResource(?int $resource): void
    {
        $this->resource = $resource;
    }

    /**
     * @return int|null
     */
    public function getInfrastructure(): ?int
    {
        return $this->infrastructure;
    }

    /**
     * @param int|null $infrastructure
     */
    public function setInfrastructure(?int $infrastructure): void
    {
        $this->infrastructure = $infrastructure;
    }
}
