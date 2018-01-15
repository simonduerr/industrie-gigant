<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuiltObject
 *
 * @ORM\Table(name="built_object")
 * @ORM\Entity
 */
class BuiltObject
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
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $object;
    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $type;
    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $level;

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
    public function getObject(): int
    {
        return $this->object;
    }

    /**
     * @param int $object
     */
    public function setObject(int $object): void
    {
        $this->object = $object;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }
}
