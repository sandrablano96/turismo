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
    private $oficinaTurismo;

    #[ORM\ManyToOne(targetEntity: guiaTurismo::class, inversedBy: 'visitasOrganizadas')]
    private $guiaTurismo;

    #[ORM\Column(type: 'string', length: 20)]
    private $uid;

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

    public function getOficinaTurismo(): ?oficinaTurismo
    {
        return $this->oficinaTurismo;
    }

    public function setOficinaTurismo(?oficinaTurismo $oficinaTurismo): self
    {
        $this->oficinaTurismo = $oficinaTurismo;

        return $this;
    }

    public function getGuiaTurismo(): ?guiaTurismo
    {
        return $this->guiaTurismo;
    }

    public function setGuiaTurismo(?guiaTurismo $GuiaTurismo): self
    {
        $this->guiaTurismo = $GuiaTurismo;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }
}
