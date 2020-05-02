<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *  @ORM\Entity(repositoryClass="App\Repository\RolRepository")
 *  @ORM\Table(name="roles")
 * @UniqueEntity("name")
 */
class Rol
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=155,name="cs_name")
     *
     * @Assert\Length(
     *     min=3,
     *     max=30,
     *     minMessage="nombre muy corto"
     *          )
     */
    private $name;

    /**
     * @ORM\Column(type="boolean",name="cb_protected")
     */
    private $protected;

    /**
     * @ORM\Column(type="string", length=255, nullable=true,name="cs_desc")
     * @Assert\Length(
     *     max=30,
     *     maxMessage="Logitud de campo excedida"
     *          )
     */
    private $description;

    public function __construct()
    {
        $this->setDescription('');
        $this->setName('');
        $this->setProtected(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProtected(): ?bool
    {
        return $this->protected;
    }

    public function setProtected(bool $protected): self
    {
        $this->protected = $protected;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
