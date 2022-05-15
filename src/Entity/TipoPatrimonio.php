<?php

namespace App\Entity;

use App\Repository\TipoPatrimonioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipoPatrimonioRepository::class)]
class TipoPatrimonio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $tipo;

    #[ORM\OneToMany(mappedBy: 'tipo', targetEntity: Patrimonio::class, orphanRemoval: true)]
    private $listado_patrimonio;

    public function __construct()
    {
        $this->listado_patrimonio = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection<int, Patrimonio>
     */
    public function getListadoPatrimonio(): Collection
    {
        return $this->listado_patrimonio;
    }

    public function addListadoPatrimonio(Patrimonio $listadoPatrimonio): self
    {
        if (!$this->listado_patrimonio->contains($listadoPatrimonio)) {
            $this->listado_patrimonio[] = $listadoPatrimonio;
            $listadoPatrimonio->setTipo($this);
        }

        return $this;
    }

    public function removeListadoPatrimonio(Patrimonio $listadoPatrimonio): self
    {
        if ($this->listado_patrimonio->removeElement($listadoPatrimonio)) {
            // set the owning side to null (unless already changed)
            if ($listadoPatrimonio->getTipo() === $this) {
                $listadoPatrimonio->setTipo(null);
            }
        }

        return $this;
    }
}
