[![Latest Stable Version](https://poser.pugx.org/hurah/data-types/v)](https://packagist.org/packages/hurah/data-types) 
[![Total Downloads](https://poser.pugx.org/hurah/data-types/downloads)](https://packagist.org/packages/hurah/data-types) 
[![Latest Unstable Version](https://poser.pugx.org/hurah/data-types/v/unstable)](https://packagist.org/packages/hurah/data-types) 
[![License](https://poser.pugx.org/hurah/data-types/license)](https://packagist.org/packages/hurah/data-types) 
[![PHP Version Require](https://poser.pugx.org/hurah/data-types/require/php)](https://packagist.org/packages/hurah/data-types)
[![CircleCI Build](http://poser.pugx.org/hurah/data-types/circleci)](https://packagist.org/packages/hurah/data-types)

<p align="center"><a href="https://packagist.org/packages/hurah/data-types" target="_blank">
    <img src="https://raw.githubusercontent.com/antonboutkam/data-types/main/assets/logo.webp" alt="Hurah Data Types logo">
</a>
</p>
A growing set of general purpose data types and corresponding collections. This project is not 
intended as a "one size fits all" standards based library. It is mostly meant to be an ever-growing collection of 
datatypes and methods for casting and converting to promote interoperability between the systems that I create. 

All types are enforced to at least implement __toString so while implementing data-types exisiting code usually keeps
working.


#### OOP style conditions and loops
As an experiment I have added an oop style interface for conditions and loops. My usecase for this is a graphical / 
low code style system that uses a lot of generated code that i want as strongly typed  as possible so 
"context aware" features can be implemented. 


#### Collections
Many of the data-types come with a Collection version of the type, for instance a ```Path``` and a ```PathCollection```, 
the ```Collections``` are implementing an ```Iterator``` and allow strongly typed loops. 


[![Hurah data types](https://circleci.com/gh/antonboutkam/data-types.svg?style=svg)](https://github.com/antonboutkam/data-types)
