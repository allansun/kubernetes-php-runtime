<?php


namespace KubernetesRuntime\Guzzle;


use GuzzleHttp\Psr7;
use KubernetesRuntime\APIPatchOperation;
use Psr\Http\Message\RequestInterface;

final class Middleware
{
    public static function setPatchOperation()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                $modify = [];
                if ('PATCH' == $request->getMethod()) {
                    $requestBody = json_decode($request->getBody(), true);
                    if (null !== $requestBody && array_key_exists('patchOperation', $requestBody)) {
                        switch ($requestBody['patchOperation']) {
                            case APIPatchOperation::MERGE_PATCH:
                                $contentType = APIPatchOperation::CONTENT_TYPE[APIPatchOperation::MERGE_PATCH];
                                break;
                            case APIPatchOperation::STRATEGIC_MERGE_PATCH:
                                $contentType =
                                    APIPatchOperation::CONTENT_TYPE[APIPatchOperation::STRATEGIC_MERGE_PATCH];
                                break;
                            default:
                                $contentType = APIPatchOperation::CONTENT_TYPE[APIPatchOperation::PATCH];
                                break;
                        }

                        unset($requestBody['patchOperation']);

                        $modify['body'] = Psr7\stream_for(\GuzzleHttp\json_encode($requestBody));

                    } else {
                        $contentType = APIPatchOperation::CONTENT_TYPE[APIPatchOperation::PATCH];
                    }
                    $modify['set_headers']['Content-Type'] = $contentType;
                }

                return $handler(Psr7\modify_request($request, $modify), $options);
            };
        };
    }
}