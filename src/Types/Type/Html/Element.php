<?php

namespace Hurah\Types\Type\Html;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\Html;
use Hurah\Types\Type\PlainText;

class Element extends AbstractDataType implements IElementizable
{

	use AttributesTrait;

	// When type is null, the child elements are returned and no container element (this object) is surrounding it.
	protected AttributeCollection $oAttributes;
	private ?string $sType = null;

	public function __construct($mValue = null) {
		$this->oAttributes = new AttributeCollection();
		$this->aChildren = [];
		if (isset($mValue['type'])) {
			$this->sType = new PlainText((string)$mValue['type']);
		}
		if (isset($mValue['attributes'])) {
			$this->oAttributes = $mValue['attributes'];
		}
		if (isset($mValue['html']) && $mValue['html'] instanceof IElementizable) {
			$this->addChild($mValue['html']);
		}
		if (isset($mValue['html']) && $mValue['html'] instanceof PlainText) {
			$this->addHtml($mValue['html']);
		}

		parent::__construct($mValue);
	}

	public static function create(string $sType = null, AttributeCollection $attributes = null): Element
	{
		$oElement = new Element();
		if ($sType) {
			$oElement->setType($sType);
		}
		if ($attributes) {
			$oElement->setAttributes($attributes);
		}
		return $oElement;
	}

	public function setType(string $sType): Element
	{
		$this->sType = $sType;
		return $this;
	}

	/**
	 * Checks if the given tag is an HTML element that requires a closing tag.
	 *
	 * @param string $sTag The name of the HTML element to check.
	 *
	 * @return bool True if the element requires a closing tag, false otherwise.
	 */
	public static function isElementWithClosingTag(string $sTag):bool
	{
		return !in_array($sTag, self::getElementsWithoutClosingTags());
	}

	/**
	 * Returns an array of HTML elements that do not require closing tags.
	 *
	 * @return array List of self-closing HTML elements.
	 */
	public static function getElementsWithoutClosingTags(): array
	{
		return [
			'area',
			'br',
			'hr',
			'img',
			'input',
			'meta',
			'link',
			'col',
			'base',
			'embed',
			'keygen',
			'param',
			'source',
			'wbr',
			'track',
		];
	}

	public function toElement(): Element
	{
		return $this;
	}

	public function __toString(): string
	{
		$oHtml = new Html();


		$oAttributes = $this->oAttributes->sort();

		if (!$this->sType) {
			return join(PHP_EOL, $this->aChildren);
		}
		if (!empty($this->aChildren)) {
			$oHtml->addLn("<{$this->sType}{$oAttributes}>");
			foreach ($this->aChildren as $oChild) {
				$oHtml->addLn("{$oChild}");
			}
			$oHtml->addLn('</' . $this->sType . '>');
		}
		elseif(self::isElementWithClosingTag($this->sType))
		{
			$oHtml->addLn("<{$this->sType}{$oAttributes}></{$this->sType}>");
		}
		else
		{
			$oHtml->addLn("<{$this->sType}{$oAttributes} />");
		}
		return "{$oHtml}";
	}
}
