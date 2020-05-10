<?php

namespace App\Entity\SvaoPrivate;

use App\Repository\SvaoPrivate\PaisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaisRepository::class)
 * @ORM\Table(name="paises")
 */
class Pais
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",name="codigo")
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255,name="nombre")
     */
    private $nombre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
}
