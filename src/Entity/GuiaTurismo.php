<?php

namespace App\Entity;

use App\Repository\GuiaTurismoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuiaTurismoRepository::class)]
class GuiaTurismo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $nombre;

    #[ORM\Column(type: 'string', length: 20)]
    private $telefono;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pagina_web;

    #[ORM\Column(type: 'string', length: 20)]
    private $tipo;

    #[ORM\OneToMany(mappedBy: 'guiaTurismo', targetEntity: VisitaGuiada::class)]
    private $visitasOrganizadas;

    #[ORM\Column(type: 'string', length: 20)]
    private $uid;

    public function __construct()
    {
        $this->visitasOrganizadas = new ArrayCollection();
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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

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

    public function getPaginaWeb(): ?string
    {
        return $this->pagina_web;
    }

    public function setPaginaWeb(?string $pagina_web): self
    {
        $this->pagina_web = $pagina_web;

        return $this;
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
     * @return Collection<int, VisitaGuiada>
     */
    public function getVisitasOrganizadas(): Collection
    {
        return $this->visitasOrganizadas;
    }

    public function addVisitasOrganizada(VisitaGuiada $visitasOrganizada): self
    {
        if (!$this->visitasOrganizadas->contains($visitasOrganizada)) {
            $this->visitasOrganizadas[] = $visitasOrganizada;
            $visitasOrganizada->setGuiaTurismo($this);
        }

        return $this;
    }

    public function removeVisitasOrganizada(VisitaGuiada $visitasOrganizada): self
    {
        if ($this->visitasOrganizadas->removeElement($visitasOrganizada)) {
            // set the owning side to null (unless already changed)
            if ($visitasOrganizada->getGuiaTurismo() === $this) {
                $visitasOrganizada->setGuiaTurismo(null);
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
}
