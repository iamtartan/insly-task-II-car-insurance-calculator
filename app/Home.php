<?php
declare(strict_types = 1);

namespace App;

use Psr\Http\Message\ResponseInterface;

/**
 *
 * @package App
 */
class Home
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * Home constructor
     *
     * @param ResponseInterface $response
     * @param array $config
     */
    public function __construct(
        array $config,
        ResponseInterface $response
    ) {
        $this->config   = $config;
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
        ob_start();
        $maxInstallments    = $this->config['maxInstallments'];
        $insuranceCompanies = $this->config['activeCompanies'];
        $view               = include(dirname(__DIR__) . '/views/index.php');
        $content = ob_get_contents();
        ob_end_clean();

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write($content);

        return $response;
    }
}
