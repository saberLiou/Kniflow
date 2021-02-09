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
     * Format a resource object in a success json response, reference: https://jsonapi.org/format/#document-resource-objects.
     *
     * @param int $id
     * @param string $type
     * @param array $attributes
     * @param array $relationships
     */
    function format_resource_object(int $id, string $type, array $attributes, array $relationships)
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
        $errorObjects = [];
        foreach ($errors as $field => $messages) {
            $errorObject = [
                'status' => (string) $status,
                'source' => [
                    'pointer' => "",
                    'parameter' => "",
                ],
                "title" => "",
                "detail" => "",
            ];
            switch ($status) {
                case Response::HTTP_UNPROCESSABLE_ENTITY:
                    $errorObject['source']['pointer'] = "/data/attributes/$field";
                    $errorObject['title'] = "Invalid Attribute";
                    $errorObject['detail'] = $messages[0];
                    break;
                default:
                    $errorObject['title'] = $field;
                    $errorObject['detail'] = $messages;
            }
            $errorObjects[] = $errorObject;
        }

        $response = response()->json([
            'jsonapi' => ['version' => '2021.02'],
            'errors' => $errorObjects,
        ], $status);

        return $response;
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
