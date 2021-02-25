<?php

use Symfony\Component\HttpFoundation\Response;

if (!function_exists('success_response')) {
    /**
     * Format a success json response, reference: https://jsonapi.org/.
     *
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse $response
     */
    function success_response(array $data, int $status)
    {
        $response = response()->json([
            'jsonapi' => ['version' => '2021.02'],
        ] + $data, $status);

        return $response;
    }
}

if (!function_exists('format_resource_object')) {
    /**
     * Format a resource object in a success json response,
     * reference: https://jsonapi.org/format/#document-resource-objects.
     *
     * @param int $id
     * @param string $type
     * @param array $attributes
     * @param array $relationships
     */
    function format_resource_object(int $id, string $type, array $attributes, array $relationships = [])
    {
        return [
            'id' => $id,
            'type' => $type,
            'attributes' => $attributes,
            'relationships' => $relationships,
        ];
    }
}

if (!function_exists('error_response')) {
    /**
     * Format an error json response, reference: https://jsonapi.org/.
     *
     * @param array $errors
     * @param int $status
     * @return \Illuminate\Http\JsonResponse $response
     */
    function error_response(array $errors, int $status)
    {
        $response = response()->json([
            'jsonapi' => ['version' => '2021.02'],
            'errors' => format_error_objects($status, $errors),
        ], $status);

        return $response;
    }
}

if (!function_exists('format_error_objects')) {
    /**
     * Format error objects in an error json response,
     * reference: https://jsonapi.org/examples/#error-objects
     *
     * @param int $status
     * @param array $errors
     * @return array
     */
    function format_error_objects(int $status, array $errors)
    {
        $errorObjects = [];
        foreach ($errors as $field => $messages) {
            switch ($status) {
                case Response::HTTP_UNPROCESSABLE_ENTITY:
                    $errorObjects[] = format_error_object($status, "Invalid Attribute", $messages[0], $field);
                    break;
                default:
                    $errorObjects[] = format_error_object($status, $field, $messages);
            }
        }
        return $errorObjects;
    }
}

if (!function_exists('format_error_object')) {
    /**
     * Format an error object in an error json response,
     * reference: https://jsonapi.org/format/#error-objects.
     *
     * @param int $status
     * @param string $title
     * @param string $detail
     * @param string $pointer
     * @param string $parameter
     * @return array
     */
    function format_error_object(
        int $status,
        string $title = "",
        string $detail = "",
        string $pointer = "",
        string $parameter = ""
    ) {
        return [
            'status' => (string) $status,
            'source' => [
                'pointer' => !empty($pointer) ? "/data/attributes/$pointer" : "",
                'parameter' => $parameter,
            ],
            "title" => $title,
            "detail" => $detail,
        ];
    }
}

if (!function_exists('array_remove_pairs')) {
    /**
     * Remove key-value pairs in an array by their keys.
     *
     * @param array $array
     * @param array $keys
     * @return array
     */
    function array_remove_pairs(array $array, array $keys)
    {
        return array_diff_key($array, array_flip($keys));
    }
}
