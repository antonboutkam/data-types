<?php

namespace Hurah\Types\Type;


/**
 * Represents a regular expression
 * @package Hurah\Type
 */
class TestableCollection extends AbstractCollectionDataType implements ITestable
{
     public function current(): IGenericDataType
	 {
        return $this->array[$this->position];
    }

    /**
     * @param ...$regex Regex
     * @return self
     */
    public static function fromArray($aTestables):self
    {
        $self = new self();
        foreach($aTestables as $oTestable)
        {
            $self->add($oTestable);
        }
        return $self;
    }

    /**
     * @param ...$testable ITestable
     * @return self
     */
    public static function create(...$testable):self
    {
        $self = new self();
        foreach($testable as $one)
        {
            $self->add($one);
        }
        return $self;
    }

    public function addArray(array $aTestableObjects): self
    {
        foreach($aTestableObjects as $oTestable)
        {
            $this->array[] = $oTestable;
        }
        return $this;
    }

    public function add(ITestable $oTestable):self
    {
        $this->array[] = $oTestable;
        return $this;
    }

	/**
	 *
	 * @param ITestable $oSubject
	 *
	 * @return bool
	 */
    public function hasMatch(ITestable $oSubject):bool
    {
        foreach($this as $oTest)
        {
            if($oTest->test($oSubject))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * If one of the Regular expressions is a match this function returns true.
     * @param string $sSubject
     *
     * @return bool
     */
    public function test($sSubject):bool
    {
        foreach($this as $oTestable)
        {
            if($oTestable->test($sSubject))
            {
                return true;
            }
        }
        return false;
    }

}
