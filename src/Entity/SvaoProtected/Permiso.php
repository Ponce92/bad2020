<?php

namespace App\Entity\SvaoProtected;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SvaoProtected\PermisoRepository")
 * @ORM\Table(name="permisos")
 */
class Permiso
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grupo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $protegido;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGrupo(): ?string
    {
        return $this->grupo;
    }

    public function setGrupo(string $grupo): self
    {
        $this->grupo = $grupo;

        return $this;
    }

    public function getProtegido(): ?bool
    {
        return $this->protegido;
    }

    public function setProtegido(bool $protegido): self
    {
        $this->protegido = $protegido;

        return $this;
    }
}
