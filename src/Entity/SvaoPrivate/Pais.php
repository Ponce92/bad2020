<?php

namespace App\Entity\SvaoPrivate;

use App\Repository\SvaoPrivate\PaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaisRepository::class)
 * @ORM\Table(name="paises")
 */
class Pais
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",name="codigo")
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255,name="nombre")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SvaoPrivate\Ciudad", mappedBy="pais")
     */
    private $ciudads;

    public function __construct()
    {
        $this->ciudads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(int $codigo): self
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

    /**
     * @return Collection|Ciudad[]
     */
    public function getCiudads(): Collection
    {
        return $this->ciudads;
    }

    public function addCiudad(Ciudad $ciudad): self
    {
        if (!$this->ciudads->contains($ciudad)) {
            $this->ciudads[] = $ciudad;
            $ciudad->setPais($this);
        }

        return $this;
    }

    public function removeCiudad(Ciudad $ciudad): self
    {
        if ($this->ciudads->contains($ciudad)) {
            $this->ciudads->removeElement($ciudad);
            // set the owning side to null (unless already changed)
            if ($ciudad->getPais() === $this) {
                $ciudad->setPais(null);
            }
        }

        return $this;
    }
}
