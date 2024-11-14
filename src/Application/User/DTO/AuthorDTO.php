<?php

namespace App\Application\User\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class AuthorDTO
{
    #[Assert\NotBlank(message: 'Name is required.')]
    #[Assert\Length(max: 255, maxMessage: 'Name cannot exceed 255 characters.')]
    public string $name;

    #[Assert\NotBlank(message: 'Email is required.')]
    #[Assert\Email(message: 'Invalid email format.')]
    #[Assert\Length(max: 255, maxMessage: 'Email cannot exceed 255 characters.')]
    public string $email;
}
