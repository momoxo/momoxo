#!/bin/bash

classes="foo bar baz"

set -eux

for class in $classes
do
	replace-all "function $class\(" "function __construct\("
	replace-all "parent::$class\(" "parent::__construct\("
done

