CREATE TABLE `SITE_DB`.`item_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,

  `name` varchar(100) NOT NULL,
  `v_text` text DEFAULT NULL,
  `v_html` text DEFAULT NULL,
  `v_email` varchar(100) DEFAULT NULL,
  `v_tel` varchar(100) DEFAULT NULL,
  `v_password` varchar(100) DEFAULT NULL,
  `v_select` varchar(100) DEFAULT NULL,


  `v_datetime` timestamp NULL DEFAULT NULL,
  `v_date` date NULL DEFAULT NULL,
  `v_integer` int(11) DEFAULT NULL,
  `v_number` varchar(100) DEFAULT NULL,

  `v_checkbox` varchar(100) DEFAULT NULL,
  `v_radiobuttons` varchar(100) DEFAULT NULL,

  `v_location` varchar(255) DEFAULT NULL,
  `v_latitude` double DEFAULT NULL,
  `v_longitude` double DEFAULT NULL,


  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_tests_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `SITE_DB`.`items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
