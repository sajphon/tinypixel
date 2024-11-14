<?php

namespace App\Domain\Blog\Model;

use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\User\Model\Author;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'blog_posts')]
class BlogPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Author::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Author $author;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'blogPost', cascade: ['persist', 'remove'])]
    private Collection $comments;

    public function __construct(string $title, string $description, string $content, Author $author)
    {
        $this->uuid        = Uuid::uuid4()->toString(); // Generate UUID
        $this->title       = $title;
        $this->description = $description;
        $this->content     = $content;
        $this->createdAt   = new DateTimeImmutable();
        $this->author      = $author;
        $this->comments    = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): void
    {
        $this->comments->add($comment);
    }
}
