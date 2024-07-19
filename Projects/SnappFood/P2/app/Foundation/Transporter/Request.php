<?php

namespace App\Foundation\Transporter;

use App\Exceptions\ServiceException;
use App\Foundation\Utils\ResponseValidator;
use BadMethodCallException;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use OutOfBoundsException;
use RuntimeException;

abstract class Request
{
    use Conditionable;
    use Macroable {
        __call as macroCall;
    }
    use ResponseValidator;

    protected PendingRequest $request;

    protected array $pendingRequestCalls = [];

    protected string $method;

    protected string $path;

    protected string $baseUrl;

    protected ?string $as = null;

    protected array $query = [];

    protected array $data = [];

    protected array $headers = [];

    protected int $status;

    protected string $referenceId;

    private HttpFactory $http;

    public function __construct(HttpFactory $http)
    {
        $this->http = $http;
        $this->setBaseUrl();
    }

    private function setBaseUrl(): static
    {
        $this->baseUrl = $this->url();

        if (isset($this->request)) {
            $this->request->baseUrl($this->url());
        }

        return $this;
    }

    abstract protected function url(): string;

    public static function build(...$args): static
    {
        return app(static::class, $args);
    }

    public function getAs(): ?string
    {
        return $this->as;
    }

    public function as(string|int $as): static
    {
        $this->as = $as;

        return $this;
    }

    public function withData(array $data): static
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function setHeaders(array $headers): static
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    public function payload(): array
    {
        return $this->data;
    }

    public function withQuery(array $query): static
    {
        $this->query = array_merge_recursive($this->query, $query);

        return $this;
    }

    /**
     * @throws RuntimeException
     */
    public function getBaseUrl(): string
    {
        if (isset($this->baseUrl)) {
            return $this->baseUrl;
        }

        throw new RuntimeException(
            message: 'Neither a baseUrl or a config base_uri has been set for this request.',
        );
    }

    public function lockOn(string $baseUrl): static
    {
        return $this->setBaseUrl($baseUrl);
    }

    public function buildForConcurrent(Pool $pool): PromiseInterface|Response
    {
        $this->ensureRequest($pool);

        return $this->buildRequest();
    }

    private function ensureRequest(?Pool $pool = null): void
    {
        if (! isset($this->request)) {
            if ($pool === null) {
                $this->request = $this->http->baseUrl(
                    url: $this->baseUrl ?? '',
                );
            } else {
                $this->request = match ($this->as === null) {
                    false => $pool->as(key: $this->as)->baseUrl($this->baseUrl ?? ''),
                    true => $pool->baseUrl(url: $this->baseUrl ?? '')
                };
            }

            $this->withRequest($this->request);

            foreach ($this->pendingRequestCalls as $call) {
                call_user_func_array([$this->request, $call[0]], $call[1]);
            }
        }
    }

    protected function withRequest(PendingRequest $request): void
    {
        // do something with the initialized request
    }

    private function buildRequest(): PromiseInterface|Response
    {
        return match (mb_strtoupper($this->method)) {
            'GET' => $this->request->get($this->getUrl(), $this->query),
            'POST' => $this->request->post($this->getUrl(), $this->data),
            'PUT' => $this->request->put($this->getUrl(), $this->data),
            'PATCH' => $this->request->patch($this->getUrl(), $this->data),
            'DELETE' => $this->request->delete($this->getUrl(), $this->data),
            'HEAD' => $this->request->head($this->getUrl(), $this->query),
            default => throw new OutOfBoundsException()
        };
    }

    public function getUrl(): string
    {
        $url = (string) Str::of($this->path())
            ->when(
                ! empty($this->query),
                fn (Stringable $path): Stringable => $path->append('?', http_build_query($this->query))
            );
        if (Str::of($this->method)->upper()->contains('GET', 'HEAD')) {
            return $this->path();
        }

        return $url;
    }

    protected function path(): string
    {
        return $this->path ?? '';
    }

    /**
     * @throws ServiceException
     */
    public function energize(): Response
    {
        return $this->send();
    }

    /**
     * @throws ServiceException
     */
    public function send(): Response
    {
        $this->ensureRequest();
        $response = $this->buildRequest();
        if ($response->failed()) {
            $this->exception($response->status(), $response->json());
        }

        $result = $response->json();
        $this->when(
            ! empty($this->rules()),
            fn () => $this->validateResponse($this->rules(), $result)
        );

        return $response;
    }

    protected function rules(): array
    {
        return [];
    }

    public function appendPath(string $appends): static
    {
        $this->path = "{$this->path}/{$appends}";

        return $this;
    }

    public function getRequest(): PendingRequest
    {
        $this->ensureRequest();

        return $this->request;
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function __call(string $method, array $parameters): static
    {
        if (isset($this->request)) {
            if (method_exists($this->request, $method)) {
                call_user_func_array([$this->request, $method], $parameters);

                return $this;
            }
        } else {
            if (method_exists(PendingRequest::class, $method)) {
                $this->pendingRequestCalls[] = [$method, $parameters];

                return $this;
            }
        }

        throw new BadMethodCallException();
    }

    /**
     * @return $this
     */
    public function withReferenceId(string $referenceId): static
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * @throws ServiceException
     */
    private static function exception(string $status, ?array $errors = []): mixed
    {
        throw new ServiceException($status, $errors);
    }
}
