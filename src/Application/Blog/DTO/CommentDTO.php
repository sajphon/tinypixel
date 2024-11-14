<?php

namespace App\Application\Blog\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CommentDTO
{
    #[Assert\NotBlank(message: 'Name is required.')]
    #[Assert\Length(
        max       : 255,
        maxMessage: 'Name cannot exceed {{ limit }} characters.'
    )]
    public string $authorName;

    #[Assert\NotBlank(message: 'Email is required.')]
    #[Assert\Email(message: 'Invalid email format.')]
    public string $authorEmail;

    #[Assert\NotBlank(message: 'Comment content is required.')]
    #[Assert\Length(
        min       : 5,
        minMessage: 'Comment must be at least {{ limit }} characters long.'
    )]
    public string $content;
}
