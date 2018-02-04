SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `admin` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `auname` varchar(20) NOT NULL,
  `apass` varchar(30) NOT NULL,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `auname` (`auname`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `admin` (`aid`, `auname`, `apass`) VALUES
(1, 'admin', 'admin');

CREATE TABLE IF NOT EXISTS `book` (
  `bid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `cover` varchar(50) DEFAULT NULL,
  `author` varchar(30) NOT NULL,
  `r_date` date DEFAULT NULL,
  `des` text NOT NULL,
  PRIMARY KEY (`bid`),
  UNIQUE KEY `name_2` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT INTO `book` (`bid`, `title`, `cover`, `author`, `r_date`, `des`) VALUES
(6, 'Harry Potter and the Philosopher''s Stone', 'cover/88d539c46c3cf4c1ac51adf80678e575.jpg', 'J. K. Rowling', '1999-03-13', '   Harry Potter thinks he is an ordinary boy. He lives with his Uncle Vernon, Aunt Petunia and cousin Dudley, who are mean to him and make him sleep in a cupboard under the stairs. (Dudley, however, has two bedrooms, one to sleep in and one for all his toys and games.) Then Harry starts receiving mysterious letters and his life is changed forever. He is whisked away by a beetle-eyed giant of a man and enrolled at Hogwarts School of Witchcraft and Wizardry. The reason: Harry Potter is a wizard! The first book in the "Harry Potter" series makes the perfect introduction to the world of Hogwarts.');

CREATE TABLE IF NOT EXISTS `friend` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `uid1` int(11) NOT NULL,
  `uid2` int(11) NOT NULL,
  `f_date` bigint(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`fid`),
  KEY `uid1` (`uid1`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

INSERT INTO `friend` (`fid`, `uid1`, `uid2`, `f_date`, `status`) VALUES
(7, 5, 6, NULL, 'accepted'),
(9, 9, 6, 1447668764, 'accepted'),
(12, 5, 9, 1447667873, 'accepted');

CREATE TABLE IF NOT EXISTS `message` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `uid1` int(11) NOT NULL,
  `uid2` int(11) NOT NULL,
  `m_date` bigint(20) DEFAULT NULL,
  `des` text NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `uid` (`uid1`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `message` (`mid`, `uid1`, `uid2`, `m_date`, `des`, `status`) VALUES
(4, 6, 5, 1447671077, 'What the hell yaar!', 'read'),
(2, 5, 6, 1447659325, 'Hello!', 'read');

CREATE TABLE IF NOT EXISTS `review` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `s_date` bigint(20) DEFAULT NULL,
  `des` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`rid`),
  KEY `bid` (`bid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

INSERT INTO `review` (`rid`, `bid`, `uid`, `s_date`, `des`, `rating`) VALUES
(10, 6, 5, 1447661313, 'Awesome!', NULL);

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) NOT NULL,
  `upass` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dp` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uname` (`uname`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

INSERT INTO `user` (`uid`, `uname`, `upass`, `name`, `dp`, `email`, `city`, `gender`, `dob`) VALUES
(5, 'tooba', 'abcd', 'Tooba', 'img/0b53d24054255ec9a34c38d1c2ed46a8.jpg', 'tooba_uroob@yahoo.com', 'Malegaon', 'Female', '1991-09-23'),
(6, 'mujtaba', 'abcd', 'Mujtaba', 'img/1a365e0302dd47c335e126f4fcb4b71a.jpg', 'mujtaba@dynamicguru.com', 'Pune', 'Male', '1991-09-23'),
(7, 'aqsa', 'abcd', 'Aqsa', 'img/0cfb34870e9aa0d62d13576d672dedf9.jpg', 'aqsa.shaikh@gmail.com', 'Malegaon', 'Female', '1993-09-02'),
(9, 'anam', 'abcd', 'Anam', 'img/907132f0ee8155d3327b30cc3d955ef5.jpg', 'anam.shafiq@gmail.com', 'Doha', 'Female', '1993-09-14');

CREATE TABLE IF NOT EXISTS `user_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `a_date` bigint(20) DEFAULT NULL,
  `category` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `bid` (`bid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

INSERT INTO `user_book` (`id`, `uid`, `bid`, `a_date`, `category`) VALUES
(11, 6, 6, 1447671493, 'reading'),
(10, 5, 6, 1448123439, 'reading');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
