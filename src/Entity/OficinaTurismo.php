<?php

namespace App\Entity;

use App\Repository\OficinaTurismoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OficinaTurismoRepository::class)]
class OficinaTurismo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $direccion;

    #[ORM\Column(type: 'string', length: 20)]
    private $telefono;

    #[ORM\Column(type: 'string', length: 100)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $horario;

    #[ORM\OneToMany(mappedBy: 'organizador1', targetEntity: VisitaGuiada::class)]
    private $visitasOrganizadas;

    #[ORM\Column(type: 'string', length: 20)]
    private $uid;

    #[ORM\Column(type: 'string', length: 100)]
    private $localidad;

    public function __construct()
    {
        $this->visitasOrganizadas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $visitasOrganizada->setOrganizador1($this);
        }

        return $this;
    }

    public function removeVisitasOrganizada(VisitaGuiada $visitasOrganizada): self
    {
        if ($this->visitasOrganizadas->removeElement($visitasOrganizada)) {
            // set the owning side to null (unless already changed)
            if ($visitasOrganizada->getOrganizador1() === $this) {
                $visitasOrganizada->setOrganizador1(null);
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

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }
}
