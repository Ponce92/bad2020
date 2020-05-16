<?php

namespace App\Entity\SvaoPrivate;

use App\Repository\SvaoPrivate\ClienteRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClienteRepository::class)
 * @ORM\Table(name="clientes")
 * @UniqueEntity("nombres")
 */
class Cliente
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,name="nombres")
     */
    private $nombres;

    /**
     * @ORM\Column(type="string", length=255, nullable=true,name="apellidos")
     */
    private $apellidos;

    /**
     * @ORM\Column(type="string", length=500, nullable=true,name="direccion")
     */
    private $direccion;

    /**
     * @ORM\Column(type="integer", nullable=true,name="tel_fijo")
     */
    private $fijo;

    /**
     * @ORM\Column(type="integer", nullable=true,name="tel_movil")
     */
    private $movil;

    /**
     * @ORM\Column(type="string", length=50, nullable=true,name="tipo_doc")
     */
    private $tipoDoc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true,name="nombre_contacto")
     */
    private $encargado;

    /**
     * @ORM\Column(type="string", length=50, nullable=true,name="nit")
     */
    private $nit;

    /**
     * @ORM\Column(type="string", length=50, nullable=true,name="nic")
     */
    private $nic;

    /**
     * @ORM\Column(type="string", length=50, nullable=true,name="numero_documento")
     */
    private $documento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getFijo(): ?int
    {
        return $this->fijo;
    }

    public function setFijo(?int $fijo): self
    {
        $this->fijo = $fijo;

        return $this;
    }

    public function getMovil(): ?int
    {
        return $this->movil;
    }

    public function setMovil(?int $movil): self
    {
        $this->movil = $movil;

        return $this;
    }

    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    public function setTipoDoc(?string $tipoDoc): self
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    public function getEncargado(): ?string
    {
        return $this->encargado;
    }

    public function setEncargado(?string $encargado): self
    {
        $this->encargado = $encargado;

        return $this;
    }

    public function getNit(): ?string
    {
        return $this->nit;
    }

    public function setNit(?string $nit): self
    {
        $this->nit = $nit;

        return $this;
    }

    public function getNic(): ?string
    {
        return $this->nic;
    }

    public function setNic(?string $nic): self
    {
        $this->nic = $nic;

        return $this;
    }

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(?string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }
}
