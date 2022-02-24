<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="category", orphanRemoval=true)
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity=SearchByCategory::class, mappedBy="Category")
     */
    private $searchByCategories;

    

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->searchByCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection|Produit[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Produit $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Produit $product): self
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SearchByCategory[]
     */
    public function getSearchByCategories(): Collection
    {
        return $this->searchByCategories;
    }

    public function addSearchByCategory(SearchByCategory $searchByCategory): self
    {
        if (!$this->searchByCategories->contains($searchByCategory)) {
            $this->searchByCategories[] = $searchByCategory;
            $searchByCategory->setCategory($this);
        }

        return $this;
    }

    public function removeSearchByCategory(SearchByCategory $searchByCategory): self
    {
        if ($this->searchByCategories->removeElement($searchByCategory)) {
            // set the owning side to null (unless already changed)
            if ($searchByCategory->getCategory() === $this) {
                $searchByCategory->setCategory(null);
            }
        }

        return $this;
    }

   
}