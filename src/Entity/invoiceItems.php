<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'invoice_items')]
class invoiceItems
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: Types::STRING)]
    private string $description;

    #[ORM\Column(type: Types::INTEGER)]
    private int $quantity;

    #[ORM\Column(name: 'unit_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $unitPrice;

    #[ORM\ManyToOne(targetEntity: invoices::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'invoice_id', referencedColumnName: 'id', nullable: false)]
    private invoices $invoice;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function getInvoice(): invoices
    {
        return $this->invoice;
    }

    public function setInvoice(invoices $invoice): void
    {
        $this->invoice = $invoice;
    }
}