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
    private $elaboración;

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

    public function getElaboración(): ?string
    {
        return $this->elaboración;
    }

    public function setElaboración(string $elaboración): self
    {
        $this->elaboración = $elaboración;

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
