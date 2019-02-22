<?php
// declare(strict_types = 1);

namespace App;

use App\Insurance\Factory;
use Psr\Http\Message\ResponseInterface;
use Exception;
use App\Model\InsuranceCalculator;

/**
 *
 * @package App
 */
class Calculator
{
    /**
     * @var array
     */
    private $config;
    /**
     * HelloWorld constructor.
     *
     * @param ResponseInterface $response
     * @param array $config
     */
    public function __construct(
        array $config,
        ResponseInterface $response
    ) {
        $this->config = $config;
        $this->response = $response;
    }

    /**
     *
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __invoke(): ResponseInterface
    {

        try {
            $carValue     = intval($_POST['car_value']);
            $installments = intval($_POST['installments']);
            $tax          = floatval($_POST['tax']);
            $company      = strtolower(trim($_POST['company']));

            // just for better experience in demo
            sleep(1);

            // validation user inputs
            $errors   = [];
            $payload = [];

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
                $payload ['code']   = 1;
                $payload ['errors'] = $errors;
            } else {
                $calculator = Factory::make($company, $this->config);

                $installmentsTable = $calculator->setCarValue($carValue)
                    ->setInstallments($installments)
                    ->setTaxPercentage($tax)
                    ->renderInstallmentTable();

                $payload = [
                    'code'  => 0,
                    'table' => $installmentsTable,
                ];
            }
        } catch (Exception $e) {
            $payload ['code']   = 1;
            $payload ['errors'] = ['global_error' => $e->getMessage()];
        }



        $response = $this->response->withHeader('Content-Type', 'application/json');
        $response->getBody()
            ->write(json_encode($payload));

        return $response;
    }
}
