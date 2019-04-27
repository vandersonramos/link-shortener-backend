<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinksRepository")
 */
class Links
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $url_full;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_shorter;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlFull(): ?string
    {
        return $this->url_full;
    }

    public function setUrlFull(string $url_full): self
    {
        $this->url_full = $url_full;

        return $this;
    }

    public function getUrlShorter(): ?string
    {
        return $this->url_shorter;
    }

    public function setUrlShorter(string $url_shorter): self
    {
        $this->url_shorter = $url_shorter;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function incrementViews()
    {
        $views = $this->getViews() + 1;
        $this->setViews($views);
    }
}
