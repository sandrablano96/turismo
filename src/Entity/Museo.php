<?php

namespace App\Entity;

use App\Repository\MuseoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MuseoRepository::class)]
class Museo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nombre;

    #[ORM\Column(type: 'string', length: 100)]
    private $direccion;

    #[ORM\Column(type: 'string', length: 20)]
    private $telefono;

    #[ORM\Column(type: 'text')]
    private $horario;

    #[ORM\OneToMany(mappedBy: 'museo', targetEntity: PiezaMuseo::class, orphanRemoval: true)]
    private $piezas;

    #[ORM\Column(type: 'string', length: 36)]
    private $uid;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $web;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $precio;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

    #[ORM\Column(type: 'text')]
    private $descripcion;

    public function __construct()
    {
        $this->piezas = new ArrayCollection();
    }

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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getHorario(): ?string
    {
        return $this->horario;
    }

    public function setHorario(string $horario): self
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * @return Collection<int, PiezasMuseo>
     */
    public function getPiezas(): Collection
    {
        return $this->piezas;
    }

    public function addPieza(PiezaMuseo $pieza): self
    {
        if (!$this->piezas->contains($pieza)) {
            $this->piezas[] = $pieza;
            $pieza->setMuseo($this);
        }

        return $this;
    }

    public function removePieza(PiezaMuseo $pieza): self
    {
        if ($this->piezas->removeElement($pieza)) {
            // set the owning side to null (unless already changed)
            if ($pieza->getMuseo() === $this) {
                $pieza->setMuseo(null);
            }
        }

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

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(?string $web): self
    {
        $this->web = $web;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

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
}