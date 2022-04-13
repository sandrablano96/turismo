<?php

namespace App\Entity;

use App\Repository\PiezaMuseoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PiezaMuseoRepository::class)]
class PiezaMuseo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $titulo;

    #[ORM\Column(type: 'text', nullable: true)]
    private $descripcion;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

    #[ORM\ManyToOne(targetEntity: museo::class, inversedBy: 'piezas')]
    #[ORM\JoinColumn(nullable: false)]
    private $museo;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getMuseo(): ?museo
    {
        return $this->museo;
    }

    public function setMuseo(?museo $museo): self
    {
        $this->museo = $museo;

        return $this;
    }
}
