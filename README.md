 Test
============

This project's main purpose is to complete the following tests:

###  Backend Test

This application constitutes of parts written in Python and parts written in PHP. 
Python was used to build the IMDB spider using the scrapy framework. 
PHP was used to render the user facing application. I chose to use the Symfony framework for its great set of tools and performance.

The result is available at:

http://sptf.bkuberek.com/imdb/toplist

### Frontend Test

The results of this test are available at: 

http://sptf.bkuberek.com


## Installation requirements

* PHP >= 5.3.3 (also see symfony requirements)
* Python 2.5 - 2.7
* MySQL 5 (Percona was used)
* Memcache server
* Symfony 2.0.1
* Scrapy (view scrapy requirements and my notes below)
* PHP's memcache extension (via PECL)
* Python's Memcache module
* PyMySQL

### Cron

add the following to crontab

    # crawl IMDB once a day at midnight
    0    0 * * * root /path/to/sptf_test/bin/crawl_imdb.sh

### MySQL Database

    CREATE DATABASE `imdb_toplist` CHARSET utf8 COLLATE utf8_general_ci;
    
    USE `imdb_toplist`;
    
    CREATE TABLE `movie` (
      `id` int(11) unsigned NOT NULL,
      `url` varchar(255) DEFAULT NULL,
      `title` varchar(255) NOT NULL DEFAULT '',
      `original_title` varchar(255) DEFAULT NULL,
      `description` varchar(511) DEFAULT NULL,
      `year` smallint(4) NOT NULL,
      `length` smallint(5) unsigned NOT NULL DEFAULT '0',
      `director` varchar(128) DEFAULT NULL,
      `image_small` varchar(255) DEFAULT NULL,
      `image_large` varchar(255) DEFAULT NULL,
      `rating` decimal(2,2) unsigned NOT NULL DEFAULT '0.00',
      `votes` int(11) unsigned NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`),
      UNIQUE KEY `title_idx` (`title`),
      KEY `year_idx` (`year`),
      KEY `rating_idx` (`rating`),
      KEY `votes_idx` (`votes`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    
    CREATE USER 'imdb'@'localhost' IDENTIFIED BY 'imdb123';
    GRANT ALL PRIVILEGES ON `imdb_toplist`.* TO 'imdb'@'localhost';
    FLUSH PRIVILEGES;

### Installation notes

I was not able to install Scrapy the "pip" way on neither Ubuntu 10 nor CentOS 6. On Mac OS X it installed correctly.

After running:

    pip install Scrapy

I would try to create the project and get the following exception:

    File "/usr/bin/scrapy", line 3, in <module>
        from scrapy.cmdline import execute
      File "/usr/lib/python2.6/site-packages/scrapy/cmdline.py", line 10, in <module>
        from scrapy.crawler import CrawlerProcess
      File "/usr/lib/python2.6/site-packages/scrapy/crawler.py", line 3, in <module>
        from twisted.internet import reactor, defer
    ImportError: No module named twisted.internet

So I got it to work by installing it this way:

**Ubuntu:**

    apt-get install python-twisted python-libxml2 python-pyopenssl python-simplejson

**CentOS:**

    yum install python-twisted libxml2-python python-pyopenssl python-simplejson

**both:**

    easy_install -U w3lib PyMySQL


## Afterthought

This project was done quick and the focus was on getting the test requirements met. 
There are a couple of things that should been done differently on a real world application.

Some of these are:

* scrape IMDB at slower pace to avoid causing problems to their system and being blacklisted
* sanitize the movie data before persisting them to the database
* check movie data against database data to avoid issuing `UPDATE` queries on items that did not change
* update cache layer upon updating the database to avoid cache being built upon user request
