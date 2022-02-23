<?php

namespace App\Entity;

use App\Repository\MemoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MemoRepository::class)]
class Memo implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\NotBlank(message: 'name is required')]
    #[Assert\Length(min: '3', minMessage: 'name min 3 characters')]
    private string $name;

    #[ORM\Column(type: 'string', length: 11, nullable: true)]
    #[Assert\Regex('/^[1-9]{1,}[0-9]{2,}$/', message: 'phoneNumber should start with a country code example 31786820080')]
    #[Assert\Length(min: '11', max: '11', maxMessage: 'phoneNumber max length {{ limit }}')]
    private string|null $phoneNumber;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: '255', maxMessage: 'max length {{ limit }}')]
    private string|null $description;

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
            'name' => $this->name,
            'phoneNumber' => $this->phoneNumber,
            'description' => $this->description
        ];
    }
}
