<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\PresetRepository;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Presetline::class, mappedBy="preset_id")
     */
    private $presetlines;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $forecolor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fontsize;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $positionx;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $positiony;

    /**
     * @ORM\ManyToOne(targetEntity=video::class, inversedBy="video_id")
     */
    private $video;

    public function __construct()
    {
        $this->presetlines = new ArrayCollection();
    }

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
    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getForecolor(): ?string
    {
        return $this->forecolor;
    }

    public function setForecolor(?string $forecolor): self
    {
        $this->forecolor = $forecolor;

        return $this;
    }

    public function getFontsize(): ?string
    {
        return $this->fontsize;
    }

    public function setFontsize(?string $fontsize): self
    {
        $this->fontsize = $fontsize;

        return $this;
    }

    public function getPositionx(): ?int
    {
        return $this->positionx;
    }

    public function setPositionx(?int $positionx): self
    {
        $this->positionx = $positionx;

        return $this;
    }

    public function getPositiony(): ?int
    {
        return $this->positiony;
    }

    public function setPositiony(?int $positiony): self
    {
        $this->positiony = $positiony;

        return $this;
    }

    public function getVideo(): ?video
    {
        return $this->video;
    }

    public function setVideo(?video $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return Collection<int, Presetline>
     */
    public function getPresetlines(): Collection
    {
        return $this->presetlines;
    }

    public function addPresetline(Presetline $presetline): self
    {
        if (!$this->presetlines->contains($presetline)) {
            $this->presetlines[] = $presetline;
            $presetline->setPresetId($this);
        }

        return $this;
    }

    public function removePresetline(Presetline $presetline): self
    {
        if ($this->presetlines->removeElement($presetline)) {
            // set the owning side to null (unless already changed)
            if ($presetline->getPresetId() === $this) {
                $presetline->setPresetId(null);
            }
        }

        return $this;
    }

}
