<?php

namespace App\Entity\SvaoPrivate;

use App\Repository\SvaoPrivate\AerolineaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AerolineaRepository::class)
 * @ORM\Table(name="aerolineas")
 * @UniqueEntity("codigo")
 */
class Aerolinea
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6,name="codigo")
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255,name="nombre_oficial")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=150,name="nombre_corto")
     */
    private $nombreCorto;

    /**
     * @ORM\Column(type="string", length=150,name="nombre_rep")
     */
    private $nombreEncargado;

    /**
     * @ORM\Column(type="string", length=255,name="pagina_web")
     */
    private $paginaWeb;

    /**
     * @ORM\Column(type="string", length=255,name="correo")
     */
    private $correo;

    /**
     * @ORM\Column(type="date",name="fecha_fundacion")
     */
    private $fechaFundacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Pais")
     * @ORM\JoinColumn(nullable=false,name="pais_id")
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

    public function getNombreCorto(): ?string
    {
        return $this->nombreCorto;
    }

    public function setNombreCorto(string $nombreCorto): self
    {
        $this->nombreCorto = $nombreCorto;

        return $this;
    }

    public function getNombreEncargado(): ?string
    {
        return $this->nombreEncargado;
    }

    public function setNombreEncargado(string $nombreEncargado): self
    {
        $this->nombreEncargado = $nombreEncargado;

        return $this;
    }

    public function getPaginaWeb(): ?string
    {
        return $this->paginaWeb;
    }

    public function setPaginaWeb(string $paginaWeb): self
    {
        $this->paginaWeb = $paginaWeb;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getFechaFundacion(): ?\DateTimeInterface
    {
        return $this->fechaFundacion;
    }

    public function setFechaFundacion(\DateTimeInterface $fechaFundacion): self
    {
        $this->fechaFundacion = $fechaFundacion;

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
}
