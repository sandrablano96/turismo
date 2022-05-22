<?php

namespace App\Entity;

use App\Repository\HistoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriaRepository::class)]
class Historia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $historia;

    #[ORM\Column(type: 'string', length: 20)]
    private $uid;

    #[ORM\OneToMany(mappedBy: 'historia', targetEntity: HistoriaImagenes::class, orphanRemoval: true)]
    private $galeriaImagenes;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

    public function __construct()
    {
        $this->galeriaImagenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHistoria(): ?string
    {
        return $this->historia;
    }

    public function setHistoria(string $historia): self
    {
        $this->historia = $historia;

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

    /**
     * @return Collection<int, HistoriaImagenes>
     */
    public function getGaleriaImagenes(): Collection
    {
        return $this->galeriaImagenes;
    }

    public function addGaleriaImagene(HistoriaImagenes $galeriaImagenes): self
    {
        if (!$this->galeriaImagenes->contains($galeriaImagenes)) {
            $this->galeriaImagenes[] = $galeriaImagenes;
            $galeriaImagenes->setHistoria($this);
        }

        return $this;
    }

    public function removeGaleriaImagene(HistoriaImagenes $galeriaImagenes): self
    {
        if ($this->galeriaImagenes->removeElement($galeriaImagenes)) {
            // set the owning side to null (unless already changed)
            if ($galeriaImagenes->getHistoria() === $this) {
                $galeriaImagenes->setHistoria(null);
            }
        }

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
