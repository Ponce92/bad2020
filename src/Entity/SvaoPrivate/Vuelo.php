<?php

namespace App\Entity\SvaoPrivate;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SvaoPrivate\VueloRepository")
 * @ORM\Table(name="vuelos")
 */
class Vuelo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $codigo;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Aerolinea")
     * @ORM\JoinColumn(nullable=false,name="aerolinea_id")
     */
    private $aerolinea;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Ciudad")
     * @ORM\JoinColumn(nullable=false,name="ciudad_origen_id")
     */
    private $origen;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Ciudad")
     * @ORM\JoinColumn(nullable=false,name="ciudad_destino_id")
     */
    private $destino;

    /**
     * @ORM\Column(type="integer",name="tiempo_vuelo")
     */
    private $tiempoVuelo;

    /**
     * @ORM\Column(type="float",name="costo_viaje")
     */
    private $costoViaje;

    /**
     * @ORM\Column(type="float",name="precio_vuelo")
     */
    private $precio;

    /**
     * @ORM\Column(type="integer",name="millas_real")
     */
    private $millasReal;

    /**
     * @ORM\Column(type="integer",name="millas_asignables")
     */
    private $millasAsignables;

    public function __construct()
    {
        $this->tipo = new ArrayCollection();
    }

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

    public function setEstado(bool $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getOrigen(): ?Ciudad
    {
        return $this->origen;
    }

    public function setOrigen(?Ciudad $origen): self
    {
        $this->origen = $origen;

        return $this;
    }

    public function getDestino(): ?Ciudad
    {
        return $this->destino;
    }

    public function setDestino(?Ciudad $destino): self
    {
        $this->destino = $destino;

        return $this;
    }

    public function getTiempoVuelo(): ?int
    {
        return $this->tiempoVuelo;
    }

    public function setTiempoVuelo(int $tiempoVuelo): self
    {
        $this->tiempoVuelo = $tiempoVuelo;

        return $this;
    }

    public function getCostoViaje(): ?float
    {
        return $this->costoViaje;
    }

    public function setCostoViaje(float $costoViaje): self
    {
        $this->costoViaje = $costoViaje;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getMillasReal(): ?int
    {
        return $this->millasReal;
    }

    public function setMillasReal(int $millasReal): self
    {
        $this->millasReal = $millasReal;

        return $this;
    }

    public function getMillasAsignables(): ?int
    {
        return $this->millasAsignables;
    }

    public function setMillasAsignables(int $millasAsignables): self
    {
        $this->millasAsignables = $millasAsignables;

        return $this;
    }
}
