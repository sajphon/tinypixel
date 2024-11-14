<?php

namespace App\Application\Blog\DTO;

use App\Domain\User\Model\Author;
use Symfony\Component\Validator\Constraints as Assert;

class BlogPostDTO
{
    #[Assert\NotBlank(message: 'Title is required.')]
    #[Assert\Length(
        max       : 255,
        maxMessage: 'Title cannot be longer than {{ limit }} characters.'
    )]
    public string $title;

    #[Assert\NotBlank(message: 'Description is required.')]
    #[Assert\Length(
        min       : 10,
        minMessage: 'Description must be at least {{ limit }} characters long.'
    )]
    public string $description;

    #[Assert\NotBlank(message: 'Content is required.')]
    #[Assert\Length(
        min       : 50,
        minMessage: 'Content must be at least {{ limit }} characters long.'
    )]
    public string $content;

    #[Assert\NotBlank(message: 'Select an author.')]
    public ?Author $author = null;

    public function __construct(
        string  $title = '',
        string  $description = '',
        string  $content = '',
        ?Author $author = null
    )
    {
        $this->title       = $title;
        $this->description = $description;
        $this->content     = $content;
        $this->author      = $author;
    }
}