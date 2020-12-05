<?php

namespace Hurah\Types\Type;

class File extends AbstractDataType implements IGenericDataType {
    function getContents() {
        return new PlainText(file_get_contents($this));
    }
    function create() {
        touch($this);
        chmod($this, 0777);
    }
}
