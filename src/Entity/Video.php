<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use App\Validator as VideoAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 * @UniqueEntity(
 *     fields={"address","trick"},
 *     message="Cette vidéo est déjà présente dans ce trick !",
 *     errorPath="address")
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * exemple of value :  https://www.youtube.com/embed/WTHr-Gn9mpq.
     *
     * @ORM\Column(type="string", length=41)
     * @Assert\NotBlank(message="Entrez une vidéo valide, avec url youtube au format embed")
     * @VideoAssert\IsYoutubeUrl
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    // default values automatically added
    public function __construct()
    {
        $this->setCreated(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
