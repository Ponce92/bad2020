<?php

namespace App\Entity\SvaoProtected;
use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Aeropuerto;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Entity\Rol;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SvaoProtected\UsuarioRepository")
 * @ORM\Table(name="usuarios")
 * @UniqueEntity("nombre")
 */
class Usuario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", length=50,name="username")
     */
    private $nombre;

    /**
     *
     * @ORM\Column(type="string", length=255,name="password")
     */
    private $password;

    /**
     * @ORM\Column(type="date",name="fecha_creacion")
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="date",name="ultima_edicion")
     */
    private $fechaEdicion;

    /**
     * @ORM\Column(type="date", nullable=true,name="ultimo_logueo")
     */
    private $fechaUltimoAcesso;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Rol", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false,name="rol_id")
     */
    private $rol;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Aerolinea")
     * @ORM\JoinColumn(name="aerolinea_id")
     */
    private $aerolinea;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Aeropuerto")
     * @ORM\JoinColumn(name="aeropuerto_id")
     */
    private $aeropuerto;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    public function getFechaEdicion(): ?\DateTimeInterface
    {
        return $this->fechaEdicion;
    }

    public function setFechaEdicion(\DateTimeInterface $fechaEdicion): self
    {
        $this->fechaEdicion = $fechaEdicion;

        return $this;
    }

    public function getFechaUltimoAcesso(): ?\DateTimeInterface
    {
        return $this->fechaUltimoAcesso;
    }

    public function setFechaUltimoAcesso(?\DateTimeInterface $fechaUltimoAcesso): self
    {
        $this->fechaUltimoAcesso = $fechaUltimoAcesso;

        return $this;
    }

    public function getRol(): ?Rol
    {
        return $this->rol;
    }

    public function setRol(Rol $rol): self
    {
        $this->rol = $rol;

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

    public function getAeropuerto(): ?Aeropuerto
    {
        return $this->aeropuerto;
    }

    public function setAeropuerto(?Aeropuerto $aeropuerto): self
    {
        $this->aeropuerto = $aeropuerto;

        return $this;
    }
}
