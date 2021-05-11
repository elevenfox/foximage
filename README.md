# Foxim

This is a customized pictures/images/photos browsing website framework. Has to be run under Apache, PHP and MySQL. 

- Based on file-system/file-structure
- DB tables could be regenerated from files
- Files are imported via import-script


## Install
* install LAMP
* git clone project
* Create 4 tables in MySQL
* Create/modify settings ini in conf.d
* Create/change theme and theme.ini
* Apache vhost settings 
  * **config files are located in z.deploy/apache.conf**
  * proxy?
  * cache?
  * https (use cerbot(letsencrypt) cert)
* install cerbot, use backup certs (/etc/letsencrypt) if possible
```$xslt
sudo yum install certbot python2-certbot-apache
sudo certbot certonly --apache
echo "0 0,12 * * * root python -c 'import random; import time; time.sleep(random.random() * 3600)' && certbot renew -q" | sudo tee -a /etc/crontab > /dev/null
```

## Conf

### settings.local.ini 
 - define which setting ini in conf.d to load

### settings ini in conf.d
 - db settings
 - site config
   - theme
   - site name
   - site logo
   - menu
   - api_server: (xparser server) is used in video detail page to make ajax call to parse video
   
   
## Theme
 - under docRoot
 - A theme is a completely different UI with separate templates
 - theme.ini
   - load css
   - load js

## DB
 - 4 tables, could be regenerated from files:
   - \<pre\>_files
   - \<pre\>_users
   - \<pre\>_tags
   - \<pre\>_tag_files     
   

## SEO: robots.txt and sitemap.xml
 - controlled in php
 - domain url based on current http/https + domain   
 

## Create a new site
 - Register a domain name
 - Decide a project name
 - DB: create 4 tables
   - \<project_name\>_files
   - \<project_name\>_users
   - \<project_name\>_tags
   - \<project_name\>_tag_files  
   
   Note: if copy from a files table, run query like below:
```angular2html
INSERT INTO `yfx_videos` 
(`title`,`source`,`source_url`,`duration`,`saved_locally`,`quality_1080p`,`quality_720p`,`quality_480p`,`quality_360p`,`quality_240p`,`thumbnail`,`gif_preview`,`tags`,`source_url_md5`,`save_flag`,`file_size`,`user_name`,`view_count`) 
    SELECT `title`,`source`,`source_url`,`duration`,`saved_locally`,`quality_1080p`,`quality_720p`,`quality_480p`,`quality_360p`,`quality_240p`,`thumbnail`,`gif_preview`,`tags`,`source_url_md5`,`save_flag`,`file_size`,`user_name`,`view_count` 
    FROM `pabcd_videos` 
    ORDER BY RAND();
```   

 - php codebase (foxcet)
   - create new settings file in conf.d
   - create new theme in docRoot/theme
     - theme.ini
     - styling (main.css)
     - logo
     - favicon
     - header: menu
     - footer: DMCA, 2257, privacy, terms, copyright   
   
 - run script `misc/01_regenerate_tags_and_tag_files.php` to generate tags and tag-files mapping
 
 - run script `misc/02_generate_users_and_assign_to_files.php` to generate users and assign to files
 
 - set cron of crawling-video on dev and sync prod
 
   