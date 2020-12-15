<?php

namespace Test\Hurah\Types\Type;

use Hurah\Types\Type\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase {

    public function test__toString() {

        $oHtml = new Html('<div class="x"><a href="/y">ss</a></div>');
        $this->assertEquals(
'<div class="x">
  <a href="/y">ss</a>
</div>
', "{$oHtml}");
    }
}
