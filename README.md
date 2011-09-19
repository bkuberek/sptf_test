SPTF Tests
==========

**tests:** "Backend Web Test" and "Frontend Test"

**Note:** I was given 2 tests and I tried to complete both of them as best as I could given the time and circumstances. 
The results may not be exactly per the spec but I attempted to implement all requirements. Please read below for links to preview the apps.


## Frontend Test

The result of this test is available at: [sptf.bkuberek.com](http://sptf.bkuberek.com)

[W3C Valid HTML5](http://validator.w3.org/check?uri=http%3A%2F%2Fsptf.bkuberek.com%2F)

What's in there:

1. HTML5 where applicable
2. Good SEO and accessibility
3. Unobtrusive JavaScript
4. Compiled JavaScript using closure
5. Compiled CSS using yuicompressor
6. Modal window with interactive form and validation (sorry this was poorly done due to lack of time)
7. Cross browser support (tested on Chrome, Safari, Firefox, Opera, IE7+, Dolphin HD, Android Stock Browser)


**Disclosure:** This did not come up as I had in mind for I was tired. 
I had worked all night on the Backend Test and it was around 6am when I started to work on the "Try Sptf Premium for free" modal window and form validation.
I will have to leave it as is but if you want I will can show you more JavaScript/Ajax work I have already done. 
Most of my work is not publicly available but I can show it to you in person.


##  Backend Test

The result is available at: [sptf.bkuberek.com/imdb](http://sptf.bkuberek.com/imdb)

This application is part Python and part PHP. 
Python was used to build the IMDB bot using the [Scrapy](http://scrapy.org) framework. 
PHP was used to render the user facing application. I chose to use the [Symfony](http://symfony.com) framework for its great set of tools and performance.

I was a bit confused with the test spec and I could not ask questions as I worked nightly over the weekend. So here is what I have done:

**bot:**

1. Built a bot using the [Scrapy](http://scrapy.org) framework.
2. The bot launches a spider to the given URL (http://www.imdb.com/charts/top).
3. The spider looks for the "Votes by Decade" section on the left sidebar and crawls into those links.
4. For each of the pages, the spider parses the tabular list of movies and scrapes row and columns and hydrates an ImdbItem object.
5. Then the ImdbPipeline does some basic validation and persists the ImdbItem to the database.

**Note:** on item 3 above, I decided to go this route because I was confused as to how I would gather only 10 items and have 10 items per date upon filtering. 
At the time, I thought of scraping all movies under the "decades" section for I would have all top movies for each date date. 
Then I could work with more data and have something meaningful t display.
Today I realize that the results are slightly different from the "Top 250" displayed at `/charts/top` page because for that particular list they only count votes from regular voters.

**web app:**

1. Built a simple Symfony Bundle to house the Models, Views and Controllers. (this bundle also renders the frontend test, see above).
2. Used [Doctrine 2 DBAL](http://www.doctrine-project.org/projects/dbal) and [Doctrine 2 ORM](http://www.doctrine-project.org/projects/orm) to query the database.
3. Results are ordered by `rating desc` and `votes desc` in order to display "ranking".
4. Used Memcache to cache query results. Results are cached until 1AM of next day. The cache then needs to be rebuild, which happens upon first request. (see Afterthoughts section for additional notes)

-I left the debug toolbar visible at the bottom of the page on purpose.- 
-You can look at the bottom right for a DB icon. Next to it there is a number of queries for the current page.-
I turned debugging off in order to enable css and javascript compression. So there wont be a debug toolbar.

You can see code I have written in this files:

    /sptf_test/
        app/
            Resources/
                views/
                    base.html.twig
        imdb/
            imdb/
                spiders/
                    imdb_spider.py
                items.py
                pipelines.py
        src/
            BK/
                Bundle/
                    sptfBundle/
                        Controller/
                            DefaultController.php
                            IMDBController.php
                        Entity/
                            Movie.php
                        Resources/
                            views/
                                Default/
                                    index.html.twig
                                    try.html.twig
                                IMDB/
                                    movie.html.twig
                                    toplist.html.twig
        web/
            css/
                main.css
            images/
            js/
                app.js
                

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
* closurecompiler/compiler.jar
* yuicompressor-2.4.x.jar

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


### Setup project

**clone repo:**

    cd /srv/www
    git clone git://github.com/bkuberek/sptf_test.git sptf
    cd sptf
    git submodule init && git submodule update
    mkdir -p app/cache app/logs
    
**update config:** we need to update the location to closure and yuicompressor. 

* Open `app/config/config.yml` and update the lines 30-34:

        # Assetic Configuration
        assetic:
            debug: %kernel.debug%
            use_controller: false
            filters:
                cssrewrite: ~
                closure:
                    jar: /srv/lib/java/closurecompiler/compiler.jar
                yui_css:
                    jar: /srv/lib/java/yuicompressor/yuicompressor-2.4.6.jar
                
* Update ACL settings. See [this page](http://symfony.com/doc/current/book/installation.html#downloading-a-symfony2-distribution) for instructions.
* Compress assets

        ./app/console assetic:dump


## Afterthought

This project was done quick and the focus was on getting the test requirements met. 
There are a couple of things that should been done differently on a real world application.

Some of these are:

* scrape IMDB at slower pace to avoid causing problems to their system and being blacklisted
* sanitize the movie data before persisting them to the database
* check movie data against database data to avoid issuing `UPDATE` queries on items that did not change
* update cache layer upon updating the database to avoid cache being built upon user request
