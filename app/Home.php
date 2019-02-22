<?php
declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;

/**
 *
 *
 * @package   ExampleApp
 */
class Home
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
     * @var ResponseInterface
     */
    private $response;

    /**
     *
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __invoke(): ResponseInterface
    {
        $maxInstallments = $this->config['maxInstallments'];
        $view = include (dirname(__DIR__) . '/views/index.php');

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write(strval($view));

        return $response;
    }
}
