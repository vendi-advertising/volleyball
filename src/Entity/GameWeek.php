<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameWeekRepository")
 */
class GameWeek
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $weekNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameNight", mappedBy="gameWeek", orphanRemoval=true)
     */
    private $gameNights;

    /**
     * @ORM\Column(type="datetime")
     */
    private $weekStartDate;

    public function __construct()
    {
        $this->gameNights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeekNumber(): ?int
    {
        return $this->weekNumber;
    }

    public function setWeekNumber(int $weekNumber): self
    {
        $this->weekNumber = $weekNumber;

        return $this;
    }

    /**
     * @return Collection|GameNight[]
     */
    public function getGameNights(): Collection
    {
        return $this->gameNights;
    }

    public function addGameNight(GameNight $gameNight): self
    {
        if (!$this->gameNights->contains($gameNight)) {
            $this->gameNights[] = $gameNight;
            $gameNight->setGameWeek($this);
        }

        return $this;
    }

    public function removeGameNight(GameNight $gameNight): self
    {
        if ($this->gameNights->contains($gameNight)) {
            $this->gameNights->removeElement($gameNight);
            // set the owning side to null (unless already changed)
            if ($gameNight->getGameWeek() === $this) {
                $gameNight->setGameWeek(null);
            }
        }

        return $this;
    }

    public function getWeekStartDate(): ?\DateTimeInterface
    {
        return $this->weekStartDate;
    }

    public function setWeekStartDate(\DateTimeInterface $weekStartDate): self
    {
        $this->weekStartDate = $weekStartDate;

        return $this;
    }

    public function __toString()
    {
        return sprintf('Week #%1$d', $this->getWeekNumber());
    }
}
