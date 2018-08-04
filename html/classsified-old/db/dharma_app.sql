-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2018 at 05:43 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dharma_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `class`, `status`, `created`, `modified`) VALUES
(2, 'Places', 'places-to-shop', 'places-shop', 1, 2147483647, '2017-06-13 13:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `global_parameters`
--

CREATE TABLE `global_parameters` (
  `id` int(11) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `global_parameters`
--

INSERT INTO `global_parameters` (`id`, `key`, `value`) VALUES
(1, 'phone', '123-456-789'),
(2, 'email', 'info@kseducation.in'),
(3, 'address', '203, Envato Labs, Behind Alis Steet, Melbourne, India.'),
(4, 'KS EDUCATION', '#'),
(5, 'KS EDUCATION', 'kseducation'),
(6, 'KS EDUCATION', '#'),
(7, 'KS EDUCATION', '#'),
(8, 'KS EDUCATION', '#'),
(9, 'KS EDUCATION', '#'),
(10, 'sitename', 'KS EDUCATION a');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `addedBy` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `categoriesId` int(11) DEFAULT NULL,
  `meta_keyword` text,
  `meta_description` text,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `date` datetime NOT NULL,
  `created` datetime NOT NULL,
  `status` smallint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `addedBy`, `title`, `categoriesId`, `meta_keyword`, `meta_description`, `description`, `image`, `date`, `created`, `status`) VALUES
(1, 'OyeWebs', 'POST TITLE HERE 1', 2, 'POST TITLE HERE1', 'POST TITLE HERE1', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n\r\n<blockquote>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>\r\n\r\n<p>Someone famous in&nbsp;<cite>Source Title</cite></p>\r\n</blockquote>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna et sed aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', '14991912231.jpg', '1969-12-31 19:00:00', '2017-06-13 14:12:27', 1),
(2, 'OyeWebs', 'POST TITLE HERE 2', 2, 'POST TITLE HERE 2', 'POST TITLE HERE 2', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n\r\n<blockquote>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>\r\n\r\n<p>Someone famous in&nbsp;<cite>Source Title</cite></p>\r\n</blockquote>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna et sed aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', '14991913273.jpg', '1969-12-31 19:00:00', '2017-06-13 14:12:27', 1),
(3, 'OyeWebs', 'POST TITLE HERE4', 2, 'POST TITLE HERE4', 'POST TITLE HERE4', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n\r\n<blockquote>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>\r\n\r\n<p>Someone famous in&nbsp;<cite>Source Title</cite></p>\r\n</blockquote>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna et sed aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', '14991913467.jpg', '1969-12-31 19:00:00', '2017-06-13 14:12:27', 1),
(4, 'OyeWebs', 'POST TITLE HERE', 2, 'POST TITLE HERE', 'POST TITLE HERE', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n\r\n<blockquote>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>\r\n\r\n<p>Someone famous in&nbsp;<cite>Source Title</cite></p>\r\n</blockquote>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna et sed aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>\r\n', '14991913955.jpg', '1969-12-31 19:00:00', '2017-06-13 14:12:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `notificationType` varchar(100) NOT NULL COMMENT 'Message, GroupChat, Poke, MysteryProfile, MysteryProfileExpire',
  `messageId` int(11) NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  `viewStatus` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `senderId`, `receiverId`, `notificationType`, `messageId`, `message`, `created`, `viewStatus`) VALUES
(1, 3, 6, 'GroupChat', 1, '', '2016-04-25 06:55:59', 0),
(2, 6, 3, 'GroupChat', 2, '', '2016-04-25 06:57:05', 0),
(3, 1, 3, 'MysteryProfile', 0, '', '2016-04-23 09:54:05', 0),
(4, 1, 3, 'MysteryProfileExpire', 0, '', '2016-04-24 23:59:59', 1),
(5, 1, 3, 'MysteryProfile', 0, '', '2016-04-25 10:25:14', 0),
(6, 1, 3, 'MysteryProfileExpire', 0, '', '2016-04-26 23:59:59', 0),
(7, 3, 10, 'Poke', 10, '', '2016-04-25 11:17:57', 0),
(8, 3, 9, 'Poke', 9, '', '2016-04-25 11:18:14', 0),
(9, 3, 9, 'Poke', 9, '', '2016-04-25 11:18:39', 0),
(10, 3, 3, 'Poke', 3, '', '2016-04-26 10:15:13', 0),
(11, 1, 9, 'MysteryProfile', 0, '', '2016-05-02 06:33:08', 0),
(12, 1, 9, 'MysteryProfileExpire', 0, '', '2016-05-03 23:59:59', 1),
(13, 6, 2, 'Poke', 2, '', '2016-05-03 09:41:47', 0),
(14, 1, 16, 'MysteryProfile', 0, '', '2016-05-03 12:44:53', 0),
(15, 1, 16, 'MysteryProfileExpire', 0, '', '2016-05-04 23:59:59', 0),
(16, 3, 3, 'Poke', 3, '', '2016-05-03 13:10:21', 0),
(17, 1, 9, 'MysteryProfile', 0, '', '2016-05-09 07:51:19', 0),
(18, 1, 9, 'MysteryProfileExpire', 0, '', '2016-05-10 23:59:59', 1),
(19, 1, 9, 'MysteryProfile', 0, '', '2016-05-09 09:24:51', 0),
(20, 1, 9, 'MysteryProfileExpire', 0, '', '2016-05-10 23:59:59', 1),
(21, 1, 9, 'MysteryProfile', 0, '', '2016-05-09 09:40:52', 0),
(22, 1, 9, 'MysteryProfileExpire', 0, '', '2016-05-10 23:59:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created` varchar(255) DEFAULT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL,
  `slug` text NOT NULL,
  `status` smallint(2) NOT NULL,
  `modified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_title`, `content`, `created`, `meta_keyword`, `meta_description`, `slug`, `status`, `modified`) VALUES
(21, 'About KS Education', '<div class="col-md-6">\r\n<h6>All About KS Education</h6>\r\n\r\n<h2>All About KS Education</h2>\r\n\r\n<p>About KS Education :KS Education is India\'s leading web and mobile app platform providing complete solution for online preparation for different competitive exams. We partner with best of the coaching institutes, independent tutors and publishers to provide authentic and latest study material for various exam preparation.</p>\r\n<a class="btn btn-theme-colored btn-flat btn-lg mt-10 mb-sm-30" href="#">Know More ?</a></div>\r\n', '1497897546', 'About KS Education', 'About KS Education', 'aboutus', 1, 1497899245),
(22, 'Privacy Policy', '<div class="col-md-12">\r\n<h3>Privacy Policy</h3>\r\n\r\n<div style="font-size:1.2em;line-height:2">\r\n<p>This Privacy Policy governs the manner in which Next Door Learning Solutions Pvt Ltd collects, uses, maintains and discloses information collected from users (each, a "User") of the <a href="http://www.kseducation.in">www.kseducation.in</a> website ("Site"). This privacy policy applies to the Site and all products and services offered by Next Door Learning Solutions Pvt Ltd.</p>\r\n<strong>Personal identification information</strong><br />\r\nWe may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, place an order, and in connection with other activities, services, features or resources we make available on our Site. Users may be asked for, as appropriate, name, email address, mailing address, phone number, credit card information. Users may, however, visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site related activities.<br />\r\n<br />\r\n<strong>Non-personal identification information</strong><br />\r\nWe may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.<br />\r\n<br />\r\n<strong>Web browser cookies</strong><br />\r\n<br />\r\nOur Site may use "cookies" to enhance User experience. User\'s web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.<br />\r\n<br />\r\n<strong>How we use collected information</strong><br />\r\nNext Door Learning Solutions Pvt Ltd may collect and use Users personal information for the following purposes:\r\n<ul>\r\n	<li><em>- To improve customer service</em><br />\r\n	Information you provide helps us respond to your customer service requests and support needs more efficiently.</li>\r\n	<li><em>- To personalize user experience</em><br />\r\n	We may use information in the aggregate to understand how our Users as a group use the services and resources provided on our Site.</li>\r\n	<li><em>- To improve our Site</em><br />\r\n	We may use feedback you provide to improve our products and services.</li>\r\n	<li><em>- To process payments</em><br />\r\n	We may use the information Users provide about themselves when placing an order only to provide service to that order. We do not share this information with outside parties except to the extent necessary to provide the service.</li>\r\n	<li><em>- To send periodic emails</em><br />\r\n	We may use the email address to send User information and updates pertaining to their order. It may also be used to respond to their inquiries, questions, and/or other requests. If User decides to opt-in to our mailing list, they will receive emails that may include company news, updates, related product or service information, etc. If at any time the User would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email.</li>\r\n</ul>\r\n<strong>How we protect your information</strong><br />\r\n<br />\r\nWe adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Site.<br />\r\n<br />\r\n<strong>Sharing your personal information</strong><br />\r\n<br />\r\nWe do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.We may use third party service providers to help us operate our business and the Site or administer activities on our behalf, such as sending out newsletters or surveys. We may share your information with these third parties for those limited purposes provided that you have given us your permission.<br />\r\n<br />\r\n<strong>Third party websites</strong><br />\r\nUsers may find advertising or other content on our Site that link to the sites and services of our partners, suppliers, advertisers, sponsors, licensors and other third parties. We do not control the content or links that appear on these sites and are not responsible for the practices employed by websites linked to or from our Site. In addition, these sites or services, including their content and links, may be constantly changing. These sites and services may have their own privacy policies and customer service policies. Browsing and interaction on any other website, including websites which have a link to our Site, is subject to that website\'s own terms and policies.<br />\r\n<br />\r\n<strong>Advertising</strong><br />\r\nAds appearing on our site may be delivered to Users by advertising partners, who may set cookies. These cookies allow the ad server to recognize your computer each time they send you an online advertisement to compile non personal identification information about you or others who use your computer. This information allows ad networks to, among other things, deliver targeted advertisements that they believe will be of most interest to you. This privacy policy does not cover the use of cookies by any advertisers.<br />\r\n<br />\r\n<strong>Google Adsense</strong><br />\r\n<br />\r\nSome of the ads may be served by Google. Google\'s use of the DART cookie enables it to serve ads to Users based on their visit to our Site and other sites on the Internet. DART uses "non personally identifiable information" and does NOT track personal information about you, such as your name, email address, physical address, etc. You may opt out of the use of the DART cookie by visiting the Google ad and content network privacy policy at <a href="http://www.google.com/privacy_ads.html">http://www.google.com/privacy_ads.html</a><br />\r\n<br />\r\n<strong>Changes to this privacy policy</strong><br />\r\n<br />\r\nNext Door Learning Solutions Pvt Ltd has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.<br />\r\n<br />\r\n<strong>Your acceptance of these terms</strong><br />\r\n<br />\r\nBy using this Site, you signify your acceptance of this policy. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes.<br />\r\n<br />\r\n<strong>Contacting us</strong><br />\r\n<br />\r\nIf you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at:<br />\r\n<a href="http://www.kseducation.in">Next Door Learning Solutions Pvt Ltd</a><br />\r\n<a href="http://www.kseducation.in">www.kseducation.in</a><br />\r\nNext Door Learning Solutions Pvt Ltd 645,1st Floor, Near Allahabad Bank Jhalawar Road Kota-324007 Rajasthan<br />\r\ninfo@kseducation.in<br />\r\n<br />\r\nThis document was last updated on February 11, 2014<br />\r\n&nbsp;</div>\r\n<!-- Contact Form --><!-- Contact Form Validation--></div>\r\n', '1497897719', 'Privacy Policy', 'Privacy Policy', 'privacy_and_policy', 1, 1497899273),
(23, 'Contact Us', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error optio in quia ipsum quae neque alias eligendi, nulla nisi. Veniam ut quis similique culpa natus dolor aliquam officiis ratione libero. Expedita asperiores aliquam provident amet dolores.</p>\r\n', '1497980167', 'Contact Us', 'Contact Us', 'contactus', 1, 1497980167),
(24, 'Help', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '1497988534', 'Help', 'Help', 'help', 1, 1497988534),
(25, 'Terms', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '1497988579', 'Terms', 'Terms', 'terms', 1, 1497988579),
(26, 'Terms Of Sale', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '1497988630', 'Terms Of Sale', 'Terms Of Sale', 'termssale', 1, 1497988630),
(27, 'Faqs', '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '1497988665', 'Faqs', 'Faqs', 'faq', 1, 1499223645);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `social_id` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password2` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zipCode` varchar(20) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `login_status` int(2) DEFAULT '0',
  `lastLogin` int(11) DEFAULT NULL,
  `logintime` varchar(255) DEFAULT NULL,
  `logouttime` varchar(255) DEFAULT NULL,
  `status` smallint(2) DEFAULT NULL,
  `loginType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `social_id`, `username`, `password`, `password2`, `email`, `fullName`, `lastname`, `gender`, `dob`, `address`, `city`, `state`, `country`, `zipCode`, `mobile`, `role`, `created`, `modified`, `login_status`, `lastLogin`, `logintime`, `logouttime`, `status`, `loginType`) VALUES
(1, '0', 'admin', '$2y$10$fFLfvHH1.fok2gbTnfDEOuJcJVHgwpXXaWY8lXPQFokkqPeqv7gc6', 'oyewebs', 'gautam@gmail.com', 'KS EDUCATION', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Admin', NULL, NULL, 0, 2018, NULL, NULL, NULL, NULL),
(6, '0', NULL, '$2y$10$hqkuZQBGY5k/5IlbUmUuduvy3mZNhJ9sQuWZIWmZoyUWyLyIvCgaK', '123456', 'oyewebs@gmail.com', 'OyeWebs', 'Developer', NULL, '2014-12-31', 'houston n', '1', '', NULL, '77005', '3256987854', 'U', '2017-05-05 03:57:59', '2017-05-05 03:57:59', 1, NULL, '1503084243', '', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_parameters`
--
ALTER TABLE `global_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `global_parameters`
--
ALTER TABLE `global_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
