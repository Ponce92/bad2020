<?php

namespace App\Entity\SvaoPrivate;

use App\Repository\SvaoPrivate\AeropuertoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=AeropuertoRepository::class)
 * @ORM\Table(name="aeropuertos")
 * @UniqueEntity("codigo")
 */
class Aeropuerto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=150,name="nombre")
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer",name="telefono")
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=150,name="nombre_encargado")
     */
    private $encargado;

    /**
     * @ORM\Column(type="integer",name="numero_bahias")
     */
    private $bahias;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Pais")
     * @ORM\JoinColumn(nullable=false,name="pais_id")
     */
    private $pais;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Ciudad")
     * @ORM\JoinColumn(nullable=false,name="cuidad_id")
     */
    private $ciudad;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estado;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;

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

    public function getBahias(): ?int
    {
        return $this->bahias;
    }

    public function setBahias(?int $bahias): self
    {
        $this->bahias = $bahias;

        return $this;
    }

    public function getPais(): ?Pais
    {
        return $this->pais;
    }

    public function setPais(?Pais $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getCiudad(): ?Ciudad
    {
        return $this->ciudad;
    }

    public function setCiudad(?Ciudad $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

}
