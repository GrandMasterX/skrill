<?php

namespace grandmasterx\Skrill\Models;

use grandmasterx\Skrill\Components\SkrillException;

/**
 * @package grandmasterx\Skrill
 */
abstract class Model
{
    /**
     * @param array $params
     * @param bool|false $skipNonExistent
     * @throws SkrillException
     */
    function __construct($params = [], $skipNonExistent = false) {
        foreach ($params as $name => $value) {
            if (!property_exists($this, $name)) {
                if (!$skipNonExistent) {
                    throw new SkrillException(sprintf('Invalid property %s', $name));
                }
            } else {
                $this->$name = $value;
            }
        }
    }
}