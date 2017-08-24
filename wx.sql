/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50542
 Source Host           : 127.0.0.1
 Source Database       : basic

 Target Server Type    : MySQL
 Target Server Version : 50542
 File Encoding         : utf-8

 Date: 08/24/2017 10:15:40 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `wx_log_gateway`
-- ----------------------------
DROP TABLE IF EXISTS `wx_log_gateway`;
CREATE TABLE `wx_log_gateway` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `get_data` text COLLATE utf8_unicode_ci,
  `post_data` text COLLATE utf8_unicode_ci,
  `return_xml` text COLLATE utf8_unicode_ci,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_wx_log_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `wx_msg`
-- ----------------------------
DROP TABLE IF EXISTS `wx_msg`;
CREATE TABLE `wx_msg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `appid` varchar(255) NOT NULL COMMENT '应用id',
  `status` tinyint(4) NOT NULL COMMENT '1发送成功，2发送失败，3已发送，待返回',
  `template_id` tinyint(4) NOT NULL COMMENT '模板id',
  `content` varchar(2000) DEFAULT NULL,
  `errcode` int(11) NOT NULL COMMENT '错误代码',
  `errmsg` varchar(255) NOT NULL COMMENT '异常信息',
  `msgid` bigint(20) NOT NULL DEFAULT '0' COMMENT '消息id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `send_time` datetime DEFAULT NULL,
  `touser` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `appid` (`appid`) USING BTREE,
  KEY `msgid` (`msgid`) USING BTREE,
  KEY `touser` (`touser`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `wx_token`
-- ----------------------------
DROP TABLE IF EXISTS `wx_token`;
CREATE TABLE `wx_token` (
  `name` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL DEFAULT '',
  `expires_time` bigint(11) NOT NULL DEFAULT '0',
  `access_count` int(11) DEFAULT '0',
  PRIMARY KEY (`name`),
  KEY `expires_time` (`expires_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `wx_token`
-- ----------------------------
BEGIN;
INSERT INTO `wx_token` VALUES ('access_token', '-YSbyUeXhUOm37tfV-NxZyxWvU78laaUoqiH5QekiiSf7xXVuG1iW-nfAscWzVnv3wWQiOEAGqI3SbahzGYStVPyWeuZcGGV9Va4erL7LhBwR1iscGCWkuuZZOS8ffnyEABbAGAZVW', '1503547969', '1'), ('jsapi_ticket', 'kgt8ON7yVITDhtdwci0qeTI9UpHNKGJBAlBmhaIoxQKM7ERgpGgqBVSAuXPHQoKqiPwpvYjwIapP817ZeS06PQ', '0', '0');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
