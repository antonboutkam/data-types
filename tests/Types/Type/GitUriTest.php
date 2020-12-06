<?php

namespace Test\Hurah\Types\Type;

use Exception;
use Hurah\Types\Type\GitUri;
use Hurah\Types\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GitUriTest extends TestCase {

    function testValidCreate()
    {
        $aSomeValidUris = [
            'git@gitlab.com:NovumGit/innovation-app-docs-website.git',
            'https://gitlab.com/NovumGit/innovation-app-docs-website.git',
            'git@github.com:antonboutkam/hurah-installer.git',
            'https://github.com/antonboutkam/hurah-installer.git'
        ];

        foreach($aSomeValidUris as $sUri)
        {
            $oGitUri = new GitUri($sUri);
            $this->assertInstanceOf(GitUri::class, $oGitUri, $sUri);
        }

    }
    function testInvalidCreate()
    {
        $aSomeInvalidUris = [
            '\/d/\*.23',
            null
        ];

        foreach($aSomeInvalidUris as $sUri)
        {
            $this->expectException(InvalidArgumentException::class);
            $oGitUri = new GitUri($sUri);
            $this->assertInstanceOf($oGitUri, GitUri::class, "Uri $sUri is considered invalid");
        }

    }
}
