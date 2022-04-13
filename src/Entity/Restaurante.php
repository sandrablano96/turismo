<?php

namespace App\Entity;

use App\Repository\RestauranteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestauranteRepository::class)]
class Restaurante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nombre;

    #[ORM\Column(type: 'string', length: 200)]
    private $direccion;

    #[ORM\Column(type: 'string', length: 20)]
    private $tipoCocina;

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

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTipoCocina(): ?string
    {
        return $this->tipoCocina;
    }

    public function setTipoCocina(string $tipoCocina): self
    {
        $this->tipoCocina = $tipoCocina;

        return $this;
    }
}
