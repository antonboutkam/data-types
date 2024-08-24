<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Iban;
use Hurah\Types\Type\IbanCollection;
use PHPUnit\Framework\TestCase;

class IbanCollectionTest extends TestCase
{
	/**
	 * @throws InvalidArgumentException
	 */
	public function testConstructWithValidIbanStrings()
	{
		$ibanStrings = ['GB82WEST12345698765432', 'FR1420041010050500013M02606'];
		$ibanCollection = new IbanCollection($ibanStrings);

		$this->assertCount(2, $ibanCollection);
		$this->assertEquals('GB82WEST12345698765432', (string)$ibanCollection->current());
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testAddString()
	{
		$ibanCollection = new IbanCollection();
		$ibanCollection->addString('GB82WEST12345698765432');

		$this->assertCount(1, $ibanCollection);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testAddIban()
	{
		$iban = Iban::make('GB82WEST12345698765432');
		$ibanCollection = new IbanCollection();
		$ibanCollection->addIban($iban);

		$this->assertCount(1, $ibanCollection);
	}

	public function testAddInvalidType()
	{
		$this->expectException(InvalidArgumentException::class);

		$ibanCollection = new IbanCollection();
		$ibanCollection->add(123); // invalid type
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testContainsIban()
	{
		$ibanCollection = new IbanCollection(['GB82WEST12345698765432']);
		$iban = Iban::make('GB82WEST12345698765432');

		$this->assertTrue($ibanCollection->containsIban($iban));
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testFromArray()
	{
		$ibanArrays = [
			['GB82WEST12345698765432'],
			['FR1420041010050500013M02606']
		];
		$ibanCollection = IbanCollection::fromArray(...$ibanArrays);

		$this->assertCount(2, $ibanCollection);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testFromIbanCollections()
	{
		$collection1 = new IbanCollection(['GB82WEST12345698765432']);
		$collection2 = new IbanCollection(['FR1420041010050500013M02606']);

		$mergedCollection = IbanCollection::fromIbanCollections($collection1, $collection2);

		$this->assertCount(2, $mergedCollection);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testAppendCollections()
	{
		$collection1 = new IbanCollection(['GB82WEST12345698765432']);
		$collection2 = new IbanCollection(['FR1420041010050500013M02606']);

		$collection1->appendCollections($collection2);

		$this->assertCount(2, $collection1);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testToString()
	{
		$ibanCollection = new IbanCollection(['GB82WEST12345698765432', 'FR1420041010050500013M02606']);

		$this->assertEquals('GB82WEST12345698765432,FR1420041010050500013M02606', (string)$ibanCollection);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testReverse()
	{
		$ibanCollection = new IbanCollection(['GB82WEST12345698765432', 'FR1420041010050500013M02606']);
		$reversedCollection = $ibanCollection->reverse();

		$this->assertCount(2, $reversedCollection);
		$this->assertEquals('FR1420041010050500013M02606', (string)$reversedCollection->current());
	}

	// Add more tests as necessary to cover all methods and edge cases
}
