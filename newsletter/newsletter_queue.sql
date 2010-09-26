CREATE TABLE `newsletter_queue` (
  `newsletterQID` int(11) NOT NULL auto_increment,
  `method` set('mail','smtp') collate latin1_general_ci NOT NULL default '',
  `From` varchar(255) collate latin1_general_ci NOT NULL default '',
  `FromName` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Host` varchar(255) collate latin1_general_ci NOT NULL default '',
  `SMTPAuth` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Username` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Password` varchar(255) collate latin1_general_ci NOT NULL default '',
  `recepientMail` varchar(255) collate latin1_general_ci NOT NULL default '',
  `recepientName` varchar(255) collate latin1_general_ci NOT NULL default '',
  `subject` varchar(255) collate latin1_general_ci NOT NULL default '',
  `body` text collate latin1_general_ci NOT NULL,
  `ContentType` varchar(50) collate latin1_general_ci NOT NULL default '',
  `priority` int(1) NOT NULL default '0',
  `SendDate` varchar(20) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`newsletterQID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;