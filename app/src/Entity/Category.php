<?php
/**
 * Category Entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Action", mappedBy="category")
     */
    private $actions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Action", mappedBy="category")
     */
    private $action;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->actions = new ArrayCollection();
        $this->action = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    /**
     * @return $this
     */
    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setCategory($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getCategory() === $this) {
                $action->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getAction(): Collection
    {
        return $this->action;
    }

    /**
     * Generates the magic method.
     */
    public function __toString()
    {
        return $this->name;
    }
}
