#!/usr/bin/env zsh

set -eux
SCRIPT_NAME=$(basename $0)

help() {
	set +x
	echo "usage:"
	echo "    \$ $SCRIPT_NAME \"<old class name>\" \"<new class name>\""
	exit 1
}

if [ $# -lt 2 ]
then
	help
fi 

old_class=$1
new_class=$2

autouse="$(dirname $0)/auto-use.php"

for file in $(grep -rl "$old_class" **/*.php) 
do
	$autouse "$file" "$old_class" "$new_class"
done

