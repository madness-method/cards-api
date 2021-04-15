<?php

namespace App\Entity;

use App\Repository\MatchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatchRepository::class)
 */
class Match
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
    private $user_name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $user_score;

    /**
     * @ORM\Column(type="smallint")
     */
    private $cpu_score;

    /**
     * @ORM\Column(type="boolean")
     */
    private $user_win;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getUserScore(): ?int
    {
        return $this->user_score;
    }

    public function setUserScore(int $user_score): self
    {
        $this->user_score = $user_score;

        return $this;
    }

    public function getCpuScore(): ?int
    {
        return $this->cpu_score;
    }

    public function setCpuScore(int $cpu_score): self
    {
        $this->cpu_score = $cpu_score;

        return $this;
    }

    public function getUserWin(): ?bool
    {
        return $this->user_win;
    }

    public function setUserWin(bool $user_win): self
    {
        $this->user_win = $user_win;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
