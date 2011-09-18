#!/bin/sh
# encoding: utf-8

curdir=`pwd`

cd `dirname $0`/../imdb

/usr/bin/scrapy crawl imdb_toplist

cd $curdir

echo
echo 'DONE'
echo