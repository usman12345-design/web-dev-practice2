<?php

namespace App\Entity;

use App\Enums\InvoiceStatus;
// 🟢 CRITICAL: Import the Mapping namespace
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'invoices')]
class invoices
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $amount;

    #[ORM\Column(name: 'invoice_number')]
    private string $invoiceNumber;

    // 🟢 ENUM FIX: Tell Doctrine how to store your Enum (usually as a string or string-backed enum)
    #[ORM\Column(type: 'string', enumType: InvoiceStatus::class)]
    private InvoiceStatus $status;

    #[ORM\Column(name: 'created_at')]
    private \DateTime $createdAt;

    #[ORM\OneToMany(targetEntity: invoiceItems::class, mappedBy: 'invoice', cascade: ['persist', 'remove'])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): invoices
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): invoices
    {
        $this->amount = $amount;
        return $this;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): invoices
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function getStatus(): InvoiceStatus
    {
        return $this->status;
    }

    public function setStatus(InvoiceStatus $status): invoices
    {
        $this->status = $status;
        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItems(invoiceItems $items): invoices
    {
        $items->setInvoice($this);
        $this->items->add($items);
        return $this;
    }
}