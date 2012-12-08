#!/usr/bin/env bash

set -eux

SCRIPT_NAME=$(basename $0)
__DIR__=$(dirname $(php -r "echo realpath('$0');"))
REPLACE_ALL="$__DIR__/replace-all.py"
USE_CLASS="$__DIR__/use-class.zsh"

help() {
	set +x
	echo "usage:"
	echo "  \$ $SCRIPT_NAME <src> <dist> <new_class_name>"
	exit 1
}

if [ $# -ne 3 ]
then
	help
fi 

SOURCE=$1
DIST=$2
NEW_CLASS_NAME=$3

if [ ! -f $SOURCE ]
then
	echo "file not found: $SOURCE"
	exit 1
fi

if [ -f $DIST ]
then
	echo "file already exists: $DIST"
	exit 1
fi

DIST_DIR=$(dirname $DIST)
OLD_CLASS_NAME=$(php -r "echo pathinfo('$(basename $SOURCE)', PATHINFO_FILENAME);")
NEW_CLASS_BASENAME=${NEW_CLASS_NAME##*\\}
NAMESPACE=${NEW_CLASS_NAME%\\*}
NAMESPACE=$(echo $NAMESPACE | sed -e 's/\\/\\\\/')

$USE_CLASS "$OLD_CLASS_NAME" "$NEW_CLASS_NAME"
$REPLACE_ALL "$OLD_CLASS_NAME" "$NEW_CLASS_BASENAME" '*.php'

mkdir -p "$DIST_DIR"

mv "$SOURCE" "$DIST"

sed -e "2a\\
\\
namespace $NAMESPACE;\\
\\" $DIST > tmp
cat tmp > $DIST 
rm -f tmp

