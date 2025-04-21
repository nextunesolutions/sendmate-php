<?php

namespace SendMate;

interface Currency {
    public function getCode(): string;
    public function getName(): string;
    public function getSymbol(): string;
    public function isActive(): bool;
}

interface Recipient {
    public function getId(): string;
    public function getName(): string;
    public function getPhoneNumber(): string;
    public function getEmail(): ?string;
    public function getMetadata(): array;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
}

interface Transaction {
    public function getId(): string;
    public function getAmount(): string;
    public function getType(): string;
    public function getStatus(): string;
    public function getDescription(): string;
    public function getReference(): string;
    public function isMoneyIn(): bool;
    public function isMoneyOut(): bool;
    public function getCurrency(): Currency;
    public function getMetadata(): array;
    public function getRecipient(): ?Recipient;
    public function getRecipients(): array;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
}

interface Wallet {
    public function getId(): string;
    public function getCurrency(): Currency;
    public function getTransactions(): array;
    public function getBalance(): string;
    public function isDefault(): bool;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
}

interface PaginatedResponse {
    public function getCount(): int;
    public function getNext(): ?string;
    public function getPrevious(): ?string;
    public function getCurrentPage(): int;
    public function getTotalPages(): int;
    public function getResults(): array;
}

interface PaginationParams {
    public function getPage(): ?int;
    public function getPerPage(): ?int;
}

interface TransactionPaginatedResponse extends PaginatedResponse {
    public function getResults(): array; // Array of Transaction
} 