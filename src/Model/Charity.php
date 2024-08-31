<?php
declare(strict_types=1);

namespace App\Model;

class Charity
{
    public function __construct(
        private readonly int $id,
        private string       $name,
        private string       $email
    )
    {
        $this->setName($name);
        $this->setEmail($email);
    }

    public function setName(string $name): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Name cannot be empty.");
        }
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format.");
        }
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
