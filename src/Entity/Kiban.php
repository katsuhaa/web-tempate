<?php

namespace App\Entity;

use App\Repository\KibanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KibanRepository::class)
 */
class Kiban
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $various;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $order_data;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $due_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $stock_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVarious(): ?string
    {
        return $this->various;
    }

    public function setVarious(string $various): self
    {
        $this->various = $various;

        return $this;
    }

    public function getOrderData(): ?\DateTimeInterface
    {
        return $this->order_data;
    }

    public function setOrderData(?\DateTimeInterface $order_data): self
    {
        $this->order_data = $order_data;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->due_date;
    }

    public function setDueDate(?\DateTimeInterface $due_date): self
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function getStockDate(): ?\DateTimeInterface
    {
        return $this->stock_date;
    }

    public function setStockDate(?\DateTimeInterface $stock_date): self
    {
        $this->stock_date = $stock_date;

        return $this;
    }
}
