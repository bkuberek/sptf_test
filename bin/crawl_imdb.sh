#!/bin/sh
# encoding: utf-8

curdir=`pwd`
scrapy=`which scrapy`

cd `dirname $0`/../imdb

$scrapy crawl imdb_toplist

cd $curdir

echo
echo 'DONE'
echo