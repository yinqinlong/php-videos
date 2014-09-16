CREATE TABLE `robber` (
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`user` varchar(20) NOT NULL,
			`url` varchar(200) NOT NULL,
			`download_url` varchar(1000) NOT NULL,
			`vms_url` varchar(200) NOT NULL DEFAULT '',
			`title` varchar(100) NOT NULL DEFAULT '',
			`filename` varchar(100) NOT NULL DEFAULT '' COMMENT '下载后保存的文件名',
			`status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0待下载 1已下载 2已上传',
			`delogo` tinyint(2) NOT NULL DEFAULT '0',
			`merge` tinyint(2) NOT NULL DEFAULT '0',
			`coord` varchar(20) NOT NULL,
			`createtime` int(11) NOT NULL DEFAULT '0',
			`updatetime` int(11) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 
