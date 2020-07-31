<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class RestContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var \GuzzleHttp\Psr7\Response */
    private $_response;
    private $_bodyDecoded;

    /** @var Client */
    private $_client;



    public function __construct(KernelInterface $kernel, string $base_url)
    {
        $this->kernel = $kernel;
        $this->_client = new Client(['base_uri' => $base_url]);
//        throw  new \Exception("nenne: ".$base_url);
    }
    /**
     * @When I run GET on :arg1
     */
    public function iRunGetOn($arg1)
    {
        try {
            $this->_response = $this->_client->get($arg1);

        } catch (RequestException $e) {

            if ($e->hasResponse()) {
                $this->_response = $e->getResponse();
            } else {
                throw $e;
            }
        } catch (\Exception $e) {

            throw $e;
        }
    }

    /**
     * @Then the status code is :arg1
     */
    public function theStatusCodeIs($arg1)
    {
        if ((string) $this->_response->getStatusCode() !== $arg1) {
            throw new \Exception('HTTP code does not match ' . $arg1 .
                ' (actual: ' . $this->_response->getStatusCode() . ')' . substr($this->_response->getBody(),0,10000));
        }
    }

    /**
     * @Then the body is json
     */
    public function theBodyIsJson()
    {
        try {
            $body=json_decode($this->_response->getBody()->getContents(), true);
            $this->_bodyDecoded=$body;
        }catch (\Exception $e ){
            if($body=$this->_response->getBody()){
                print "$body\n";
                throw $e;
            }
        }
    }

}
