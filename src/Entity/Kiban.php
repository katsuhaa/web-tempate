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

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $update_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $partsno;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $serialno;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $goodproduct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $furikae;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nxtperson;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $assignee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $person;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $memo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $assigned;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPartsno(): ?string
    {
        return $this->partsno;
    }

    public function setPartsno(string $partsno): self
    {
        $this->partsno = $partsno;

        return $this;
    }

    public function getSerialno(): ?string
    {
        return $this->serialno;
    }

    public function setSerialno(?string $serialno): self
    {
        $this->serialno = $serialno;

        return $this;
    }

    public function getGoodproduct(): ?string
    {
        return $this->goodproduct;
    }

    public function setGoodproduct(?string $goodproduct): self
    {
        $this->goodproduct = $goodproduct;

        return $this;
    }

    public function getFurikae(): ?string
    {
        return $this->furikae;
    }

    public function setFurikae(?string $furikae): self
    {
        $this->furikae = $furikae;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getNxtperson(): ?string
    {
        return $this->nxtperson;
    }

    public function setNxtperson(?string $nxtperson): self
    {
        $this->nxtperson = $nxtperson;

        return $this;
    }

    public function getAssignee(): ?string
    {
        return $this->assignee;
    }

    public function setAssignee(?string $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(?string $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getMemo(): ?string
    {
        return $this->memo;
    }

    public function setMemo(?string $memo): self
    {
        $this->memo = $memo;

        return $this;
    }

    public function isAssigned(): ?bool
    {
        return $this->assigned;
    }

    public function setAssigned(?bool $assigned): self
    {
        $this->assigned = $assigned;

        return $this;
    }
}
