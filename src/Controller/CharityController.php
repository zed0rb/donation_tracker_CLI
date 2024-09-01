<?php
declare(strict_types=1);

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

    public function getCharities(): array
    {
        return $this->charities;
    }

    public function getCharityById(int $id): ?Charity
    {
        return $this->charities[$id] ?? null;
    }

    public function addCharity(string $name, string $email): void
    {
        if ($this->isCharityNameExists($name)) {
            throw new \InvalidArgumentException("Charity with this name already exists.");
        }

        $charity = new Charity($this->charityIdCounter, $name, $email);
        $this->charities[$charity->getId()] = $charity;
        $this->saveAllCharities();
        $this->charityIdCounter++;
    }

    private function isCharityNameExists(string $name): bool
    {
        $normalizedName = strtolower($name);

        foreach ($this->charities as $charity) {
            if (strtolower($charity->getName()) === $normalizedName) {
                return true;
            }
        }

        return false;
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

    public function importCharitiesFromCsv(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("The file does not exist: $filePath");
        }

        $importHandler = new CsvFileHandler($filePath);
        $importData = $importHandler->loadData();

        if (empty($importData)) {
            throw new \InvalidArgumentException("The file is empty or contains invalid data: $filePath");
        }

        foreach ($importData as $row) {
            if (count($row) !== 3) {
                throw new \InvalidArgumentException("Invalid data format in file: Each row must have exactly 3 columns.");
            }

            $header = array_shift($importData);
            if ($header !== ['ID', 'Name', 'Representative Email']) {
                throw new \InvalidArgumentException("Invalid CSV header format.");
            }

            list($id, $name, $email) = $row;

            if ($this->isCharityNameExists($name)) {
                continue;
            }

            $newId = $this->charityIdCounter;
            $this->charityIdCounter++;

            $charity = new Charity($newId, $name, $email);
            $this->charities[$newId] = $charity;
        }

        $this->saveAllCharities();
    }

}
