# Data types
A growing set of general purpose data types and corresponding collections. This project is not 
intended as a one size fits all standards based library. It is meant to promote interoperability between 
some of the projects that i work on. Many types come with useful utilities for 
casting and validation and have wrappers to abstract away the lower level core php code.

All types implement at least __toString which is very useful for things like debugging and logging but also makes core
very readable / human language like.

## Oop style conditions and loops
As an experiment i am adding an oop style interface for conditions and loops. My usecase for this is a graphical / 
low code style system that uses a lot of generated code that i want as strongly typed
as possible in an attempt to make all the generated code work always and know 
beforehand what is possible and what not. It also adds the option of later implementing very detailed
analysis of the logic that was implemented by the users of my systems.

[![antonboutkam](https://circleci.com/gh/antonboutkam/data-types.svg?style=svg)](https://antonboutkam.nl)
