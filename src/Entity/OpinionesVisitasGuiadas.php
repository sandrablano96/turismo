<?php

namespace App\Entity;

use App\Repository\OpinionesVisitasGuiadasRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpinionesVisitasGuiadasRepository::class)]
class OpinionesVisitasGuiadas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 36)]
    private $uid;

    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'opiniones')]
    #[ORM\JoinColumn(nullable: false)]
    private $usuario;

    #[ORM\ManyToOne(targetEntity: VisitaGuiada::class, inversedBy: 'opiniones')]
    #[ORM\JoinColumn(nullable: false)]
    private $visitaGuiada;

    #[ORM\Column(type: 'string', length: 255)]
    private $opinion;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $fecha;

    public function __construct()
    {
        $this->fecha= new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getVisitaGuiada(): ?VisitaGuiada
    {
        return $this->visitaGuiada;
    }

    public function setVisitaGuiada(?VisitaGuiada $visitaGuiada): self
    {
        $this->visitaGuiada = $visitaGuiada;

        return $this;
    }

    public function getOpinion(): ?string
    {
        return $this->opinion;
    }

    public function setOpinion(string $opinion): self
    {
        $this->opinion = $opinion;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(): self
    {
        $this->fecha = new DateTime();

        return $this;
    }
}
