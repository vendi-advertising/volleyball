<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameNightRepository")
 */
class GameNight
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameWeek", inversedBy="gameNights")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameWeek;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="gameNight", orphanRemoval=true)
     */
    private $games;

    /**
     * @ORM\Column(type="datetime")
     */
    private $gameNightDate;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameWeek(): ?GameWeek
    {
        return $this->gameWeek;
    }

    public function setGameWeek(?GameWeek $gameWeek): self
    {
        $this->gameWeek = $gameWeek;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setGameNight($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getGameNight() === $this) {
                $game->setGameNight(null);
            }
        }

        return $this;
    }

    public function getGameNightDate(): ?\DateTimeInterface
    {
        return $this->gameNightDate;
    }

    public function setGameNightDate(\DateTimeInterface $gameNightDate): self
    {
        $this->gameNightDate = $gameNightDate;

        return $this;
    }
}
