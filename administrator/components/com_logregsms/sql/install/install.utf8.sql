SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `#__logregsms_smsarchives`;
CREATE TABLE IF NOT EXISTS `#__logregsms_smsarchives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_on` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `to` varchar(20) NOT NULL,
  `from` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `text` text NOT NULL,
  `result` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;
