<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: BookEdition::class, inversedBy: 'book')]
    #[ORM\JoinColumn(nullable: false)]
    private $bookEdition;

    #[ORM\ManyToOne(targetEntity: BookType::class, inversedBy: 'book')]
    private $bookType;

    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'book')]
    private $authors;

    #[ORM\ManyToOne(targetEntity: BookStorage::class, inversedBy: 'book')]
    private $bookStorage;

    #[ORM\Column(type: 'string', length: 255)]
    private $bookName;

//    #[ORM\Column(type: 'string', length: 255)]
 //   private $nameBook;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

public function __toString() {
    return $this->bookName;
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookEdition(): ?BookEdition
    {
        return $this->bookEdition;
    }

    public function setBookEdition(?BookEdition $bookEdition): self
    {
        $this->bookEdition = $bookEdition;

        return $this;
    }

    public function getBookType(): ?BookType
    {
        return $this->bookType;
    }

    public function setBookType(?BookType $bookType): self
    {
        $this->bookType = $bookType;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
            $author->addBook($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }

    public function getBookStorage(): ?BookStorage
    {
        return $this->bookStorage;
    }

    public function setBookStorage(?BookStorage $bookStorage): self
    {
        $this->bookStorage = $bookStorage;

        return $this;
    }

    public function getBookName(): ?string
    {
        return $this->bookName;
    }

    public function setBookName(string $bookName): self
    {
        $this->bookName = $bookName;

        return $this;
    }

//    public function getNameBook(): ?string
   // {
//        return $this->nameBook;
//    }

//    public function setNameBook(string $nameBook): self
//    {
//        $this->nameBook = $nameBook;
//
  //      return $this;
   // }
}
