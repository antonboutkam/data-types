<?php

namespace Hurah\Types\Type\Helper;

use Hurah\Types\Type\AbstractCollectionDataType;

class Loop
{
    private AbstractCollectionDataType $oParentContext;
    private int $index = -1;
    private bool $bIsFirst = true;
    private bool $bIsLast = false;

    public function __construct(AbstractCollectionDataType $oParentContext)
    {
        $this->oParentContext = $oParentContext;
    }

    public function next():self
    {
        ++$this->index;
        $this->bIsFirst = ($this->index0() === 0);
        $this->bIsLast = ($this->index() === $this->oParentContext->length());
        return $this;
    }

    /**
     * The current iteration of the loop. (0 indexed)
     * @return int
     */
    public function index0():int {
        return $this->index;
    }

    /**
     * The current iteration of the loop. (1 indexed)
     * @return int
     */
    public function index():int {
        return $this->index + 1;
    }

    /**
     * True if first iteration
     * @return bool
     */
    public function isFirst():bool {
        return $this->bIsFirst;
    }

    /**
     * True if last iteration
     * @return bool
     */
    public function isLast():bool {
        return $this->bIsLast;
    }

    /**
     * The number of items in the sequence
     * @return int
     */
    public function length():int {
        return $this->oParentContext->length();
    }

    /**
     * The parent context
     * @return AbstractCollectionDataType
     */
    public function parent():AbstractCollectionDataType {
        return $this->oParentContext;
    }

}