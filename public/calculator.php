<?php
require_once __DIR__ . '/../app/InsuranceCalculator.php';

$config = include __DIR__ . '/../config/config.php';


try {
    $carValue     = intval($_POST['car_value']);
    $installments = intval($_POST['installments']);
    $tax          = floatval($_POST['tax']);

    // just for better experience in demo
    sleep(1);

    // validation user inputs
    $errors   = [];
    $response = [];

    if ($carValue < 100 || $carValue > 100000) {
        $errors ['car_value'] = 'The estimated car value should be a number between 100 and 100000 EUR';
    }

    if ($installments < 1 || $installments > 12) {
        $errors ['installments'] = 'The installments should be a number between 1 and 12';
    }

    if (!isset($_POST['tax']) || trim($_POST['tax']) == '' || !is_numeric($_POST['tax']) || $tax < 0 || $tax > 100) {
        $errors ['tax'] = 'The tax should be a number between 0 and 100';
    }

    if (!empty($errors)) {
        $response ['code']   = 1;
        $response ['errors'] = $errors;
    } else {
        $calculator = new InsuranceCalculator($config['basePricePercent'], $config['commissionPercent'],
            $config['basePriceException']);

        $installmentsTable = $calculator->setCarValue($carValue)
            ->setInstallments($installments)
            ->setTaxPercentage($tax)
            ->renderInstallmentTable();

        $response = [
            'code'  => 0,
            'table' => $installmentsTable,
        ];
    }
} catch (Exception $e) {
    $response ['code']   = 1;
    $response ['errors'] = ['global_error' => $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
exit;