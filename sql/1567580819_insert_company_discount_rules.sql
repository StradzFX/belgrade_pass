CREATE TABLE IF NOT EXISTS `company_discount_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `training_school` int(11) NOT NULL,
  `day_from` int(11) NOT NULL,
  `day_to` int(11) NOT NULL,
  `hours_from` int(11) NOT NULL,
  `hours_to` int(11) NOT NULL,
  `discount` decimal(11,1) NOT NULL,
  `maker` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `makerDate` datetime NOT NULL,
  `checker` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `checkerDate` datetime DEFAULT NULL,
  `pozicija` int(11) DEFAULT NULL,
  `jezik` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recordStatus` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modNumber` int(11) NOT NULL,
  `multilang_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;