<?php

namespace App\Controller;

use App\Model\Charity;
use App\Utils\CsvFileHandler;

class CharityController
{
    private CsvFileHandler $csvHandler;

    public function __construct(
        private readonly string $charityFilePath,
        private int             $charityIdCounter = 1,
        private array           $charities = []
    )
    {
        $this->csvHandler = new CsvFileHandler($this->charityFilePath);
        $this->loadCharities();
    }

    private function loadCharities(): void
    {
        $data = $this->csvHandler->loadData();

        foreach ($data as $row) {
            list($id, $name, $email) = $row;
            $this->charities[(int)$id] = new Charity((int)$id, $name, $email);
            $this->charityIdCounter = max($this->charityIdCounter, (int)$id + 1);
        }
    }

    public function addCharity(string $name, string $email): void
    {
        $charity = new Charity($this->charityIdCounter, $name, $email);
        $this->charities[$charity->getId()] = $charity;
        $this->saveAllCharities();
        $this->charityIdCounter++;
    }

    private function saveAllCharities(): void
    {
        $data = [];

        foreach ($this->charities as $charity) {
            $data[] = [
                $charity->getId(),
                $charity->getName(),
                $charity->getEmail()
            ];
        }

        $header = ['ID', 'Name', 'Representative Email'];
        $this->csvHandler->saveData($data, $header);
    }

    public function editCharity(Charity $charity, string $name, string $email): void
    {

        if (!empty($name)) {
            $charity->setName($name);
        }

        if (!empty($email)) {
            $charity->setEmail($email);
        }

        $this->saveAllCharities();
    }

    public function deleteCharity(int $id): void
    {
        unset($this->charities[$id]);
        $this->saveAllCharities();
    }

    public function viewCharities(): array
    {
        return $this->charities;
    }

    public function getCharityById(int $id): ?Charity
    {
        return $this->charities[$id] ?? null;
    }
}
