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

    #[ORM\ManyToOne(targetEntity: Gastronomia::class, inversedBy: 'productosTipicos')]
    #[ORM\JoinColumn(nullable: false)]
    private $gastronomia;

    #[ORM\Column(type: 'string', length: 20)]
    private $uid;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

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

    public function getGastronomia(): ?Gastronomia
    {
        return $this->gastronomia;
    }

    public function setGastronomia(?Gastronomia $gastronomia): self
    {
        $this->gastronomia = $gastronomia;

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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

}
