<?php

namespace App\Entity;

use App\Repository\GastronomiaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GastronomiaRepository::class)]
class Gastronomia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $descripcion;

    #[ORM\OneToMany(mappedBy: 'gastronomia', targetEntity: ProductoTipico::class, orphanRemoval: true)]
    private $productosTipicos;

    #[ORM\Column(type: 'string', length: 20)]
    private $uid;

    #[ORM\OneToOne(targetEntity: ProductoTipico::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private $productoMes;


    public function __construct()
    {
        $this->productosTipicos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, ProductoTipico>
     */
    public function getProductosTipicos(): Collection
    {
        return $this->productosTipicos;
    }

    public function addProductosTipico(ProductoTipico $productosTipico): self
    {
        if (!$this->productosTipicos->contains($productosTipico)) {
            $this->productosTipicos[] = $productosTipico;
            $productosTipico->setGastronomia($this);
        }

        return $this;
    }

    public function removeProductosTipico(ProductoTipico $productosTipico): self
    {
        if ($this->productosTipicos->removeElement($productosTipico)) {
            // set the owning side to null (unless already changed)
            if ($productosTipico->getGastronomia() === $this) {
                $productosTipico->setGastronomia(null);
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

    public function getProductoMes(): ?ProductoTipico
    {
        return $this->productoMes;
    }

    public function setProductoMes(ProductoTipico $productoMes): self
    {
        $this->productoMes = $productoMes;

        return $this;
    }
}