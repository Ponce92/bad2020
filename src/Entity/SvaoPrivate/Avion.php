<?php

namespace App\Entity\SvaoPrivate;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SvaoPrivate\AvionRepository")
 * @ORM\Table(name="aviones")
 */
class Avion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\TipoAvion")
     * @ORM\JoinColumn(nullable=false,name="tipo_avion_id")
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\ModeloAvion")
     * @ORM\JoinColumn(nullable=false,name="modelo_avion_id")
     */
    private $modelo;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\MarcaAvion")
     * @ORM\JoinColumn(nullable=false,name="marca_avion_id")
     */
    private $marca;

    /**
     * @ORM\Column(type="string", length=12,name="codigo")
     */
    private $codigo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Aerolinea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aerolinea;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $estado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?TipoAvion
    {
        return $this->tipo;
    }

    public function setTipo(?TipoAvion $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getModelo(): ?ModeloAvion
    {
        return $this->modelo;
    }

    public function setModelo(?ModeloAvion $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getCapacidad(): ?int
    {
        return $this->capacidad;
    }

    public function setCapacidad(int $capacidad): self
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    public function getMarca(): ?MarcaAvion
    {
        return $this->marca;
    }

    public function setMarca(?MarcaAvion $marca): self
    {
        $this->marca = $marca;

        return $this;
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

    public function getAerolinea(): ?Aerolinea
    {
        return $this->aerolinea;
    }

    public function setAerolinea(?Aerolinea $aerolinea): self
    {
        $this->aerolinea = $aerolinea;

        return $this;
    }

    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(?bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
