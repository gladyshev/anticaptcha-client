<?php

namespace Anticaptcha;

use Anticaptcha\Response\CreateTaskResponse;
use Anticaptcha\Response\GetAppStatsResponse;
use Anticaptcha\Response\GetBalanceResponse;
use Anticaptcha\Response\GetQueueStatsResponse;
use Anticaptcha\Response\GetSpendingStatsResponse;
use Anticaptcha\Response\GetTaskResultResponse;
use Anticaptcha\Response\PushAntiGateVariableResponse;
use Anticaptcha\Response\ReportCorrectRecaptchaResponse;
use Anticaptcha\Response\ReportIncorrectImageCaptchaResponse;
use Anticaptcha\Response\ReportIncorrectRecaptchaResponse;
use Anticaptcha\Task\AbstractTask;
use Anticaptcha\Task\ImageToTextTask;
use GuzzleHttp\Psr7\Request;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

final class Client
{
    private ConfigurationInterface $configuration;
    private ClientInterface $httpClient;

    public function __construct(
        ConfigurationInterface $configuration,
        ClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
        $this->configuration = $configuration;
    }

    /**
     * Create a captcha task
     *
     * @param AbstractTask $task        Task object
     * @param ?int $softId              ID of your application from our Developers Center.
     * @param ?string $languagePool     Sets workers' pool language.
     *                                    en (default): English language queue
     *                                    rn: group of countries: Russia, Ukraine, Belarus, Kazakhstan
     * @param ?string $callbackUrl      Optional web address where we can send the results of captcha task processing.
     *                                  Contents are sent by AJAX POST request and are similar to the contents of
     *                                  getTaskResult method.
     *
     * @return CreateTaskResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @see https://anti-captcha.com/apidoc/methods/createTask
     */
    public function createTask(
        AbstractTask $task,
        ?int $softId = null,
        ?string $languagePool = null,
        ?string $callbackUrl = null
    ): CreateTaskResponse {
        $request = $this->createRequest(
            $this->configuration->getApiUrl() . '/createTask',
            array_filter([
                'clientKey' => $this->configuration->getClientKey(),
                'softId' => $softId ?? $this->configuration->getSoftId(),
                'languagePool' => $languagePool ?? $this->configuration->getLanguagePool(),
                'task' => $task->toArray(),
                'callbackUrl' => $callbackUrl ?? $this->configuration->getCallbackUrl(),
            ], fn ($value) => $value !== null)
        );

        $response = $this->httpClient->sendRequest($request);

        return CreateTaskResponse::fromHttpResponse($response);
    }

    /**
     * Syntax sugar for self::createTask()
     *
     * @param string $base64Content     Base64 encoded image content
     * @param array $taskProperties     Array of ImageToTextTask attributes (attribute => value)
     *
     * @return CreateTaskResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function createTaskByBase64(
        string $base64Content,
        array $taskProperties = []
    ): CreateTaskResponse {
        return $this->createTask(ImageToTextTask::fromBase64($base64Content, $taskProperties));
    }

    /**
     * Syntax sugar for self::createTask()
     *
     * @param string $link              file_get_contents() compatible filename
     * @param array $taskProperties     Array of ImageToTextTask attributes (attribute => value)
     *
     * @return CreateTaskResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function createTaskByImage(
        string $link,
        array $taskProperties = []
    ): CreateTaskResponse {
        return $this->createTask(ImageToTextTask::fromImage($link, $taskProperties));
    }

    /**
     * Synchronous image recognition. Returns complete result with solution.
     *
     * @param string $link              file_get_contents() compatible filename
     * @param array $taskProperties     Array of ImageToTextTask attributes (attribute => value)
     *
     * @return GetTaskResultResponse
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function resolveImage(
        string $link,
        array $taskProperties = []
    ): GetTaskResultResponse {
        $createTaskResponse = $this->createTaskByImage($link, $taskProperties);
        $taskResult = $this->getTaskResult($createTaskResponse->getTaskId());
        $taskResult->wait();

        return $taskResult;
    }

    /**
     * Synchronous image recognition. Returns complete result with solution.
     *
     * @param string $base64Content     Base64 encoded image content
     * @param array $taskProperties     Array of ImageToTextTask attributes (attribute => value)
     *
     * @return GetTaskResultResponse
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function resolveBase64(
        string $base64Content,
        array $taskProperties = []
    ): GetTaskResultResponse {
        $createTaskResponse = $this->createTaskByBase64($base64Content, $taskProperties);
        $taskResult = $this->getTaskResult($createTaskResponse->getTaskId());
        $taskResult->wait();

        return $taskResult;
    }

    /**
     * Request a task result
     *
     * @param int $taskId
     *
     * @return GetTaskResultResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     *
     * @see https://anti-captcha.com/apidoc/methods/getTaskResult
     */
    public function getTaskResult(
        int $taskId
    ): GetTaskResultResponse {
        $httpRequest = $this->createRequest(
            $this->configuration->getApiUrl() . '/getTaskResult',
            [
                'clientKey' => $this->configuration->getClientKey(),
                'taskId' => $taskId
            ]
        );

        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        $response = GetTaskResultResponse::fromHttpResponse($httpResponse);

        // For GetTaskResultResponse::wait() method
        $response->setClient($this);
        $response->setTaskId($taskId);

        return $response;
    }

