<?php


namespace KubernetesRuntime;


final class APIPatchOperation
{
    const PATCH = 'patch';
    const MERGE_PATCH = 'merge-patch';
    const STRATEGIC_MERGE_PATCH = 'strategic-merge-patch';

    const CONTENT_TYPE = [
        self::PATCH                 => 'application/json-patch+json',
        self::MERGE_PATCH           => 'application/merge-patch+json',
        self::STRATEGIC_MERGE_PATCH => 'application/strategic-merge-patch+json',
    ];
}