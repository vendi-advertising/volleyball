<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameNight", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameNight;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Team", inversedBy="games")
     */
    private $teams;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $time;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameNight(): ?GameNight
    {
        return $this->gameNight;
    }

    public function setGameNight(?GameNight $gameNight): self
    {
        $this->gameNight = $gameNight;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }
}
