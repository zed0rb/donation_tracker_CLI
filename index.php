<?php

require_once __DIR__ . '/autoload.php';

use App\Controller\CharityController;
use App\Controller\DonationController;
use App\Utils\MoneyHandler;
use App\View\View;

$view = new View();
$moneyHandler = new MoneyHandler();
const CHARITY_FILE_PATH = __DIR__ . '/data/charities.csv';
const DONATION_FILE_PATH = __DIR__ . '/data/donations.csv';

$charityController = new CharityController(CHARITY_FILE_PATH);
$donationController = new DonationController(DONATION_FILE_PATH);

do {
    echo "Donation Tracker CLI\n";
    echo "1. View Charities\n";
    echo "2. Add Charity\n";
    echo "3. Edit Charity\n";
    echo "4. Delete Charity\n";
    echo "5. Add Donation\n";
    echo "6. View Donations\n";
    echo "7. Exit\n";

    $option = $view->prompt("Choose an option: ");

    try {
        switch ($option) {
            case 1:
                $charities = $charityController->getCharities();
                $view->displayItems($charities, function ($charity) {
                    return "ID: {$charity->getId()}, Name: {$charity->getName()}, Email: {$charity->getEmail()}";
                });
                break;
            case 2:
                $name = $view->prompt("Enter Charity Name: ");
                $email = $view->prompt("Enter Representative Email: ");
                $charityController->addCharity($name, $email);
                $view->displaySuccessMessage("Charity added successfully.");
                break;
            case 3:
                $charityId = (int)$view->prompt("Enter Charity ID: ");
                $charity = $charityController->getCharityById($charityId);

                if (!$charity) {
                    $view->displayErrorMessage("Charity ID not found.");
                } else {
                    $name = $view->prompt("Enter new Charity Name (or press Enter to keep '{$charity->getName()}'): ");
                    $email = $view->prompt("Enter new Representative Email (or press Enter to keep '{$charity->getEmail()}'): ");
                    $charityController->editCharity($charity, $name, $email);
                    $view->displaySuccessMessage("Charity updated successfully.");
                }
                break;
            case 4:
                $id = (int)$view->prompt("Enter Charity ID to delete: ");

                if ($charityController->getCharityById($id) === null) {
                    $view->displayErrorMessage("Charity ID not found.");
                } else {
                    $charityController->deleteCharity($id);
                    $view->displaySuccessMessage("Charity deleted successfully.");
                }
                break;
            case 5:
                $id = (int)$view->prompt("Enter Charity ID: ");
                $charity = $charityController->getCharityById($id);

                if (!$charity) {
                    $view->displayErrorMessage("Charity ID not found.");
                    break;
                }

                $name = $view->prompt("Enter Donor Name: ");
                $amountInput = $view->prompt("Enter Amount ($): ");
                $amount = $moneyHandler->handleAmountFormat($amountInput);


                $donationController->addDonation($id, $name, $amount);
                $view->displaySuccessMessage("Donation added successfully.");
                break;
            case 6:
                $id = (int)$view->prompt("Enter Charity ID or leave blank to load all donations: ");
                $donations = $donationController->loadDonationsByCharityId($id);

                $view->displayItems($donations, function ($donation) {
                    return "ID: {$donation->getId()}, Donor: {$donation->getDonorName()}, " .
                        "Amount: {$donation->getAmount()}, Charity Id: {$donation->getCharityId()} Date: {$donation->getDateTime()}";
                });
                break;
            case 7:
                $view->displaySuccessMessage("Exiting... Goodbye!");
                break;
            default:
                $view->displayErrorMessage("Invalid option. Please try again.");
        }
    } catch (Exception $e) {
        $view->displayErrorMessage($e->getMessage());
    }
} while ($option != 7);
