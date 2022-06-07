<?php

namespace App\Entity;

use App\Repository\VisitaGuiadaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: OficinaTurismo::class, inversedBy: 'visitasOrganizadas')]
    private $oficinaTurismo;

    #[ORM\ManyToOne(targetEntity: GuiaTurismo::class, inversedBy: 'visitasOrganizadas')]
    private $guiaTurismo;

    #[ORM\Column(type: 'string', length: 20)]
    private $uid;

    #[ORM\OneToMany(mappedBy: 'visitaGuiada', targetEntity: OpinionesVisitasGuiadas::class, orphanRemoval: true)]
    private $opiniones;

    public function __construct()
    {
        $this->opiniones = new ArrayCollection();
    }

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

    public function getOficinaTurismo(): ?OficinaTurismo
    {
        return $this->oficinaTurismo;
    }

    public function setOficinaTurismo(?OficinaTurismo $oficinaTurismo): self
    {
        $this->oficinaTurismo = $oficinaTurismo;

        return $this;
    }

    public function getGuiaTurismo(): ?GuiaTurismo
    {
        return $this->guiaTurismo;
    }

    public function setGuiaTurismo(?GuiaTurismo $GuiaTurismo): self
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

    /**
     * @return Collection<int, OpinionesVisitasGuiadas>
     */
    public function getOpiniones(): Collection
    {
        return $this->opiniones;
    }

    public function addOpinione(OpinionesVisitasGuiadas $opinione): self
    {
        if (!$this->opiniones->contains($opinione)) {
            $this->opiniones[] = $opinione;
            $opinione->setVisitaGuiada($this);
        }

        return $this;
    }

    public function removeOpinione(OpinionesVisitasGuiadas $opinione): self
    {
        if ($this->opiniones->removeElement($opinione)) {
            // set the owning side to null (unless already changed)
            if ($opinione->getVisitaGuiada() === $this) {
                $opinione->setVisitaGuiada(null);
            }
        }

        return $this;
    }
}
