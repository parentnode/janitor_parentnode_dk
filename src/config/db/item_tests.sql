CREATE TABLE `SITE_DB`.`item_tests` (
  `id` int(11) NOT NULL auto_increment,
  `item_id` int(11) NOT NULL,

  `name` varchar(100) NOT NULL,
  `v_text` text NOT NULL,
  `v_html` text NOT NULL,
  `v_email` varchar(100) NOT NULL,
  `v_tel` varchar(100) NOT NULL,
  `v_password` varchar(100) NOT NULL,
  `v_select` varchar(100) NOT NULL,


  `v_datetime` varchar(100) NOT NULL,
  `v_date` varchar(100) NOT NULL,
  `v_integer` int(11) NOT NULL,
  `v_number` varchar(100) NOT NULL,

  `v_checkbox` varchar(100) NOT NULL,
  `v_radiobuttons` varchar(100) NOT NULL,

  `v_location` varchar(255) NOT NULL,
  `v_latitude` double NOT NULL,
  `v_longitude` double NOT NULL,


  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `item_tests_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `SITE_DB`.`items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
