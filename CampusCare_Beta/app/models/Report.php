<?php

declare(strict_types=1);

// OOP: Report memodelkan satu laporan; property private menjaga encapsulation.
class Report
{
    private int|string $id;
    private string $category;
    private string $title;
    private string $location;
    private string $description;
    private ?string $image;
    private string $status;
    private string $date;
    private string $createdAt;

    public function __construct(
        int|string $id = 0,
        string $category = 'Umum',
        string $title = '',
        string $location = '-',
        string $description = '',
        ?string $image = null,
        string $status = 'Menunggu',
        ?string $date = null,
        ?string $createdAt = null
    ) {
        $this->id = $id;
        $this->category = $category;
        $this->title = $title;
        $this->location = $location;
        $this->description = $description;
        $this->image = $image;
        $this->status = $status;
        $this->date = $date ?? date('Y-m-d');
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category,
            'title' => $this->title,
            'location' => $this->location,
            'description' => $this->description,
            'image' => $this->image,
            'status' => $this->status,
            'date' => $this->date,
            'createdAt' => $this->createdAt,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? time(),
            (string) ($data['category'] ?? 'Umum'),
            (string) ($data['title'] ?? ''),
            (string) ($data['location'] ?? '-'),
            (string) ($data['description'] ?? ''),
            $data['image'] ?? null,
            (string) ($data['status'] ?? 'Menunggu'),
            $data['date'] ?? null,
            $data['createdAt'] ?? null,
        );
    }
}