    /**
     * Retrieve an account balance
     *
     * @return GetBalanceResponse
     *
     * @throws JsonException
     * @throws ClientExceptionInterface
     *
     * @see https://anti-captcha.com/apidoc/methods/getBalance
     */
    public function getBalance(): GetBalanceResponse
    {
        $request = $this->createRequest(
            $this->configuration->getApiUrl() . '/getBalance',
            [
                'clientKey' => $this->configuration->getClientKey()
            ]
        );

        $response = $this->httpClient->sendRequest($request);

        return GetBalanceResponse::fromHttpResponse($response);
    }

    /**
     * Obtain queue load statistics
     *
     * @param int $queueId
     *
     * @return GetQueueStatsResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     *
     * @see https://anti-captcha.com/apidoc/methods/getQueueStats
     */
    public function getQueueStats(int $queueId): GetQueueStatsResponse
    {
        $request = $this->createRequest(
            $this->configuration->getApiUrl() . '/getQueueStats',
            [
                'queueId' => $queueId
            ]
        );

        $response = $this->httpClient->sendRequest($request);

        return GetQueueStatsResponse::fromHttpResponse($response);
    }

    /**
     * Send complaint on an image captcha
     *
     * @param int $taskId
     *
     * @return ReportIncorrectImageCaptchaResponse
     *
     * @throws JsonException
     * @throws ClientExceptionInterface
     *
     * @see https://anti-captcha.com/apidoc/methods/reportIncorrectImageCaptcha
     */
    public function reportIncorrectImageCaptcha(
        int $taskId
    ): ReportIncorrectImageCaptchaResponse {
        $httpRequest = $this->createRequest(
            $this->configuration->getApiUrl() . '/reportIncorrectImageCaptcha',
            [
                'clientKey' => $this->configuration->getClientKey(),
                'taskId' => $taskId
            ]
        );

        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        return ReportIncorrectImageCaptchaResponse::fromHttpResponse($httpResponse);
    }

    /**
     * Send complaint on a Recaptcha token
     * @param int $taskId
     *
     * @return ReportIncorrectRecaptchaResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     *
     * @see https://anti-captcha.com/apidoc/methods/reportIncorrectRecaptcha
     */
    public function reportIncorrectRecaptcha(
        int $taskId
    ): ReportIncorrectRecaptchaResponse {
        $httpRequest = $this->createRequest(
            $this->configuration->getApiUrl() . '/reportIncorrectRecaptcha',
            [
                'clientKey' => $this->configuration->getClientKey(),
                'taskId' => $taskId
            ]
        );

        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        return ReportIncorrectRecaptchaResponse::fromHttpResponse($httpResponse);
    }

