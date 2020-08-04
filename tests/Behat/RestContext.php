<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use InvalidArgumentException;
use Peekmo\JsonPath\JsonStore;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Gherkin\Node\PyStringNode;

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
    public $_jsonStore;

    /** @var Client */
    private $_client;



    public function __construct(KernelInterface $kernel, string $base_url)
    {
        $this->kernel = $kernel;
        $this->_client = new Client(['base_uri' => $base_url]);
//        throw  new \Exception("nenne: ".$base_url);
    }
    /**
     * @When I run GET on :url
     */
    public function iRunGet($url)
    {
        try {
            $this->_response = $this->_client->get($url);

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
     * @When I run :method on :url with json
     */
    public function iRunRestWithJson($method, $url, PyStringNode $string)
    {
        try {

            $postParamArray = json_decode($string->getRaw(), true);
            if (json_last_error() != JSON_ERROR_NONE) {
                print $string->getRaw();
                throw new InvalidArgumentException("JSON not well formed: [" . json_last_error(). "]:" . json_last_error_msg());
            }
            $headers = [
                'json' => $postParamArray
            ];

            $response = $this->_client->request($method, $url, $headers);
            $this->_response = $response;
        } catch (RequestException $e) { //4xx //5xx network
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
                ' (actual: ' . $this->_response->getStatusCode() . ')' . substr($this->_response->getBody()->getContents(),0,10000));
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
            $this->_jsonStore=new JsonStore($this->_bodyDecoded);
        }catch (\Exception $e ){
            if($body=$this->_response->getBody()){
                print "$body\n";
                throw $e;
            }
        }
    }

    /**
     * @Then json body have :path = :value
     */
    public function jsonBodyHavePathWithValue($path, $value)
    {
        $res=$this->_jsonStore->get($path);
        if(!count($res)){
            // print_r($res);
            // $body=$this->_response->getBody()->getContents();
            // print_r($body);
            throw new \Exception("the body does not contain: $path");
        } elseif($res[0] != $value) {
            throw new \Exception("$path is not $value, ". print_r($res, true));
        }
    }

    /**
     * @Then the count of :path is :value
     */
    public function theCountOfIs($path, $value)
    {
        $res=$this->_jsonStore->get($path);
        if(!count($res)){
            // print_r($res);
            // $body=$this->_response->getBody()->getContents();
            // print_r($body);
            throw new \Exception("the body does not contain: $path");
        } elseif(count($res) != $value && !(count($res)==1 && empty($res[0]) && $value==0)) {
            throw new \Exception("$path is not $value, but ".count($res).": ". print_r($res, true));
        }
    }


}
