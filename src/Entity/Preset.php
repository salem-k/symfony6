<?php

namespace App\Entity;

use App\Repository\PresetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PresetRepository::class)
 */
class Preset
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity=preset::class, inversedBy="video")
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity=Presetline::class, mappedBy="preset_id")
     */
    private $presetlines;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
