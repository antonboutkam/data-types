<?php

namespace Test\Hurah\Types\Type\Html;

use Hurah\Types\Type\Html\Element;
use Hurah\Types\Type\Html\Link;
use Hurah\Types\Type\PlainText;
use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase {

    public function testCreate() {
        $oReact1 = (new Link(['html' => 'React', 'href' => 'https://react.dev/', 'target' => Link::TARGET_BLANK]));
        $oReact2 = (new Link(['html' => new PlainText('React'), 'href' => 'https://react.dev/', 'target' => Link::TARGET_BLANK]));
        $sExpected = '<a href="https://react.dev/" target="_blank">' . "\n" . 'React' . "\n" . '</a>';

        $this->assertEquals($oReact1, $oReact2, $oReact1 . ' != ' . $oReact2);
        $this->assertEquals($sExpected, (string)$oReact1, $oReact1 . ' != ' . $oReact2);


    }



}
