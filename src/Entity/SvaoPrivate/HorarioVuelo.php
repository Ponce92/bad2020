<?php

namespace App\Entity\SvaoPrivate;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SvaoPrivate\HorarioVueloRepository")
 */
class HorarioVuelo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date",name="fecha")
     */
    private $fecha;

    /**
     * @ORM\Column(type="time",name="hora")
     */
    private $hora;

    /**
     * @ORM\Column(type="string", length=3,name="tipo")
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Aeropuerto")
     * @ORM\JoinColumn(nullable=false,name="aeropuerto_id")
     */
    private $aeropuerto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Aerolinea")
     * @ORM\JoinColumn(nullable=false,name="aerolinea_id")
     */
    private $aerolinea;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Vuelo")
     * @ORM\JoinColumn(nullable=false,name="vuelo_id")
     */
    private $vuelo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Avion")
     * @ORM\JoinColumn(nullable=false,name="avion_id")
     */
    private $avion;

    /**
     * @ORM\Column(type="string", length=50,name="estado_vuelo")
     */
    private $estadoVuelo;

    /**
     * @ORM\Column(type="boolean",name="estado")
     */
    private $estado;

    /**
     * @ORM\Column(type="integer",name="gateway")
     */
    private $gateway;

//====================================================================================================================
    public function __construct()
    {
        $this->fecha= new \DateTime(date("Y/m/d")) ;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getAeropuerto(): ?Aeropuerto
    {
        return $this->aeropuerto;
    }

    public function setAeropuerto(?Aeropuerto $aeropuerto): self
    {
        $this->aeropuerto = $aeropuerto;

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

    public function getVuelo(): ?Vuelo
    {
        return $this->vuelo;
    }

    public function setVuelo(?Vuelo $vuelo): self
    {
        $this->vuelo = $vuelo;

        return $this;
    }

    public function getAvion(): ?Avion
    {
        return $this->avion;
    }

    public function setAvion(?Avion $avion): self
    {
        $this->avion = $avion;

        return $this;
    }

    public function getEstadoVuelo(): ?string
    {
        return $this->estadoVuelo;
    }

    public function setEstadoVuelo(string $estadoVuelo): self
    {
        $this->estadoVuelo = $estadoVuelo;

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

    public function getGateway(): ?int
    {
        return $this->gateway;
    }

    public function setGateway(int $gateway): self
    {
        $this->gateway = $gateway;

        return $this;
    }
}
