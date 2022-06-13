<?php

namespace App\Entity;

use App\Repository\HistoriaImagenesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriaImagenesRepository::class)]
class HistoriaImagenes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 36)]
    private $uid;

    #[ORM\ManyToOne(targetEntity: Historia::class, inversedBy: 'galeriaImagenes')]
    #[ORM\JoinColumn(nullable: false)]
    private $historia;

    #[ORM\Column(type: 'string', length: 255)]
    private $archivo;

    #[ORM\Column(type: 'string', length: 255)]
    private $alt;

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

    public function getHistoria(): ?Historia
    {
        return $this->historia;
    }

    public function setHistoria(?Historia $historia): self
    {
        $this->historia = $historia;

        return $this;
    }

    public function getArchivo(): ?string
    {
        return $this->archivo;
    }

    public function setArchivo(string $archivo): self
    {
        $this->archivo = $archivo;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }
}