    /**
     * Report correctly solved Recaptcha tokens
     *
     * @param int $taskId
     *
     * @return ReportCorrectRecaptchaResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     *
     * @see https://anti-captcha.com/apidoc/methods/reportCorrectRecaptcha
     */
    public function reportCorrectRecaptcha(
        int $taskId
    ): ReportCorrectRecaptchaResponse {
        $httpRequest = $this->createRequest(
            $this->configuration->getApiUrl() . '/reportCorrectRecaptcha',
            [
                'clientKey' => $this->configuration->getClientKey(),
                'taskId' => $taskId
            ]
        );

        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        return ReportCorrectRecaptchaResponse::fromHttpResponse($httpResponse);
    }

    /**
     * Submit a variable value for AntiGate task.
     *
     * @param int $taskId       An identifier obtained in the createTask method
     * @param string $name      Name of the variable
     * @param mixed $value      Value of the postponed variable
     *
     * @return PushAntiGateVariableResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     *
     * @see https://anti-captcha.com/apidoc/methods/pushAntiGateVariable
     */
    public function pushAntigateVariable(
        int $taskId,
        string $name,
        $value
    ): PushAntiGateVariableResponse {
        $httpRequest = $this->createRequest(
            $this->configuration->getApiUrl() . '/reportCorrectRecaptcha',
            [
                'clientKey' => $this->configuration->getClientKey(),
                'taskId' => $taskId,
                'name' => $name,
                'value' => $value
            ]
        );

        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        return PushAntiGateVariableResponse::fromHttpResponse($httpResponse);
    }

    /**
     * @param ?string $date         Unix timestamp of the hour from which we grab the 24 hour stats.
     * @param ?int $queue           You can find the name of the queue in the AntiCaptcha statistics. If it's not
     *                              provided, totals are calculated for all queues.
     *                              Examples:
     *                              "English ImageToText"
     *                              "Recaptcha Proxyless"
     * @param ?int $softId          The ID of your app from the Developer Center
     * @param ?string $ip           Filter statistics by IP address you used for your API calls

     * @return GetSpendingStatsResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     *
     * @see https://anti-captcha.com/apidoc/methods/getSpendingStats
     */
    public function getSpendingStats(
        ?string $date = null,
        ?int $queue = null,
        ?int $softId = null,
        ?string $ip = null
    ): GetSpendingStatsResponse {
        $httpRequest = $this->createRequest(
            $this->configuration->getApiUrl() . '/getSpendingStats',
            array_filter([
                'clientKey' => $this->configuration->getClientKey(),
                'date' => $date,
                'queue' => $queue,
                'softId' => $softId,
                'ip' => $ip
            ], fn ($value) => $value !== null)
        );

        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        return GetSpendingStatsResponse::fromHttpResponse($httpResponse);
    }

    /**
     * Retrieve application statistics
     *
     * @param int $softId
     * @param ?string $mode
     *
     * @return GetAppStatsResponse
     *
     * @throws ClientExceptionInterface
     * @throws JsonException
     *
     * @see https://anti-captcha.com/apidoc/methods/getAppStats
     */
    public function getAppStats(
        int $softId,
        ?string $mode = null
    ): GetAppStatsResponse {
        $httpRequest = $this->createRequest(
            $this->configuration->getApiUrl() . '/getAppStats',
            array_filter([
                'clientKey' => $this->configuration->getClientKey(),
                'softId' => $softId,
                'mode' => $mode,
            ], fn ($value) => $value !== null)
        );

        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        return GetAppStatsResponse::fromHttpResponse($httpResponse);
    }

    /**
     * @param string $uri
     * @param array $params
     *
     * @return RequestInterface
     *
     * @throws JsonException
     */
    private function createRequest(string $uri, array $params = []): RequestInterface
    {
        return new Request(
            'POST',
            $uri,
            [
                'Content-Type' => 'application/json'
            ],
            json_encode($params, JSON_THROW_ON_ERROR),
            '1.1'
        );
    }
}
