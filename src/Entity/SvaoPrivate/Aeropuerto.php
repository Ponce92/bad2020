<?php

namespace App\Entity\SvaoPrivate;

use App\Repository\SvaoPrivate\AreopuertoRepository;
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
     * @ORM\Column(type="string", length=255, nullable=true,name="cuidad")
     */
    private $cuidad;

    /**
     * @ORM\Column(type="integer",name="pais_id")
     */
    private $pais;

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

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getEncargado(): ?string
    {
        return $this->encargado;
    }

    public function setEncargado(string $encargado): self
    {
        $this->encargado = $encargado;

        return $this;
    }

    public function getBahias(): ?int
    {
        return $this->bahias;
    }

    public function setBahias(int $bahias): self
    {
        $this->bahias = $bahias;

        return $this;
    }

    public function getCuidad(): ?string
    {
        return $this->cuidad;
    }

    public function setCuidad(?string $cuidad): self
    {
        $this->cuidad = $cuidad;

        return $this;
    }

    public function getPais(): ?int
    {
        return $this->pais;
    }

    public function setPais(int $pais): self
    {
        $this->pais = $pais;

        return $this;
    }
}
