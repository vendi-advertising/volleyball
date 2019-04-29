<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DayOfWeek", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dayOfWeek;

    /**
     * @ORM\Column(type="smallint")
     */
    private $teamNumber;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="teams")
     */
    private $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
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

    public function getDayOfWeek(): ?DayOfWeek
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(?DayOfWeek $dayOfWeek): self
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getTeamNumber(): ?int
    {
        return $this->teamNumber;
    }

    public function setTeamNumber(int $teamNumber): self
    {
        $this->teamNumber = $teamNumber;

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
            $game->addTeam($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            $game->removeTeam($this);
        }

        return $this;
    }
}
