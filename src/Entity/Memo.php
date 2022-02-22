<?php

namespace App\Entity;

use App\Repository\MemoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemoRepository::class)]
class Memo implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\NotBlank(message: 'name is required')]
    private $name;

    #[ORM\Column(type: 'string', length: 11, nullable: true)]
    #[Assert\Regex('/^[1-9]{1,}[0-9]{2,}$/', message: 'phoneNumber should start with a Net number')]
    #[Assert\Length(min: '11', max: '11', maxMessage: 'phoneNumber max length {{ limit }}')]
    private $phoneNumber;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: '255', maxMessage: 'max length {{ limit }}')]
    private $description;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phoneNumber' => $this->phoneNumber,
            'description' => $this->description
        ];
    }
}
