<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha;

use Anticaptcha\Entity\QueueStats;
use Anticaptcha\Entity\Result;
use Anticaptcha\Exception\ErrorResponseException;
use Anticaptcha\Exception\InvalidArgumentException;
use Anticaptcha\Exception\TransportException;
use Anticaptcha\Language\Language;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Class Service
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
abstract class Service implements ServiceInterface
{
    const LANGUAGE_POOL_RN = 'rn';
    const LANGUAGE_POOL_EN = 'en';

    /**
     * @var string
     */
    public static $language;

    /**
     * @var string
     */
    protected $serverUrl = 'https://api.anti-captcha.com';

    /**
     * @var string
     */
    protected $languagePool = self::LANGUAGE_POOL_RN;

    /**
     * HTTP transport.
     *
     * @var ClientInterface
     */
    protected $transport;

    /**
     * @var CredentialsInterface
     */
    protected $credentials;

    /**
     * Your application ID in Anticaptcha catalog.
     * The value `857` is ID of this library. Set in 0 if you want to turn off sending any ID.
     *
     * @var int
     */
    protected $softId = 857;

    /**
     * Service constructor.
     *
     * @param $key
     * @param array $options
     */
    public function __construct($key, array $options = [])
    {
        if ($key instanceof CredentialsInterface) {
            $this->credentials = $key;
        } elseif (is_string($key)) {
            $this->credentials = new Credentials($key);
        }

        foreach ($options as $option => $value) {
            $setter = 'set' . ucfirst($option);
            if ($option === 'language') {
                self::$language = $option;
            } elseif (method_exists($this, $setter)) {
                $this->$setter($value);
            } elseif (property_exists($this, $option)) {
                $this->$option = $value;
            }
        }
    }

    /**
     * @param CredentialsInterface $credentials
     * @return $this
     */
    public function setCredentials(CredentialsInterface $credentials)
    {
        $this->credentials = $credentials;
        return $this;
    }

    /**
     * @param ClientInterface $transport
     * @return $this
     */
    public function setTransport(ClientInterface $transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return \GuzzleHttp\Client|ClientInterface
     */
    public function getTransport()
    {
        if (empty($this->transport)) {
            $this->transport = new \GuzzleHttp\Client([
                'base_uri' => $this->serverUrl
            ]);
        }

        return $this->transport;
    }

    /**
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws TransportException
     */
    public function call($method, array $params = [])
    {
        try {
            $request = new Request(
                'POST',
                $this->resolvePath($method, $params),
                $this->resolveHeaders($method, $params),
                $this->resolveBody($method, $params),
                '1.1'
            );
            $response = $this->getTransport()->send($request);

            return $this->handleResponse($response, $method, $params);
        } catch (GuzzleException $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Response $response
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws ErrorResponseException
     * @throws InvalidArgumentException
     */
    protected function handleResponse(Response $response, $method, $params)
    {
        $data = \GuzzleHttp\json_decode($response->getBody()->__toString(), true);

        if (isset($data['errorId'])
            && $data['errorId'] > 0
        ) {
            throw new ErrorResponseException(
                t(getErrorMessageById($data['errorId'])),
                $data['errorId'],
                isset($data['errorCode']) ? $data['errorCode'] : ''
            );
        }

        switch ($method) {
            case 'createTask':
                return intval($data['taskId']);

            case 'getBalance':
                return floatval($data['balance']);

            case 'getQueueStats':
                return QueueStats::fromResponse($data);

            case 'getTaskResult':
                // For await method
                $data['credentials'] = $this->credentials;
                $data['taskId'] = $params['taskId'];
                return Result::fromResponse($data);

            case 'reportIncorrectImageCaptcha':
                return $data['status'];
        }

        throw new InvalidArgumentException(t('Unknown method \'{method}\'.', ['method' => $method]));
    }

    /**
     * @param string $method
     * @param array $params
     * @return string
     */
    protected function resolvePath($method, $params)
    {
        return '/' . $method;
    }

    /**
     * @param string $method
     * @param array $params
     * @return array
     */
    protected function resolveHeaders($method, $params)
    {
        return [
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * @param string $method
     * @param array $params
     * @return string
     */
    protected function resolveBody($method, $params)
    {
        $baseParams = [
            'clientKey' => $this->credentials->getClientKey(),
        ];

        switch ($method) {
            case 'createTask':
                $baseParams['softId'] = $this->softId;
                $baseParams['languagePool'] = $this->languagePool;
                break;
        }

        return \GuzzleHttp\json_encode(array_merge($baseParams, $params));
    }
}
