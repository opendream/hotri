-- --------------------------------------------------------

--
-- Table structure for table `cover_options`
--

CREATE TABLE IF NOT EXISTS `cover_options` (
`aws_key` VARCHAR( 50 ) NULL DEFAULT NULL ,
`aws_secret_key` VARCHAR( 50 ) NULL DEFAULT NULL ,
`aws_account_id` VARCHAR( 50 ) NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cover_options`
--

INSERT INTO `cover_options` (`aws_key`, `aws_secret_key`, `aws_account_id`) VALUES 
('', '', '');

