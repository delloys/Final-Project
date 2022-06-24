<?php

namespace App\Entity;

use App\Repository\BookEditionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookEditionRepository::class)]
class BookEdition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $yearEdition;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $part;

    #[ORM\OneToMany(mappedBy: 'bookEdition', targetEntity: Book::class, orphanRemoval: true)]
    private $book;

    public function __construct()
    {
        $this->book = new ArrayCollection();
    }

public function __toString() {
    return $this->yearEdition;
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYearEdition(): ?int
    {
        return $this->yearEdition;
    }

    public function setYearEdition(int $yearEdition): self
    {
        $this->yearEdition = $yearEdition;

        return $this;
    }

    public function getPart(): ?string
    {
        return $this->part;
    }

    public function setPart(?string $part): self
    {
        $this->part = $part;

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
            $book->setBookEdition($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->book->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getBookEdition() === $this) {
                $book->setBookEdition(null);
            }
        }

        return $this;
    }
}
