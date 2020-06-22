<?php
/**
 * Wallet Entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WalletRepository")
 */
class Wallet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $balance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Action", mappedBy="wallet", orphanRemoval=true)
     *
     */
    private $Actions;

    /**
     * Wallet constructor.
     */
    public function __construct()
    {
        $this->Actions = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
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
     * @return int|null
     */
    public function getBalance(): ?int
    {
        return $this->balance;
    }

    /**
     * @return $this
     */
    public function setBalance(array $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->Actions;
    }

    /**
     * @return $this
     */
    public function addAction(Action $action): self
    {
        if (!$this->Actions->contains($action)) {
            $this->Actions[] = $action;
            $action->setWallet($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeAction(Action $action): self
    {
        if ($this->Actions->contains($action)) {
            $this->Actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getWallet() === $this) {
                $action->setWallet(null);
            }
        }

        return $this;
    }

    /**
     * Generates the magic method.
     */
    public function __toString()
    {
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
