<?php

namespace App;

abstract class CodeSearchApiWrapper
{
    public abstract function search($params);
    public abstract function format($results);
}
