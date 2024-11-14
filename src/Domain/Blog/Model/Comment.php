<?php

namespace App\Domain\Blog\Model;

use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\User\Model\CommentAuthor;

#[ORM\Entity]
#[ORM\Table(name: "comments")]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $uuid;

    #[ORM\Column(type: "text")]
    private string $content;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: CommentAuthor::class)]
    #[ORM\JoinColumn(nullable: false)]
    private CommentAuthor $author;

    #[ORM\ManyToOne(targetEntity: BlogPost::class, inversedBy: "comments")]
    #[ORM\JoinColumn(nullable: false)]
    private BlogPost $blogPost;

    public function __construct(string $content, CommentAuthor $author, BlogPost $blogPost)
    {
        $this->uuid      = Uuid::uuid4()->toString(); // Generate UUID
        $this->content   = $content;
        $this->createdAt = new DateTimeImmutable();
        $this->author    = $author;
        $this->blogPost  = $blogPost;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getAuthor(): CommentAuthor
    {
        return $this->author;
    }

    public function getBlogPost(): BlogPost
    {
        return $this->blogPost;
    }
}