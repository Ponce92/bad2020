<?php

namespace App\Entity\SvaoPrivate;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SvaoPrivate\ReservaRepository")
 * @ORM\Table(name="reserva_vuelo")
 */
class Reserva
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\Cliente")
     * @ORM\JoinColumn(nullable=false,name="cliente_id")
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SvaoPrivate\HorarioVuelo")
     * @ORM\JoinColumn(nullable=false,name="horario_id")
     */
    private $horario;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $estado;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $monto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getHorario(): ?HorarioVuelo
    {
        return $this->horario;
    }

    public function setHorario(?HorarioVuelo $horario): self
    {
        $this->horario = $horario;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): self
    {
        $this->monto = $monto;

        return $this;
    }
}
