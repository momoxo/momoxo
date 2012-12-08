#!/usr/bin/env python
# -*- coding: utf-8 -*-

import argparse
import commands
import os

def replace_all(directory, name,  old, new):
	command("find %(directory)s -name '%(name)s' -type f -print0 | xargs -0 perl -i -pe 's/%(old)s/%(new)s/g'" % {"directory":directory, "name": name, "old": old, "new": new})

def command(command):
	print command
	result = commands.getstatusoutput(command)
	if result[0] > 0:
		raise Exception(result[1])
	return result[1]

def main():
	parser = argparse.ArgumentParser(description='Replace recursively')
	parser.add_argument('old', type=str, help='a string will be replaced')
	parser.add_argument('new', type=str, help='a string replacing with')
	parser.add_argument('name', type=str, help='file name, default is *.php', default="*.php")
	args = parser.parse_args()
	current_directory = os.getcwd()
	replace_all(current_directory, args.name, args.old, args.new)
if __name__ == "__main__":
	main()
