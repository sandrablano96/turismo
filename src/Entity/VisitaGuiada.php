<?php

namespace App\Entity;

use App\Repository\VisitaGuiadaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitaGuiadaRepository::class)]
class VisitaGuiada
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $titulo;

    #[ORM\Column(type: 'date')]
    private $fecha;

    #[ORM\Column(type: 'string', length: 255)]
    private $descripcion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $precio;

    #[ORM\ManyToOne(targetEntity: oficinaTurismo::class, inversedBy: 'visitasOrganizadas')]
    private $organizador1;

    #[ORM\ManyToOne(targetEntity: guiaTurismo::class, inversedBy: 'visitasOrganizadas')]
    private $organizador2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(?string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getOrganizador1(): ?oficinaTurismo
    {
        return $this->organizador1;
    }

    public function setOrganizador1(?oficinaTurismo $organizador1): self
    {
        $this->organizador1 = $organizador1;

        return $this;
    }

    public function getOrganizador2(): ?guiaTurismo
    {
        return $this->organizador2;
    }

    public function setOrganizador2(?guiaTurismo $organizador2): self
    {
        $this->organizador2 = $organizador2;

        return $this;
    }
}
