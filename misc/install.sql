-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2012 at 09:39 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: 'foxCMS'
--

-- --------------------------------------------------------

--
-- Table structure for table 'videos'
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` mediumtext NOT NULL,
  `source` varchar(255) NOT NULL DEFAULT '',
  `source_url` varchar(255) NOT NULL DEFAULT '',
  `duration` int(11) NOT NULL,
  `saved_locally` int(11) NOT NULL DEFAULT 0,
  `quality_1080p` mediumtext DEFAULT NULL,
  `quality_720p` mediumtext DEFAULT NULL,
  `quality_480p` mediumtext DEFAULT NULL,
  `quality_360p` mediumtext DEFAULT NULL,
  `quality_240p` mediumtext DEFAULT NULL,
  `thumbnail` mediumtext DEFAULT NULL,
  `gif_preview` longtext DEFAULT NULL,
  `tags` longtext DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source_url_md5` varchar(40) NOT NULL,
  `save_flag` int(2) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `user_name` varchar(60) DEFAULT NULL,
  `view_count` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `source_url` (`source_url`),
  KEY `source_url_md5` (`source_url_md5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'users'
--

CREATE TABLE `users` (
  `uid` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Primary Key: Unique user ID.',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT 'Unique user name.',
  `pass` varchar(128) NOT NULL DEFAULT '' COMMENT 'User’s password (hashed).',
  `mail` varchar(254) DEFAULT '' COMMENT 'User’s e-mail address.',
  `theme` varchar(255) NOT NULL DEFAULT '' COMMENT 'User’s default theme.',
  `signature` varchar(255) NOT NULL DEFAULT '' COMMENT 'User’s signature.',
  `signature_format` varchar(255) DEFAULT NULL COMMENT 'The filter_format.format of the signature.',
  `created` int(11) NOT NULL DEFAULT 0 COMMENT 'Timestamp for when user was created.',
  `access` int(11) NOT NULL DEFAULT 0 COMMENT 'Timestamp for previous time user accessed the site.',
  `login` int(11) NOT NULL DEFAULT 0 COMMENT 'Timestamp for user’s last login.',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Whether the user is active(1) or blocked(0).',
  `timezone` varchar(32) DEFAULT NULL COMMENT 'User’s time zone.',
  `language` varchar(12) NOT NULL DEFAULT '' COMMENT 'User’s default language.',
  `picture` int(11) NOT NULL DEFAULT 0 COMMENT 'Foreign key: file_managed.fid of user’s picture.',
  `init` varchar(254) DEFAULT '' COMMENT 'E-mail address used for initial account creation.',
  `data` longblob DEFAULT NULL COMMENT 'A serialized array of name value pairs that are related to the user. Any form values posted during user edit are stored and are loaded into the $user object during user_load(). Use of this field is discouraged and it will likely disappear in a future...',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`),
  KEY `access` (`access`),
  KEY `created` (`created`),
  KEY `mail` (`mail`),
  KEY `picture` (`picture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores user data.';

-- --------------------------------------------------------

--
-- Table structure for table 'tags'
--

CREATE TABLE `tags` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key: Unique term ID.',
  `vid` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'The taxonomy_vocabulary.vid of the vocabulary to which the term is assigned.',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'The term name.',
  `description` longtext DEFAULT NULL COMMENT 'A description of the term.',
  `format` varchar(255) DEFAULT NULL COMMENT 'The filter_format.format of the description.',
  `weight` int(11) NOT NULL DEFAULT 0 COMMENT 'The weight of this term in relation to other terms.',
  PRIMARY KEY (`tid`),
  KEY `taxonomy_tree` (`vid`,`weight`,`name`),
  KEY `vid_name` (`vid`,`name`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores term information.';

-- --------------------------------------------------------

--
-- Table structure for table 'tag_video'
--

CREATE TABLE `tag_video` (
  `tid` int(11) unsigned NOT NULL,
  `term_name` varchar(255) NOT NULL DEFAULT '',
  `video_id` int(11) unsigned DEFAULT NULL,
  `video_md5_id` varchar(50) DEFAULT '',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `tid` (`tid`),
  KEY `video_id` (`video_id`),
  KEY `term_name` (`term_name`),
  KEY `video_md5_id` (`video_md5_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'legacy_url_alias'
--

CREATE TABLE `legacy_url_alias` (
  `video_id` int(11) unsigned DEFAULT NULL,
  `video_md5_id` varchar(50) DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `alias` (`alias`),
  KEY `video_id` (`video_id`),
  KEY `video_md5_id` (`video_md5_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
