# ************************************************************
# Sequel Ace SQL dump
# Version 3028
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.23)
# Database: grapestest_db
# Generation Time: 2021-06-19 13:05:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `template`;

CREATE TABLE `template` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `html` longtext,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `fields` text,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;

INSERT INTO `template` (`id`, `html`, `type`, `fields`, `created_at`)
VALUES
	(1,NULL,'header-form','[{\"field\":\"header-text\",\"value\":\"<h1>THERE IS OVER $58 BILLION IN<br>UNCLAIMED MONEY IN THE USA.<\\/h1>\\n<h3>Do you want to see how much you could claim?<\\/h3>\\n<h3>Explore free, official sources to identify unclaimed assets.<\\/h3>\"},{\"field\":\"form-text\",\"value\":\"<h2>View Available Funds Now:<\\/h2>\"},{\"field\":\"terms\",\"value\":\"<br><br>By clicking \\\"View Available Funds\\\", I declare that I am a US resident over the age of 18, I am agreeing and expressly consenting to receive emails from FindUnclaimedAssets (FUA) at the email address provided above. I am agreeing and expressly consenting to receive SMS messages from FUA (<a href=\\\"\\/page-partners.php\\\" target=\\\"_blank\\\">marketing partners<\\/a>) at the telephone number I have provided above, and to be contacted for credit and credit-related offers by a live agent, artificial or prerecorded voice and sms text dialed manually or by autodialer. I understand that consent is not required to use FUA and that providing my phone number is optional. I am also agreeing to FUA\'s <a href=\\\"\\/page-privacy.php\\\" target=\\\"_blank\\\">Privacy Policy<\\/a> and <a href=\\\"\\/page-terms.php\\\" target=\\\"_blank\\\">Terms of Service<\\/a>, which includes adding the contact information I provide to FUA\'s database and receiving emails and SMS messages from FUA under the brands our <a href=\\\"\\/page-partners.php\\\">marketing partners<\\/a>. Msg &amp; Data rates may apply. Reply HELP for help, STOP to cancel.\"}]',NULL),
	(2,NULL,'full-width-block','[{\"field\":\"content\",\"value\":\"<h2>These assets are waiting to be given back to the rightful owners.<\\/h2><p>There\'s billions of assets in unclaimed IRS checks, undelivered payroll checks, and funds left behind in savings, checking, and security deposit accounts accessible right at your fingertips.<\\/p>\"}]',NULL),
	(3,NULL,'six-column-block','[{\"field\":\"column_1\",\"value\":\"<h3>GRANTS<\\/h3>\\n                    <p>There\'s billions of assets in unclaimed IRS checks and undelivered payroll checks.<\\/p>\"},{\"field\":\"column_2\",\"value\":\"<h3>WOMEN<\\/h3>\\n                    <p>Many grants available target the needs of women and their families.<\\/p>\"},{\"field\":\"column_3\",\"value\":\"<h3>BANKS<\\/h3>\\n                    <p>Funds left behind in savings, checking, and security deposit accounts accessible right at your fingertips.<\\/p>\"},{\"field\":\"column_4\",\"value\":\"<h3>EDUCATION<\\/h3>\\n            <p>Education grants are available to help you pay for school. <\\/p>\"},{\"field\":\"column_5\",\"value\":\"<h3>DISABILITY<\\/h3>\\n            <p>Grants are also available if you are disabled and may improve your day to day lifestyle.<\\/p>\"},{\"field\":\"column_6\",\"value\":\"<h3>FINANCIALS<\\/h3>\\n            <p>These unclaimed assets can help you pay off your debt and repair your credit!<\\/p>\"},{\"field\":\"below_column_2\",\"value\":\"<h3>I DON\\u2019T KNOW WHAT UNCLAIMED ASSETS ARE?<\\/h3>\\n            <p>Unclaimed assets are multiple forms of money that you may not be aware are owed to you!<\\/p>\"},{\"field\":\"below_column_2\",\"value\":\"<h3>HOW DO I FIND MY UNCLAIMED ASSETS?<\\/h3>\\n            <p>Through our site you can find resources that will help you find money that is rightfully owned by you!<\\/p>\"}]',NULL);

/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
