<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class BaseResource extends JsonResource
{
    /**
     * The status code of an HTTP response returned with the resource.
     *
     * @var int
     */
    private $statusCode;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  int  $statusCode
     * @return void
     */
    public function __construct($resource, int $statusCode = Response::HTTP_OK)
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return success_response((array) parent::toResponse($request)->getData(), $this->statusCode);
    }

    /**
     * Get any additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'links' => [
                'self' => $request->fullUrl(),
            ]
        ];
    }
}
