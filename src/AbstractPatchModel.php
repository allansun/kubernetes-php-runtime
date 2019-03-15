<?php


namespace KubernetesRuntime;


class AbstractPatchModel extends AbstractModel
{
    protected $isRawObject = true;

    public function __construct($data = null)
    {
        $this->rawData = $data;

        parent::__construct();
    }
}