<?php

namespace App\Entity\SvaoPrivate;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SvaoPrivate\ModeloAvionRepository")
 * @ORM\Table(name="modelos_aviones")
 */
class ModeloAvion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\MarcaAvion")
     * @ORM\JoinColumn(nullable=false,name="marca_avion_id")
     */
    private $marca;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\TipoAvion")
     * @ORM\JoinColumn(nullable=false,name="tipo_avion_id")
     */
    private $TipoAvion;

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

    public function getMarca(): ?MarcaAvion
    {
        return $this->marca;
    }

    public function setMarca(?MarcaAvion $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getTipoAvion(): ?TipoAvion
    {
        return $this->TipoAvion;
    }

    public function setTipoAvion(?TipoAvion $TipoAvion): self
    {
        $this->TipoAvion = $TipoAvion;

        return $this;
    }
}
