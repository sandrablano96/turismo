<?php

namespace App\Entity;

use App\Repository\ProductoTipicoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoTipicoRepository::class)]
class ProductoTipico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $nombre;

    #[ORM\Column(type: 'text')]
    private $descripcion;

    #[ORM\ManyToOne(targetEntity: gastronomia::class, inversedBy: 'productosTipicos')]
    #[ORM\JoinColumn(nullable: false)]
    private $gastronomia;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getGastronomia(): ?gastronomia
    {
        return $this->gastronomia;
    }

    public function setGastronomia(?gastronomia $gastronomia): self
    {
        $this->gastronomia = $gastronomia;

        return $this;
    }
}
