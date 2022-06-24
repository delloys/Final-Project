<?php

namespace App\Entity;

use App\Repository\BookStorageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookStorageRepository::class)]
class BookStorage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cabinet;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $closet;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $shelf;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $link;

    #[ORM\OneToMany(mappedBy: 'bookStorage', targetEntity: Book::class)]
    private $book;

    public function __construct()
    {
        $this->book = new ArrayCollection();
    }

public function __toString() {
    return $this->closet;
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCabinet(): ?string
    {
        return $this->cabinet;
    }

    public function setCabinet(?string $cabinet): self
    {
        $this->cabinet = $cabinet;

        return $this;
    }

    public function getCloset(): ?string
    {
        return $this->closet;
    }

    public function setCloset(?string $closet): self
    {
        $this->closet = $closet;

        return $this;
    }

    public function getShelf(): ?string
    {
        return $this->shelf;
    }

    public function setShelf(?string $shelf): self
    {
        $this->shelf = $shelf;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBook(): Collection
    {
        return $this->book;
    }

    public function addBook(Book $book): self
    {
        if (!$this->book->contains($book)) {
            $this->book[] = $book;
            $book->setBookStorage($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->book->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getBookStorage() === $this) {
                $book->setBookStorage(null);
            }
        }

        return $this;
    }
}
