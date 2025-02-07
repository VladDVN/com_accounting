SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `#__categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lft` int(11) NOT NULL DEFAULT 0,
  `rgt` int(11) NOT NULL DEFAULT 0,
  `level` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `path` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT 0,
  `checked_out` int(10) UNSIGNED DEFAULT NULL,
  `checked_out_time` datetime DEFAULT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `params` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_time` datetime NOT NULL,
  `modified_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified_time` datetime NOT NULL,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`(100)),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`(100)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__categories` VALUES
(20, 104, 1, 11, 44, 1, 'dovidnyk', 'com_accounting', 'Довідник', 'dovidnyk', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-06 13:11:54', 248, '2024-09-06 13:11:54', 0, '*', 1),
(21, 108, 20, 12, 13, 2, 'dovidnyk/clients', 'com_accounting', 'Клієнти', 'clients', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-18 14:06:26', 248, '2024-09-18 14:06:26', 0, '*', 1),
(22, 109, 20, 14, 15, 2, 'dovidnyk/organizations', 'com_accounting', 'Організації', 'organizations', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-18 14:08:15', 248, '2024-09-18 14:08:15', 0, '*', 1),
(23, 110, 20, 16, 17, 2, 'dovidnyk/contracts', 'com_accounting', 'Договори', 'contracts', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-18 14:15:32', 248, '2024-09-18 14:15:32', 0, '*', 1),
(24, 113, 20, 42, 43, 2, 'dovidnyk/taxes', 'com_accounting', 'Податки', 'taxes', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-18 14:23:32', 248, '2024-09-18 14:23:32', 0, '*', 1),
(25, 112, 20, 40, 41, 2, 'dovidnyk/lots', 'com_accounting', 'Партії', 'lots', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-18 14:22:27', 248, '2024-09-18 14:22:27', 0, '*', 1),
(26, 111, 20, 18, 39, 2, 'dovidnyk/goods', 'com_accounting', 'Номенклатура', 'goods', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-18 14:21:37', 248, '2024-09-18 14:21:37', 0, '*', 1),
(27, 114, 26, 19, 20, 3, 'dovidnyk/goods/good', 'com_accounting', 'Товар', 'good', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:25:35', 248, '2024-09-24 14:25:35', 0, '*', 1),
(28, 115, 26, 21, 22, 3, 'dovidnyk/goods/service', 'com_accounting', 'Послуга', 'service', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:26:35', 248, '2024-09-24 14:26:35', 0, '*', 1),
(29, 116, 26, 23, 24, 3, 'dovidnyk/goods/tare', 'com_accounting', 'Тара', 'tare', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:27:11', 248, '2024-09-24 14:27:11', 0, '*', 1),
(30, 117, 26, 25, 26, 3, 'dovidnyk/goods/produce', 'com_accounting', 'Продукція', 'produce', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:28:40', 248, '2024-09-24 14:29:05', 0, '*', 1),
(31, 118, 26, 27, 28, 3, 'dovidnyk/goods/fuel', 'com_accounting', 'Паливо', 'fuel', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:30:16', 248, '2024-09-24 14:30:16', 0, '*', 1),
(32, 119, 26, 29, 30, 3, 'dovidnyk/goods/spare-parts', 'com_accounting', 'Запчастини', 'spare-parts', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:32:05', 248, '2024-09-24 14:32:05', 0, '*', 1),
(33, 120, 26, 31, 32, 3, 'dovidnyk/goods/stationery', 'com_accounting', 'Канцтовари', 'stationery', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:33:47', 248, '2024-09-24 14:33:47', 0, '*', 1),
(34, 121, 26, 33, 34, 3, 'dovidnyk/goods/semi-product', 'com_accounting', 'Напівфабрикат', 'semi-product', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:35:51', 248, '2024-09-24 14:35:51', 0, '*', 1),
(35, 122, 26, 35, 36, 3, 'dovidnyk/goods/low-price', 'com_accounting', 'Малоцінка', 'low-price', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-24 14:37:00', 248, '2024-09-24 14:37:00', 0, '*', 1),
(36, 123, 26, 37, 38, 3, 'dovidnyk/goods/material', 'com_accounting', 'Матеріал', 'material', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-25 13:38:50', 248, '2024-09-25 13:38:50', 0, '*', 1),
(100, 105, 1, 45, 50, 1, 'document', 'com_accounting', 'Документ', 'document', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-17 07:08:04', 248, '2024-09-17 07:08:04', 0, '*', 1),
(101, 106, 100, 46, 47, 2, 'document/receipt', 'com_accounting', 'Надходження товарів та послуг', 'receipt', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-17 08:34:37', 248, '2024-09-17 08:34:37', 0, '*', 1),
(102, 107, 100, 48, 49, 2, 'document/invoice', 'com_accounting', 'Реалізація товарів та послуг', 'invoice', '', '', 1, NULL, NULL, 1, '{\"category_layout\":\"\",\"image\":\"\",\"image_alt\":\"\"}', '', '', '{\"author\":\"\",\"robots\":\"\"}', 248, '2024-09-17 08:38:01', 248, '2024-09-17 08:38:01', 0, '*', 1);


CREATE TABLE IF NOT EXISTS `#__acc_cities` (
  `id`       INT(11)     NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__acc_clients` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `fullname` varchar(200) DEFAULT NULL,
  `identificator` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `isfolder` tinyint(1) DEFAULT NULL,
  `ismark` tinyint(1) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  `state` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_clients` VALUES
(1, NULL, NULL, 1, 'Клієнт 1', 'ТОВ \"Клієнт\"', '1133322', '', NULL, NULL, NULL, NULL, NULL, NULL, 21, 1);

CREATE TABLE IF NOT EXISTS `#__acc_contracts` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `kind_costs` varchar(50) DEFAULT NULL,
  `discount` varchar(50) DEFAULT NULL,
  `depth_credit` varchar(50) DEFAULT NULL,
  `amount_credit` varchar(50) DEFAULT NULL,
  `control_credit` varchar(50) DEFAULT NULL,
  `fix_rate_debt` varchar(50) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  `state` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `#__acc_countries` (
  `id` varchar(3) NOT NULL,
  `alpha-2` varchar(2) DEFAULT NULL,
  `alpha-3` varchar(3) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_countries` VALUES
('036', 'AU', 'AUS', 'Австралія'),
('040', 'AT', 'AUT', 'Австрія'),
('428', 'LV', 'LVA', 'Латвія'),
('804', 'UA', 'UKR', 'Україна'),
('826', 'GB', 'GBR', 'Велика Брітанія'),
('840', 'US', 'USA', 'США');

CREATE TABLE IF NOT EXISTS `#__acc_currencies` (
  `id` varchar(3) NOT NULL,
  `code` varchar(3) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `multi_name` varchar(30) DEFAULT NULL,
  `genitive_name` varchar(30) DEFAULT NULL,
  `country` varchar(3) DEFAULT NULL,
  `symbol` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_currencies` VALUES
('840', 'USD', 'долар США', 'доларів США', 'доларів США', '840', '$'),
('978', 'EUR', 'євро', 'євро', 'євро', NULL, '€'),
('980', 'UAH', 'гривня', 'гривень', 'гривень', '804', '₴');

CREATE TABLE IF NOT EXISTS `#__acc_firms` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `fullname` varchar(150) DEFAULT NULL,
  `basebankaccount` int(11) DEFAULT NULL,
  `identificator` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  `state` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_firms` VALUES
(1, NULL, '1', 'Наша фірма', 'ТОВ \"Наша фірма\"', NULL, '2233551', NULL, NULL, 22, 1);

CREATE TABLE IF NOT EXISTS `#__acc_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `fullname` varchar(150) DEFAULT NULL,
  `article` varchar(11) DEFAULT NULL,
  `baseunit` int(9) DEFAULT NULL,
  `isweight` tinyint(1) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `inprice` varchar(50) DEFAULT NULL,
  `num_gtd` varchar(50) DEFAULT NULL,
  `primaryunit` int(11) DEFAULT NULL,
  `property` int(11) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `tax_trade` int(11) DEFAULT NULL,
  `country` varchar(3) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `isfolder` tinyint(1) DEFAULT NULL,
  `ismark` tinyint(1) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL COMMENT 'kind of goods (from #__category)',
  `state` tinyint(3) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `#__acc_goods_#__categories_FK` (`catid`),
  KEY `#__acc_goods_#__acc_unitsmeasuring_FK` (`baseunit`),
  KEY `#__acc_goods_#__acc_unitsmeasuring_FK_1` (`primaryunit`),
  KEY `#__acc_goods_#__acc_taxes_FK` (`tax`),
  KEY `#__acc_goods_#__acc_taxes_FK_1` (`tax_trade`),
  KEY `#__acc_goods_#__acc_countries_FK` (`country`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_goods` VALUES
(1, NULL, 'Товар 1', 'Товар 1', '10000', 1, 0, 'тестовий товар', NULL, NULL, 1, NULL, 6, NULL, NULL, 1, NULL, NULL, 27, 1),
(2, NULL, 'Послуга 1', 'Послуга 1', '10001', 4, 0, 'тестова послуга', NULL, NULL, 1, NULL, 1, NULL, NULL, 2, NULL, NULL, 28, 1);

CREATE TABLE IF NOT EXISTS `#__acc_goods_periodic` (
  `id` int(11) NOT NULL,
  `field` varchar(50) DEFAULT NULL,
  `value` varchar(70) DEFAULT NULL COMMENT 'id or number or string',
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `#__acc_kinds` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `parent_id` int(9) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `localization` varchar(100) DEFAULT NULL,
  `isfolder` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='enumerations of:\r\n- goods\r\n- clients\r\nand more.';

INSERT INTO `#__acc_kinds` VALUES
(1, NULL, 'Види номенклатури', 'acc_kinds_of_goods', 1),
(2, 1, 'Товари', 'acc_goods', 0),
(3, 1, 'Послуги', 'acc_services', 0),
(4, 1, 'Матеріали', 'acc_materials', 0);

CREATE TABLE IF NOT EXISTS `#__acc_lots` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `isfolder` tinyint(1) DEFAULT NULL,
  `ismark` tinyint(1) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  `state` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `#__acc_receipt` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `ownfirm` int(11) DEFAULT NULL,
  `client` int(11) DEFAULT NULL,
  `contract` int(11) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `comment` varchar(150) DEFAULT NULL,
  `considerVAT` int(11) DEFAULT NULL,
  `amount_incl_VAT` int(11) DEFAULT NULL,
  `considerST` int(11) DEFAULT NULL,
  `amount_incl_ST` int(11) DEFAULT NULL,
  `pricestypes` int(11) DEFAULT NULL,
  `amountmutual` decimal(20,2) DEFAULT NULL,
  `rateVAT` int(11) DEFAULT NULL,
  `doc_number_in` varchar(50) DEFAULT NULL,
  `doc_date_in` date DEFAULT NULL,
  `paymentday` date DEFAULT NULL,
  `doc_reason` text DEFAULT NULL COMMENT 'JSON',
  `catid` int(11) DEFAULT NULL,
  `state` tinyint(3) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `isheld` tinyint(1) DEFAULT NULL,
  `ismark` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modifyed` datetime DEFAULT NULL,
  `meta_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_receipt` VALUES
(1, '2024-09-01 10:00:01', 'AB-00000000001', 1, 1, 2, '8500.00', 804, 'test', 20, 1, 1700, 0, NULL, '10200.00', 20, '1234567', '2024-08-20', NULL, NULL, 51, 1, 248, NULL, NULL, NULL, NULL, 51);

CREATE TABLE IF NOT EXISTS `#__acc_receipt_rows` (
  `parent_id` int(11) NOT NULL,
  `num_line` int(11) DEFAULT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `kindgood` int(11) DEFAULT NULL,
  `good` int(11) DEFAULT NULL,
  `quantity` decimal(25,7) DEFAULT NULL,
  `unit` int(9) DEFAULT NULL,
  `price` decimal(25,7) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `amountTAX` decimal(20,2) DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `#__acc_receipt_rows_#__acc_warehouses_FK` (`warehouse`),
  KEY `#__acc_receipt_rows_#__categories_FK` (`kindgood`),
  KEY `#__acc_receipt_rows_#__acc_goods_FK` (`good`),
  KEY `#__acc_receipt_rows_#__acc_unitsmeasuring_FK` (`unit`),
  KEY `#__acc_receipt_rows_#__acc_taxes_FK` (`tax`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_receipt_rows` VALUES
(1, 1, 1, 27, 1, '2.0000000', 1, '300.0000000', '600.00', '0.00', 1, 1),
(1, 2, 3, 28, 2, '1.0000000', 4, '1800.0000000', '1800.00', '360.00', 7, 2);

CREATE TABLE IF NOT EXISTS `#__acc_schema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `table` varchar(50) DEFAULT NULL,
  `rows_table` varchar(50) DEFAULT NULL,
  `form_name` varchar(50) DEFAULT NULL,
  `struct_table` varchar(50) DEFAULT NULL,
  `owner_table` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `ismark` int(11) DEFAULT NULL,
  `localization` varchar(50) DEFAULT NULL,
  `catid` bigint(20) NOT NULL COMMENT 'Category ID',
  `state` tinyint(3) NOT NULL DEFAULT 1 COMMENT 'Publish status',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `catid` (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_schema` VALUES
(1, 'FirmsClients', 'acc_firmsclients', '', '', 'acc_firmclient_struct_table', '', 1, 0, 'COM_ACCOUNTING_FIRMSCLIENTS', 20, 1),
(2, 'Contracts', 'acc_contracts', '', '', 'acc_contract_struct_table', 'acc_clients', 2, 0, 'COM_ACCOUNTING_CONTRACTS', 23, 1),
(3, 'Goods', 'acc_goods', '', 'good_details.xml', 'acc_goods_struct_table', 'acc_', 3, 0, 'COM_ACCOUNTING_GOODS', 26, 1),
(4, 'Analogues', 'acc_analogues', '', '', 'acc_analogues_struct_table', '', 4, 0, 'COM_ACCOUNTING_ANALOGUES', 20, 1),
(5, 'Clients', 'acc_clients', '', 'client_details.xml', 'acc_clients_struct_table', '', 5, 0, 'COM_ACCOUNTING_CLIENTS', 21, 1),
(6, 'Individuals', 'acc_individuals', '', '', 'acc_individual_struct_table', '', 6, 0, 'COM_ACCOUNTING_INDIVIDUALS', 20, 1),
(7, 'Banks', 'acc_banks', '', '', 'acc_bank_struct_table', '', 7, 0, 'COM_ACCOUNTING_BANKS', 20, 1),
(8, 'ForeignerBanks', 'acc_foreignerbanks', '', '', 'acc_foreignerbank_struct_table', '', 8, 0, 'COM_ACCOUNTING_FOREIGNERBANKS', 20, 1),
(9, 'BankAccounts', 'acc_bankaccounts', '', '', 'acc_bankaccount_struct_table', '', 9, 0, 'COM_ACCOUNTING_BANKACCOUNTS', 20, 1),
(10, 'Currency', 'acc_currency', '', '', 'acc_currency_struct_table', '', 10, 0, 'COM_ACCOUNTING_CURRENCY', 20, 1),
(11, 'KindProperties', 'acc_kindproperties', '', '', 'acc_kindproperties_struct_table', '', 11, 0, 'COM_ACCOUNTING_KINDPROPERTIES', 20, 1),
(12, 'CargoDeclaration', 'acc_ccd', '', '', 'acc_ccd_struct_table', '', 12, 0, 'COM_ACCOUNTING_CARGODECLARATION', 20, 1),
(13, 'CashFlow', 'acc_cashflow', '', '', 'acc_cashflow_struct_table', '', 13, 0, 'COM_ACCOUNTING_CASHFLOW', 20, 1),
(14, '_RegistersMovement', 'acc_registersmovements', '', '', 'acc_registersmovement_struct_table', '', 14, 0, 'COM_ACCOUNTING_REGISTERS_MOVEMENTS', 0, 1),
(15, '_UnitsMeasuring', 'acc_unitsmeasuring', '', '', 'acc_unitsmeasuring_struct_table', '', 15, 0, 'COM_ACCOUNTING_UNITS_MEASURING', 20, 1),
(16, '_ValuesProperties', 'acc_valuesproperties', '', '', 'acc_valueproperty_struct_table', '', 16, 0, 'COM_ACCOUNTING_VALUE_PROPERTY', 20, 1),
(17, '_CashBoxes', 'acc_cashboxes', '', '', 'acc_cashbox_struct_table', '', 17, 0, 'COM_ACCOUNTING_CASHBOXES', 20, 1),
(19, '_Completions', 'acc_completions', '', '', 'acc_completion_struct_table', '', 19, 0, 'COM_ACCOUNTING_COMPLECTIONS', 20, 1),
(21, 'Countries', 'acc_countries', '', '', 'acc_classificatorcountries_struct_table', '', 21, 0, 'COM_ACCOUNTING_COUNTRIES', 20, 1),
(22, '_Lots', 'acc_lots', '', '', 'acc_lot_struct_table', '', 22, 0, 'COM_ACCOUNTING_LOTS', 25, 1),
(23, '_Sites', 'acc_sites', '', '', 'acc_site_struct_table', '', 23, 0, 'COM_ACCOUNTING_SITES', 20, 1),
(24, '_OwnFirms', 'acc_firms', '', '', 'acc_ownfirm_struct_table', '', 24, 0, 'COM_ACCOUNTING_OWNFIRMS', 22, 1),
(25, '_ClientProperties', 'acc_clientproperty', '', '', 'acc_clientproperty_struct_table', '', 25, 0, 'COM_ACCOUNTING_CLIENT_PROPERTY', 20, 1),
(26, '_ProductProperties', 'acc_productproperty', '', '', 'acc_productproperty_struct_table', '', 26, 0, 'COM_ACCOUNTING_PRODUCT_PROPERTY', 20, 1),
(27, '_Discounts', 'acc_discounts', '', '', 'acc_discount_struct_table', '', 27, 0, 'COM_ACCOUNTING_DISCOUNTS', 20, 1),
(28, 'Warehouses', 'acc_warehouses', '', '', '', '', 28, 0, 'COM_ACCOUNTING_HOUSES', 20, 1),
(29, '_Taxes', 'acc_taxes', '', '', '', '', 29, 0, 'COM_ACCOUNTING_TAXES', 24, 1),
(30, '_PricesTypes', 'acc_pricestypes', '', '', 'acc_pricestypes_struct_table', '', 30, 0, 'COM_ACCOUNTING_PRICES_TYPES', 20, 1),
(31, '_AccountingAnalist', 'acc_accouninganalist', '', '', 'acc_accountinganalist_struct_table', '', 31, 0, 'Аналітика управлінського обліку (субконто)', 20, 1),
(32, '_Firms', 'acc_firms', 'acc_firms_content', '', 'acc_firm_struct_table', '', 32, 0, 'COM_ACCOUNTING_FIRMS', 20, 1),
(33, '_Prices', 'acc_prices', '', '', 'acc_price_struct_table', '', 33, 0, 'COM_ACCOUNTING_PRICES', 20, 1),
(34, '_Users', 'salto_users', '', '', 'acc_users_struct_table', '', 34, 0, 'Користувачі', 0, 1),
(51, 'Receipt', 'acc_receipt', '', 'receipt_details.xml', 'acc_receipt_struct_table', '', 1, 0, 'COM_ACCOUNTING_DOCUMENT_RECEIPT', 51, 1),
(52, 'Clients8', 'Reference19', 'Reference19_VT12191', '', '', '', 14, 0, 'Контрагенти 8-ки', 20, 1);

CREATE TABLE IF NOT EXISTS `#__acc_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `rate` decimal(6,2) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_taxes` VALUES
(1, 'Без ПДВ', '0.00', NULL, 1),
(2, '0%', '0.00', NULL, 1),
(3, '7%', '7.00', NULL, 1),
(4, '10%', '10.00', NULL, 1),
(5, '14%', '14.00', NULL, 1),
(6, '18%', '18.00', NULL, 1),
(7, '20%', '20.00', NULL, 1);

CREATE TABLE IF NOT EXISTS `#__acc_unitsmeasuring` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `single_name` varchar(100) DEFAULT NULL,
  `multi_name` varchar(100) DEFAULT NULL,
  `genitive_name` varchar(100) DEFAULT NULL,
  `code` varchar(9) NOT NULL,
  `isfolder` tinyint(1) DEFAULT 0,
  `state` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_unitsmeasuring` VALUES
(1, 'шт.', 'штука', 'штук', 'штук', '2009', 0, 1),
(2, 'т', 'тона', 'тон', 'тон', '0306', 0, 1),
(3, 'кг', 'кілограм', 'кілограм', 'кілограмів', '0301', 0, 1),
(4, 'посл.', 'послуга', 'послуг', 'послуг', '17', 0, 1);

CREATE TABLE IF NOT EXISTS `#__acc_warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `responsible` int(11) DEFAULT NULL,
  `code` varchar(11) DEFAULT NULL,
  `isfolder` tinyint(1) NOT NULL DEFAULT 0,
  `catid` int(11) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `#__acc_warehouses` VALUES
(1, 'Матеріальний склад', NULL, NULL, 'AB-00000001', 0, NULL, 1),
(2, 'ГСМ склад', NULL, NULL, 'AB-00000002', 0, NULL, 1),
(3, 'Запчастин склад', NULL, NULL, 'AB-00000003', 0, NULL, 1),
(4, 'Обладнання склад', NULL, NULL, 'AB-00000004', 0, NULL, 1);


ALTER TABLE `#__acc_goods`
  ADD CONSTRAINT `#__acc_goods_#__acc_countries_FK` FOREIGN KEY (`country`) REFERENCES `#__acc_countries` (`id`),
  ADD CONSTRAINT `#__acc_goods_#__acc_taxes_FK` FOREIGN KEY (`tax`) REFERENCES `#__acc_taxes` (`id`),
  ADD CONSTRAINT `#__acc_goods_#__acc_taxes_FK_1` FOREIGN KEY (`tax_trade`) REFERENCES `#__acc_taxes` (`id`),
  ADD CONSTRAINT `#__acc_goods_#__acc_unitsmeasuring_FK` FOREIGN KEY (`baseunit`) REFERENCES `#__acc_unitsmeasuring` (`id`),
  ADD CONSTRAINT `#__acc_goods_#__acc_unitsmeasuring_FK_1` FOREIGN KEY (`primaryunit`) REFERENCES `#__acc_unitsmeasuring` (`id`),
  ADD CONSTRAINT `#__acc_goods_#__categories_FK` FOREIGN KEY (`catid`) REFERENCES `#__categories` (`id`);

ALTER TABLE `#__acc_receipt_rows`
  ADD CONSTRAINT `#__acc_receipt_rows_#__acc_goods_FK` FOREIGN KEY (`good`) REFERENCES `#__acc_goods` (`id`),
  ADD CONSTRAINT `#__acc_receipt_rows_#__acc_receipt_FK` FOREIGN KEY (`parent_id`) REFERENCES `#__acc_receipt` (`id`),
  ADD CONSTRAINT `#__acc_receipt_rows_#__acc_taxes_FK` FOREIGN KEY (`tax`) REFERENCES `#__acc_taxes` (`id`),
  ADD CONSTRAINT `#__acc_receipt_rows_#__acc_unitsmeasuring_FK` FOREIGN KEY (`unit`) REFERENCES `#__acc_unitsmeasuring` (`id`),
  ADD CONSTRAINT `#__acc_receipt_rows_#__acc_warehouses_FK` FOREIGN KEY (`warehouse`) REFERENCES `#__acc_warehouses` (`id`),
  ADD CONSTRAINT `#__acc_receipt_rows_#__categories_FK` FOREIGN KEY (`kindgood`) REFERENCES `#__categories` (`id`);




