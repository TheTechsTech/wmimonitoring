-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 07. Desember 2009 jam 09:20
-- Versi Server: 5.1.33
-- Versi PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `wmi_monitoring`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `name`, `password`, `type`, `dateadded`, `status`) VALUES
(1, 'root', 'tukang servis', '63a9f0ea7bb98050796b649e85481845', 'Super Admin', '2009-02-19 16:50:00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `base_board`
--

CREATE TABLE IF NOT EXISTS `base_board` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `serialnumber` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `base_board`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `cdrom`
--

CREATE TABLE IF NOT EXISTS `cdrom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `drive` varchar(255) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `cdrom`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `computer`
--

CREATE TABLE IF NOT EXISTS `computer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `arch` varchar(255) NOT NULL,
  `domainrole` varchar(255) NOT NULL,
  `installdate` datetime NOT NULL,
  `ostype` varchar(255) NOT NULL,
  `servicepackmajorversion` varchar(255) DEFAULT NULL,
  `oscaption` varchar(255) NOT NULL,
  `buildnumber` int(10) unsigned NOT NULL,
  `version` varchar(255) NOT NULL,
  `registereduser` varchar(255) NOT NULL,
  `windowsdirectory` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `serialnumber` varchar(255) NOT NULL,
  `bootdevice` varchar(255) NOT NULL,
  `system_type` varchar(255) NOT NULL,
  `timezonecaption` varchar(255) NOT NULL,
  `timezonedaylightname` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `admin` int(10) unsigned DEFAULT NULL,
  `adminapprove` int(10) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `reason` varchar(255) DEFAULT NULL,
  `computer_profile` int(10) unsigned DEFAULT '1',
  `last_time_hw_audit` datetime DEFAULT NULL,
  `last_time_sw_audit` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `computer`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `computer_profile`
--

CREATE TABLE IF NOT EXISTS `computer_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `admin` int(10) unsigned NOT NULL,
  `timing_audit_hw` int(10) unsigned NOT NULL,
  `timing_audit_sw` int(10) unsigned NOT NULL,
  `is_monitor_registry` tinyint(1) NOT NULL DEFAULT '1',
  `is_monitor_process` tinyint(1) NOT NULL DEFAULT '1',
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `computer_profile`
--

INSERT INTO `computer_profile` (`id`, `name`, `admin`, `timing_audit_hw`, `timing_audit_sw`, `is_monitor_registry`, `is_monitor_process`, `dateadded`) VALUES
(1, 'Default Setting', 1, 30, 30, 1, 1, '2009-11-08 19:33:19');

-- --------------------------------------------------------

--
-- Stand-in structure for view `computer_status`
--
CREATE TABLE IF NOT EXISTS `computer_status` (
`hostname` varchar(255)
,`audit_hw` int(1)
,`audit_sw` int(1)
,`monitor_registry` tinyint(1)
,`monitor_process` tinyint(1)
,`status` varchar(255)
);
-- --------------------------------------------------------

--
-- Struktur dari tabel `firewire`
--

CREATE TABLE IF NOT EXISTS `firewire` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `firewire`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `floppy`
--

CREATE TABLE IF NOT EXISTS `floppy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `floppy`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `hardisk`
--

CREATE TABLE IF NOT EXISTS `hardisk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `interfacetype` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `partitions` int(10) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `pnpdeviceid` varchar(255) NOT NULL,
  `diskindex` int(10) unsigned NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `hardisk`
--


-- --------------------------------------------------------

--
-- Stand-in structure for view `hardware_report`
--
CREATE TABLE IF NOT EXISTS `hardware_report` (
`item` varchar(11)
,`count` bigint(21)
);
-- --------------------------------------------------------

--
-- Struktur dari tabel `interpreter_program`
--

CREATE TABLE IF NOT EXISTS `interpreter_program` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `command` varchar(255) NOT NULL,
  `addedby` int(10) unsigned NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `interpreter_program`
--

INSERT INTO `interpreter_program` (`id`, `name`, `command`, `addedby`, `dateadded`) VALUES
(1, 'run dll', 'rundll32.exe', 1, '2009-11-11 23:00:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keyboard`
--

CREATE TABLE IF NOT EXISTS `keyboard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `keyboard`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `logicaldisk`
--

CREATE TABLE IF NOT EXISTS `logicaldisk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `filesystem` varchar(255) NOT NULL,
  `freespace` int(10) unsigned NOT NULL,
  `volumename` varchar(255) NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `diskindex` int(10) unsigned NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `logicaldisk`
--


-- --------------------------------------------------------

--
-- Stand-in structure for view `log_computer`
--
CREATE TABLE IF NOT EXISTS `log_computer` (
`id` int(11) unsigned
,`hostname` varchar(255)
,`date` datetime
,`status` varchar(255)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `log_hardware`
--
CREATE TABLE IF NOT EXISTS `log_hardware` (
`id` int(11) unsigned
,`hostname` varchar(255)
,`date` datetime
,`item` varchar(11)
,`status` varchar(255)
,`admin` int(11) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `log_monitoring`
--
CREATE TABLE IF NOT EXISTS `log_monitoring` (
`id` int(11) unsigned
,`type` varchar(14)
,`hostname` varchar(255)
,`loginby` varchar(255)
,`dateadded` datetime
,`admin` int(11) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `log_process`
--
CREATE TABLE IF NOT EXISTS `log_process` (
`id` int(10) unsigned
,`hostname` varchar(255)
,`executecommand` varchar(255)
,`loginby` varchar(255)
,`status` varchar(255)
,`dateadded` datetime
,`admin` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `log_software`
--
CREATE TABLE IF NOT EXISTS `log_software` (
`id` double unsigned
,`hostname` varchar(255)
,`date` datetime
,`status` varchar(255)
,`admin` int(11) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `log_startup`
--
CREATE TABLE IF NOT EXISTS `log_startup` (
`id` double unsigned
,`hostname` varchar(255)
,`date` datetime
,`status` varchar(255)
,`admin` int(11) unsigned
);
-- --------------------------------------------------------

--
-- Struktur dari tabel `memory`
--

CREATE TABLE IF NOT EXISTS `memory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `banklabel` varchar(255) NOT NULL,
  `formfactor` varchar(255) NOT NULL,
  `capacity` int(10) unsigned NOT NULL,
  `speed` int(10) unsigned NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `memory`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `modem`
--

CREATE TABLE IF NOT EXISTS `modem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `devicetype` varchar(255) NOT NULL,
  `dialtype` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `modem`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `monitor`
--

CREATE TABLE IF NOT EXISTS `monitor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `monitormanufacturer` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `pnpdeviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `monitor`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `mouse`
--

CREATE TABLE IF NOT EXISTS `mouse` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `Caption` varchar(255) NOT NULL,
  `deviceinterface` varchar(255) NOT NULL,
  `pointingtype` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `mouse`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `networkcard`
--

CREATE TABLE IF NOT EXISTS `networkcard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `defaultipgateway` varchar(255) NOT NULL,
  `dhcpserver` varchar(255) NOT NULL,
  `dnshostname` varchar(255) NOT NULL,
  `ipaddress` varchar(255) NOT NULL,
  `ipsubnet` varchar(255) NOT NULL,
  `macaddress` varchar(255) NOT NULL,
  `dnsserversearchorder` varchar(255) NOT NULL,
  `adaptertype` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `networkcard`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `printer`
--

CREATE TABLE IF NOT EXISTS `printer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `flagdefault` tinyint(1) NOT NULL,
  `horizontalresolution` int(10) unsigned NOT NULL,
  `flaglocal` tinyint(1) NOT NULL,
  `shared` tinyint(1) NOT NULL,
  `sharename` varchar(255) NOT NULL,
  `verticalresolution` int(10) unsigned NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `printer`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `processor`
--

CREATE TABLE IF NOT EXISTS `processor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `maxclockspeed` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `socketdesignation` varchar(255) NOT NULL,
  `processorid` varchar(255) NOT NULL,
  `family` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `processor`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `process_trace`
--

CREATE TABLE IF NOT EXISTS `process_trace` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `executecommand` varchar(255) NOT NULL,
  `loginby` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `confirmby` int(10) unsigned DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `process_trace`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `registry_key`
--

CREATE TABLE IF NOT EXISTS `registry_key` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hive` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `arch` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `addedby` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `registry_key`
--

INSERT INTO `registry_key` (`id`, `hive`, `path`, `arch`, `dateadded`, `addedby`) VALUES
(1, 'HKEY_LOCAL_MACHINE', 'SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run', 'x32', '2009-11-11 12:11:24', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `registry_trace`
--

CREATE TABLE IF NOT EXISTS `registry_trace` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `hive` varchar(255) NOT NULL,
  `rootpath` varchar(255) NOT NULL,
  `loginby` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `confirmby` int(10) unsigned DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `registry_trace`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `software`
--

CREATE TABLE IF NOT EXISTS `software` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `installdate` date NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `architecture` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `software`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `sound`
--

CREATE TABLE IF NOT EXISTS `sound` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `isonboard` tinyint(1) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `sound`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `startup`
--

CREATE TABLE IF NOT EXISTS `startup` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `command` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `startupuser` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `startup`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `usb`
--

CREATE TABLE IF NOT EXISTS `usb` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `usb`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `timelogin` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `user_login`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `vga`
--

CREATE TABLE IF NOT EXISTS `vga` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hostname` varchar(255) NOT NULL,
  `adapterram` int(10) unsigned NOT NULL,
  `adaptercompatibility` varchar(255) NOT NULL,
  `currenthorizontalresolution` int(10) unsigned NOT NULL,
  `currentverticalresolution` int(10) unsigned NOT NULL,
  `videomemorytype` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `isonboard` tinyint(1) NOT NULL,
  `deviceid` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateremove` datetime DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `adminapprove` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `vga`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `white_list_program`
--

CREATE TABLE IF NOT EXISTS `white_list_program` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `executecommand` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  `addedby` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `white_list_program`
--


-- --------------------------------------------------------

--
-- Stand-in structure for view `year_monitoring`
--
CREATE TABLE IF NOT EXISTS `year_monitoring` (
`year` bigint(20)
);
-- --------------------------------------------------------

--
-- Structure for view `computer_status`
--
DROP TABLE IF EXISTS `computer_status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `computer_status` AS select `computer`.`hostname` AS `hostname`,if(((`computer`.`last_time_hw_audit` + interval `computer_profile`.`timing_audit_hw` day) <= now()),1,0) AS `audit_hw`,if(((`computer`.`last_time_sw_audit` + interval `computer_profile`.`timing_audit_sw` day) <= now()),1,0) AS `audit_sw`,`computer_profile`.`is_monitor_registry` AS `monitor_registry`,`computer_profile`.`is_monitor_process` AS `monitor_process`,`computer`.`status` AS `status` from (`computer` join `computer_profile` on((`computer`.`computer_profile` = `computer_profile`.`id`))) where (`computer`.`status` in (_latin1'new',_latin1'added'));

-- --------------------------------------------------------

--
-- Structure for view `hardware_report`
--
DROP TABLE IF EXISTS `hardware_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `hardware_report` AS select _utf8'base_board' AS `item`,count(0) AS `count` from `base_board` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'cdrom' AS `item`,count(0) AS `count` from `cdrom` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'firewire' AS `item`,count(0) AS `count` from `firewire` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'floppy' AS `item`,count(0) AS `count` from `floppy` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'hardisk' AS `item`,count(0) AS `count` from `hardisk` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'keyboard' AS `item`,count(0) AS `count` from `keyboard` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'logicaldisk' AS `item`,count(0) AS `count` from `logicaldisk` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'memory' AS `item`,count(0) AS `count` from `memory` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'modem' AS `item`,count(0) AS `count` from `modem` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'monitor' AS `item`,count(0) AS `count` from `monitor` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'mouse' AS `item`,count(0) AS `count` from `mouse` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'networkcard' AS `item`,count(0) AS `count` from `base_board` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'printer' AS `item`,count(0) AS `count` from `printer` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'processor' AS `item`,count(0) AS `count` from `processor` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'sound' AS `item`,count(0) AS `count` from `sound` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'usb' AS `item`,count(0) AS `count` from `usb` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove')) union select _utf8'vga' AS `item`,count(0) AS `count` from `vga` `computer_stock` where (`computer_stock`.`status` in (_latin1'added',_latin1'remove'));

-- --------------------------------------------------------

--
-- Structure for view `log_computer`
--
DROP TABLE IF EXISTS `log_computer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `log_computer` AS select `computer`.`id` AS `id`,`computer`.`hostname` AS `hostname`,`computer`.`dateadded` AS `date`,`computer`.`status` AS `status` from `computer` where (`computer`.`status` = _latin1'new') union select `computer`.`id` AS `id`,`computer`.`hostname` AS `hostname`,`computer`.`dateremove` AS `date`,`computer`.`status` AS `status` from `computer` where (`computer`.`status` = _latin1'remove');

-- --------------------------------------------------------

--
-- Structure for view `log_hardware`
--
DROP TABLE IF EXISTS `log_hardware`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `log_hardware` AS select `base_board`.`id` AS `id`,`base_board`.`hostname` AS `hostname`,`base_board`.`dateadded` AS `date`,_utf8'base_board' AS `item`,`base_board`.`status` AS `status`,`computer`.`admin` AS `admin` from (`base_board` join `computer` on(((`base_board`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`base_board`.`status` = _latin1'new') union select `base_board`.`id` AS `id`,`base_board`.`hostname` AS `hostname`,`base_board`.`dateremove` AS `date`,_utf8'base_board' AS `item`,`base_board`.`status` AS `status`,`computer`.`admin` AS `admin` from (`base_board` join `computer` on(((`base_board`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`base_board`.`status` = _latin1'remove') union select `cdrom`.`id` AS `id`,`cdrom`.`hostname` AS `hostname`,`cdrom`.`dateadded` AS `date`,_utf8'cdrom' AS `item`,`cdrom`.`status` AS `status`,`computer`.`admin` AS `admin` from (`cdrom` join `computer` on(((`cdrom`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`cdrom`.`status` = _latin1'new') union select `cdrom`.`id` AS `id`,`cdrom`.`hostname` AS `hostname`,`cdrom`.`dateremove` AS `date`,_utf8'cdrom' AS `item`,`cdrom`.`status` AS `status`,`computer`.`admin` AS `admin` from (`cdrom` join `computer` on(((`cdrom`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`cdrom`.`status` = _latin1'remove') union select `firewire`.`id` AS `id`,`firewire`.`hostname` AS `hostname`,`firewire`.`dateadded` AS `date`,_utf8'firewire' AS `item`,`firewire`.`status` AS `status`,`computer`.`admin` AS `admin` from (`firewire` join `computer` on(((`firewire`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`firewire`.`status` = _latin1'new') union select `firewire`.`id` AS `id`,`firewire`.`hostname` AS `hostname`,`firewire`.`dateremove` AS `date`,_utf8'firewire' AS `item`,`firewire`.`status` AS `status`,`computer`.`admin` AS `admin` from (`firewire` join `computer` on(((`firewire`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`firewire`.`status` = _latin1'remove') union select `floppy`.`id` AS `id`,`floppy`.`hostname` AS `hostname`,`floppy`.`dateadded` AS `date`,_utf8'floppy' AS `item`,`floppy`.`status` AS `status`,`computer`.`admin` AS `admin` from (`floppy` join `computer` on(((`floppy`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`floppy`.`status` = _latin1'new') union select `floppy`.`id` AS `id`,`floppy`.`hostname` AS `hostname`,`floppy`.`dateremove` AS `date`,_utf8'floppy' AS `item`,`floppy`.`status` AS `status`,`computer`.`admin` AS `admin` from (`floppy` join `computer` on(((`floppy`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`floppy`.`status` = _latin1'remove') union select `hardisk`.`id` AS `id`,`hardisk`.`hostname` AS `hostname`,`hardisk`.`dateadded` AS `date`,_utf8'hardisk' AS `item`,`hardisk`.`status` AS `status`,`computer`.`admin` AS `admin` from (`hardisk` join `computer` on(((`hardisk`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`hardisk`.`status` = _latin1'new') union select `hardisk`.`id` AS `id`,`hardisk`.`hostname` AS `hostname`,`hardisk`.`dateremove` AS `date`,_utf8'hardisk' AS `item`,`hardisk`.`status` AS `status`,`computer`.`admin` AS `admin` from (`hardisk` join `computer` on(((`hardisk`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`hardisk`.`status` = _latin1'remove') union select `keyboard`.`id` AS `id`,`keyboard`.`hostname` AS `hostname`,`keyboard`.`dateadded` AS `date`,_utf8'keyboard' AS `item`,`keyboard`.`status` AS `status`,`computer`.`admin` AS `admin` from (`keyboard` join `computer` on(((`keyboard`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`keyboard`.`status` = _latin1'new') union select `keyboard`.`id` AS `id`,`keyboard`.`hostname` AS `hostname`,`keyboard`.`dateremove` AS `date`,_utf8'keyboard' AS `item`,`keyboard`.`status` AS `status`,`computer`.`admin` AS `admin` from (`keyboard` join `computer` on(((`keyboard`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`keyboard`.`status` = _latin1'remove') union select `logicaldisk`.`id` AS `id`,`logicaldisk`.`hostname` AS `hostname`,`logicaldisk`.`dateadded` AS `date`,_utf8'logicaldisk' AS `item`,`logicaldisk`.`status` AS `status`,`computer`.`admin` AS `admin` from (`logicaldisk` join `computer` on(((`logicaldisk`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`logicaldisk`.`status` = _latin1'new') union select `logicaldisk`.`id` AS `id`,`logicaldisk`.`hostname` AS `hostname`,`logicaldisk`.`dateremove` AS `date`,_utf8'logicaldisk' AS `item`,`logicaldisk`.`status` AS `status`,`computer`.`admin` AS `admin` from (`logicaldisk` join `computer` on(((`logicaldisk`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`logicaldisk`.`status` = _latin1'remove') union select `memory`.`id` AS `id`,`memory`.`hostname` AS `hostname`,`memory`.`dateadded` AS `date`,_utf8'memory' AS `item`,`memory`.`status` AS `status`,`computer`.`admin` AS `admin` from (`memory` join `computer` on(((`memory`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`memory`.`status` = _latin1'new') union select `memory`.`id` AS `id`,`memory`.`hostname` AS `hostname`,`memory`.`dateremove` AS `date`,_utf8'memory' AS `item`,`memory`.`status` AS `status`,`computer`.`admin` AS `admin` from (`memory` join `computer` on(((`memory`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`memory`.`status` = _latin1'remove') union select `modem`.`id` AS `id`,`modem`.`hostname` AS `hostname`,`modem`.`dateadded` AS `date`,_utf8'modem' AS `item`,`modem`.`status` AS `status`,`computer`.`admin` AS `admin` from (`modem` join `computer` on(((`modem`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`modem`.`status` = _latin1'new') union select `modem`.`id` AS `id`,`modem`.`hostname` AS `hostname`,`modem`.`dateremove` AS `date`,_utf8'modem' AS `item`,`modem`.`status` AS `status`,`computer`.`admin` AS `admin` from (`modem` join `computer` on(((`modem`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`modem`.`status` = _latin1'remove') union select `monitor`.`id` AS `id`,`monitor`.`hostname` AS `hostname`,`monitor`.`dateadded` AS `date`,_utf8'monitor' AS `item`,`monitor`.`status` AS `status`,`computer`.`admin` AS `admin` from (`monitor` join `computer` on(((`monitor`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`monitor`.`status` = _latin1'new') union select `monitor`.`id` AS `id`,`monitor`.`hostname` AS `hostname`,`monitor`.`dateremove` AS `date`,_utf8'monitor' AS `item`,`monitor`.`status` AS `status`,`computer`.`admin` AS `admin` from (`monitor` join `computer` on(((`monitor`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`monitor`.`status` = _latin1'remove') union select `mouse`.`id` AS `id`,`mouse`.`hostname` AS `hostname`,`mouse`.`dateadded` AS `date`,_utf8'mouse' AS `item`,`mouse`.`status` AS `status`,`computer`.`admin` AS `admin` from (`mouse` join `computer` on(((`mouse`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`mouse`.`status` = _latin1'new') union select `mouse`.`id` AS `id`,`mouse`.`hostname` AS `hostname`,`mouse`.`dateremove` AS `date`,_utf8'mouse' AS `item`,`mouse`.`status` AS `status`,`computer`.`admin` AS `admin` from (`mouse` join `computer` on(((`mouse`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`mouse`.`status` = _latin1'remove') union select `networkcard`.`id` AS `id`,`networkcard`.`hostname` AS `hostname`,`networkcard`.`dateadded` AS `date`,_utf8'networkcard' AS `item`,`networkcard`.`status` AS `status`,`computer`.`admin` AS `admin` from (`networkcard` join `computer` on(((`networkcard`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`networkcard`.`status` = _latin1'new') union select `networkcard`.`id` AS `id`,`networkcard`.`hostname` AS `hostname`,`networkcard`.`dateremove` AS `date`,_utf8'networkcard' AS `item`,`networkcard`.`status` AS `status`,`computer`.`admin` AS `admin` from (`networkcard` join `computer` on(((`networkcard`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`networkcard`.`status` = _latin1'remove') union select `printer`.`id` AS `id`,`printer`.`hostname` AS `hostname`,`printer`.`dateadded` AS `date`,_utf8'printer' AS `item`,`printer`.`status` AS `status`,`computer`.`admin` AS `admin` from (`printer` join `computer` on(((`printer`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`printer`.`status` = _latin1'new') union select `printer`.`id` AS `id`,`printer`.`hostname` AS `hostname`,`printer`.`dateremove` AS `date`,_utf8'printer' AS `item`,`printer`.`status` AS `status`,`computer`.`admin` AS `admin` from (`printer` join `computer` on(((`printer`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`printer`.`status` = _latin1'remove') union select `processor`.`id` AS `id`,`processor`.`hostname` AS `hostname`,`processor`.`dateadded` AS `date`,_utf8'processor' AS `item`,`processor`.`status` AS `status`,`computer`.`admin` AS `admin` from (`processor` join `computer` on(((`processor`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`processor`.`status` = _latin1'new') union select `processor`.`id` AS `id`,`processor`.`hostname` AS `hostname`,`processor`.`dateremove` AS `date`,_utf8'processor' AS `item`,`processor`.`status` AS `status`,`computer`.`admin` AS `admin` from (`processor` join `computer` on(((`processor`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`processor`.`status` = _latin1'remove') union select `sound`.`id` AS `id`,`sound`.`hostname` AS `hostname`,`sound`.`dateadded` AS `date`,_utf8'sound' AS `item`,`sound`.`status` AS `status`,`computer`.`admin` AS `admin` from (`sound` join `computer` on(((`sound`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`sound`.`status` = _latin1'new') union select `sound`.`id` AS `id`,`sound`.`hostname` AS `hostname`,`sound`.`dateremove` AS `date`,_utf8'sound' AS `item`,`sound`.`status` AS `status`,`computer`.`admin` AS `admin` from (`sound` join `computer` on(((`sound`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`sound`.`status` = _latin1'remove') union select `usb`.`id` AS `id`,`usb`.`hostname` AS `hostname`,`usb`.`dateadded` AS `date`,_utf8'usb' AS `item`,`usb`.`status` AS `status`,`computer`.`admin` AS `admin` from (`usb` join `computer` on(((`usb`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`usb`.`status` = _latin1'new') union select `usb`.`id` AS `id`,`usb`.`hostname` AS `hostname`,`usb`.`dateremove` AS `date`,_utf8'usb' AS `item`,`usb`.`status` AS `status`,`computer`.`admin` AS `admin` from (`usb` join `computer` on(((`usb`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`usb`.`status` = _latin1'remove') union select `vga`.`id` AS `id`,`vga`.`hostname` AS `hostname`,`vga`.`dateadded` AS `date`,_utf8'vga' AS `item`,`vga`.`status` AS `status`,`computer`.`admin` AS `admin` from (`vga` join `computer` on(((`vga`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`vga`.`status` = _latin1'new') union select `vga`.`id` AS `id`,`vga`.`hostname` AS `hostname`,`vga`.`dateremove` AS `date`,_utf8'vga' AS `item`,`vga`.`status` AS `status`,`computer`.`admin` AS `admin` from (`vga` join `computer` on(((`vga`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`vga`.`status` = _latin1'remove');

-- --------------------------------------------------------

--
-- Structure for view `log_monitoring`
--
DROP TABLE IF EXISTS `log_monitoring`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `log_monitoring` AS select `registry_trace`.`id` AS `id`,_utf8'registry_trace' AS `type`,`registry_trace`.`hostname` AS `hostname`,`registry_trace`.`loginby` AS `loginby`,`registry_trace`.`dateadded` AS `dateadded`,`computer`.`admin` AS `admin` from (`registry_trace` join `computer` on(((`registry_trace`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`registry_trace`.`status` = _latin1'new') union select `log_process`.`id` AS `id`,_utf8'process_trace' AS `type`,`log_process`.`hostname` AS `hostname`,`log_process`.`loginby` AS `loginby`,`log_process`.`dateadded` AS `dateadded`,`log_process`.`admin` AS `admin` from `log_process` where (`log_process`.`status` = _latin1'new');

-- --------------------------------------------------------

--
-- Structure for view `log_process`
--
DROP TABLE IF EXISTS `log_process`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `log_process` AS select `process_trace`.`id` AS `id`,`process_trace`.`hostname` AS `hostname`,`process_trace`.`executecommand` AS `executecommand`,`process_trace`.`loginby` AS `loginby`,`process_trace`.`status` AS `status`,`process_trace`.`dateadded` AS `dateadded`,`computer`.`admin` AS `admin` from (`process_trace` join `computer` on(((`process_trace`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (not(`process_trace`.`executecommand` in (select `white_list_program`.`executecommand` AS `executecommand` from `white_list_program`)));

-- --------------------------------------------------------

--
-- Structure for view `log_software`
--
DROP TABLE IF EXISTS `log_software`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `log_software` AS select `software`.`id` AS `id`,`software`.`hostname` AS `hostname`,`software`.`dateadded` AS `date`,`software`.`status` AS `status`,`computer`.`admin` AS `admin` from (`software` join `computer` on(((`software`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`software`.`status` = _latin1'new') union select `software`.`id` AS `id`,`software`.`hostname` AS `hostname`,`software`.`dateremove` AS `date`,`software`.`status` AS `status`,`computer`.`admin` AS `admin` from (`software` join `computer` on(((`software`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`software`.`status` = _latin1'remove');

-- --------------------------------------------------------

--
-- Structure for view `log_startup`
--
DROP TABLE IF EXISTS `log_startup`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `log_startup` AS select `startup`.`id` AS `id`,`startup`.`hostname` AS `hostname`,`startup`.`dateadded` AS `date`,`startup`.`status` AS `status`,`computer`.`admin` AS `admin` from (`startup` join `computer` on(((`startup`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`startup`.`status` = _latin1'new') union select `startup`.`id` AS `id`,`startup`.`hostname` AS `hostname`,`startup`.`dateremove` AS `date`,`startup`.`status` AS `status`,`computer`.`admin` AS `admin` from (`startup` join `computer` on(((`startup`.`hostname` = `computer`.`hostname`) and (`computer`.`status` = _latin1'added')))) where (`startup`.`status` = _latin1'remove');

-- --------------------------------------------------------

--
-- Structure for view `year_monitoring`
--
DROP TABLE IF EXISTS `year_monitoring`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `year_monitoring` AS select distinct year(`process_trace`.`dateadded`) AS `year` from `process_trace` union select distinct year(`registry_trace`.`dateadded`) AS `year` from `registry_trace`;