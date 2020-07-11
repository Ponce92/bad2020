<?php

namespace App\Entity\SvaoProtected;

use App\Repository\SvaoProtected\AccionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccionsRepository::class)
 * @ORM\Table(name="auditoria")
 */
class Accions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,name="nombre_tabla")
     *
     */
    private $tabla;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $usuario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $accion;

    /**
     * @ORM\Column(type="string",name="fecha")
     */
    private $fecha;

    /**
     * @ORM\Column(type="integer",name="obj_id")
     */
    private $obj;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTabla(): ?string
    {
        return $this->tabla;
    }

    public function setTabla(string $tabla): self
    {
        $this->tabla = $tabla;

        return $this;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getAccion(): ?string
    {
        return $this->accion;
    }

    public function setAccion(string $accion): self
    {
        $this->accion = $accion;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getObj(): ?int
    {
        return $this->obj;
    }

    public function setObj(int $obj): self
    {
        $this->obj = $obj;

        return $this;
    }
}
