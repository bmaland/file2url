#!/bin/sh

arg=$#
url="http://file2url/store/"
apikey="key"

if test $arg = 1
then
	curl -s -F "file=@$1" -F "apikey=$apikey" $url
else
	echo "Usage: file2url.sh <file>"
fi

