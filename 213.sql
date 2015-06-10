-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2008 at 02:28 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `voices_mv_-_maindb`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcetable`
--

CREATE TABLE IF NOT EXISTS `announcetable` (
  `announceID` smallint(5) unsigned NOT NULL auto_increment,
  `announceHeading` varchar(100) collate latin1_general_ci NOT NULL,
  `announceText` text collate latin1_general_ci NOT NULL,
  `announceTime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `announceStatus` tinyint(1) unsigned NOT NULL default '1',
  `userPin` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`announceID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `announcetable`
--

INSERT INTO `announcetable` (`announceID`, `announceHeading`, `announceText`, `announceTime`, `announceStatus`, `userPin`) VALUES
(1, 'Welcome', 'Hi, This Is Just A Welcome Message. Nothing More.', '2007-12-31 17:04:22', 1, 1),
(2, 'New password activation', 'You are receiving this email because you have (or someone pretending to be you has) requested a new password be sent for your account on Warez-BB.org. If you did not request this email then please ignore it, if you keep receiving it please contact the board administrator.\r\n\r\nTo use the new password you need to activate it. To do this click the link provided below.', '2007-12-31 17:05:20', 1, 2),
(3, 'Icons of Flight Calendar', 'To celebrate Flight''s 100th year in aviation publishing, we have joined together with a number of key aviation specialists to produce an Icons of Flight Calendar. \r\n\r\nWith 13 high quality images from the world of aviation and information on the featured aircraft for that month, this calendar is a must for aviation enthusiasts alike - and at only 10/20/15 including postage and packaging the calendar represents excellent value for money.', '2007-12-31 17:07:51', 1, 1),
(4, ' Sony, Skype calling gamers', 'The consumer electronics industry has for many years now tried to shoe-horn a game (some would say game-like) experience on the mobile phone device, but this year, Sony swims upstream in the same waters. It has taken the PSP handheld game platform and turned it into a mobile phone -- albeit with limitations. But the value proposition for consumers is win-win.', '2008-01-10 08:58:43', 1, 2),
(5, ' FAA, Boeing studying safety of airplane computer systems', ' A sophisticated hacker in Seat 11A uses an on-board Internet system to infiltrate a plane''s computer, seizing control of its navigation systems, communications and flight controls.\r\n\r\nNot terribly likely, the Federal Aviation Administration says. In fact, it may be impossible.\r\n\r\nBut just to make certain, the FAA and airplane manufacturers are studying onboard systems planned for the next generation of jetliners to make certain that in-flight Internet access won''t have any unintentional or unwanted impact on a plane''s vital systems.', '2008-01-10 08:59:56', 1, 3),
(6, ' Man charged in Georgia murder may be linked to Florida murder', 'Authorities are investigating whether a man charged Tuesday in the murder of a Georgia hiker is connected to the death of another woman in Florida.', '2008-01-10 09:05:19', 1, 2),
(7, 'Critics Wallop Wikia', 'And for good reason. The new search engine doesn''t even turn up Wikipedia''s own entries, and its interactive features are wholly inactive, for now', '2008-01-10 09:08:17', 1, 3),
(8, 'Victoria Beckham: Worst dressed of year', 'Victoria Beckham is anything but posh.\r\n\r\nThe former Spice Girl became 2007''s biggest fashion victim on Tuesday when style snipe Mr. Blackwell named her the worst-dressed celebrity of the year. ', '2008-01-10 09:11:00', 1, 1),
(9, 'Clinton’s Message, and Moment, Won the Day', 'At first, the moment seemed like a disaster: The televised images of the teary-eyed exchange Hillary Rodham Clinton had with a New Hampshire voter about the rigors of the campaign caused her advisers to express fears that it would badly undercut her message of strength and experience.', '2008-01-10 09:11:19', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `articleflags`
--

CREATE TABLE IF NOT EXISTS `articleflags` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `articleID` mediumint(8) unsigned NOT NULL,
  `userID` mediumint(8) unsigned NOT NULL,
  `Reason` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `articleflags`
--

INSERT INTO `articleflags` (`key`, `articleID`, `userID`, `Reason`) VALUES
(1, 10, 2, 'No Reason');

-- --------------------------------------------------------

--
-- Table structure for table `articleratings`
--

CREATE TABLE IF NOT EXISTS `articleratings` (
  `key` int(10) unsigned NOT NULL auto_increment,
  `articleID` mediumint(8) unsigned NOT NULL,
  `userID` mediumint(8) unsigned NOT NULL,
  `articleRating` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `articleratings`
--

INSERT INTO `articleratings` (`key`, `articleID`, `userID`, `articleRating`) VALUES
(1, 1, 1, 15),
(2, 1, 2, 10),
(3, 1, 3, 5),
(4, 2, 1, 10),
(5, 2, 2, 9),
(6, 2, 3, 13),
(7, 3, 1, 4),
(8, 3, 2, 3),
(9, 3, 3, 7),
(10, 4, 1, 5),
(11, 4, 2, 1),
(12, 4, 3, 1),
(13, 5, 1, 11),
(14, 5, 2, 6),
(15, 5, 3, 14),
(16, 6, 1, 8),
(17, 6, 2, 9),
(18, 6, 3, 7),
(19, 7, 1, 5),
(20, 7, 2, 12),
(21, 7, 3, 5),
(22, 8, 1, 15),
(23, 8, 2, 2),
(24, 8, 3, 14),
(25, 10, 1, 14),
(26, 10, 2, 13),
(27, 10, 3, 15);

-- --------------------------------------------------------

--
-- Table structure for table `articleratingsystem`
--

CREATE TABLE IF NOT EXISTS `articleratingsystem` (
  `RatingId` tinyint(3) unsigned NOT NULL auto_increment,
  `RatingName` varchar(25) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`RatingId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `articleratingsystem`
--

INSERT INTO `articleratingsystem` (`RatingId`, `RatingName`) VALUES
(1, 'Oh So Low'),
(2, 'Very Low'),
(3, 'Not That Low'),
(4, 'Still Low'),
(5, 'Almost Average'),
(6, 'Average'),
(7, 'A Bit Above Average'),
(8, 'Almost Out Of Average'),
(9, 'Not Out Of Average Yet'),
(10, 'Lower Level Of High'),
(11, 'High'),
(12, 'Undoubtedly High'),
(13, 'Doin Good'),
(14, 'Now Thats High'),
(15, 'Damn! Thats High');

-- --------------------------------------------------------

--
-- Table structure for table `articletable`
--

CREATE TABLE IF NOT EXISTS `articletable` (
  `articleID` mediumint(8) unsigned NOT NULL auto_increment,
  `userID` mediumint(8) unsigned NOT NULL,
  `articleSubmitDate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `articleApproveDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `articleTitle` varchar(255) collate latin1_general_ci NOT NULL,
  `articleSummary` text collate latin1_general_ci NOT NULL,
  `articleText` longtext collate latin1_general_ci NOT NULL,
  `articleViews` int(10) unsigned NOT NULL default '0',
  `articleSubCat` mediumint(8) unsigned NOT NULL,
  `articleStatus` tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`articleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `articletable`
--

INSERT INTO `articletable` (`articleID`, `userID`, `articleSubmitDate`, `articleApproveDate`, `articleTitle`, `articleSummary`, `articleText`, `articleViews`, `articleSubCat`, `articleStatus`) VALUES
(1, 1, '2008-01-01 19:07:12', '2008-01-01 19:44:38', 'What Is Virtual Memory', 'You think you don''t have enough memory on your pc, are programs taking too long too respond. Maybe you should check your virtual memory.', 'Virtual memory serves the same purpose as Memory (RAM) but works a little different than RAM. Virtual memory basically helps out your computer''s RAM by taking on some of the data it needs to hold so it won''t become overwhelmed so to speak. RAM is actually a component which is physically installed in your computer, where Virtual Memory is actually specially allocated space on your hard disk.\r\n\r\nWindows actually tricks the microprocessor into thinking that this space on the hard disk is actually the same thing as RAM so it treats it as RAM. Of course data in Virtual Memory is retrieved much slower than data in RAM because RAM uses electrical signals to transmit information and data where the hard disk uses read/write heads to input and retrieve data onto the disk. Information kept in virtual memory is stored in a special place called the Page File. The pagefile.sys is hidden so that it can''t be accidentally deleted or corrupt, it is not recommended to manipulate your page file unless you know what you are doing.\r\n\r\nYou can actually set how much space on your hard disk you want to allocate for Page File usage by following these steps...\r\n\r\n(Windows XP)\r\n\r\n   1. Click Start\r\n\r\n   2. Click Control Panel\r\n\r\n   3. Click Performance and Maintenance\r\n\r\n   4. Click System\r\n\r\n   5. Click the Advanced Tab\r\n\r\n   6. In the Performance Section Click Settings\r\n\r\n   7. Click the Advanced Tab\r\n\r\n   8. In the Virtual Memory section you''ll notice how much space is already allocated for Page File use\r\n\r\n   9. To change it click Change\r\n\r\n  10. From here you can change the page file size to your preference, but I don''t recommend going over the recommended size.\r\n\r\nMy name is Sergio Woods and I''ve been studying computers for over 7 years now. I have a great deal of knowledge in aspects ranging from Internet Administration to software programming to hardware and component installation. In my studies I have come to realize that there are very general things even the most casual computer user should know how to do in order to keep their computer running at its peak performance.\r\n\r\nI feel the need to share my knowledge with any and everybody who has the desire I do to learn everything there is to know about the most revolutionary entity in our society. Also I''ve realized that there are a lot of people charging people an arm and a leg to give very common computer advise which is not worth that much at all. Sometimes people just need a little push in the right direction, and Computer Maintain.com is here to give you that push. Remember your comments and recommendations are greatly appreciated.', 58, 1, 1),
(2, 2, '2008-01-01 20:00:13', '2008-01-01 20:00:15', 'What Is Memory', 'Are memory and the hard drive the same thing? It is a common misconception that memory and hard disk space are thought to be one in the same, but in reality they are two totally different components with totally different characteristics and duties.', 'Memory is just another word for the technical term RAM (Random Access Memory). It is basically a holding place for data so it can be easily retrieved by the microprocessor. Unlike a Hard Disk, RAM is volatile meaning when you turn your computer off, whatever is stored in your memory (RAM) is lost. Please do not get memory confused with hard disk space, they are two totally different things. There are many different types of RAM, which usually fall into these two main categories: Static RAM and Dynamic RAM. To keep it simple the main differences between the two are speed, space, and price. Static RAM is much faster than Dynamic RAM because Static RAM doesn''t have to continually refresh as Dynamic RAM does. Static RAM is generally also capable of holding much more information than Dynamic RAM. With that being said you can see Static RAM is generally more expensive than Dynamic RAM.\r\n\r\nEvery time you open a program, your adding data to your holding place (memory). The more programs and processes you have running at the same time, the more memory you are taking up, and the slower your computer''s performance will be.\r\n\r\nSo say your computer has 512 MB''s (Megabytes) of RAM and you take a look at your processes and you are using about 400 MB''s or memory, you may want to close some programs. When you get to the point where you have used up almost all of your memory and virtual memory, your computer with give you a message stating that you cannot open anymore programs or applications until your close some of the ones you have running.\r\n\r\nYou can see how much RAM you have by following these steps...\r\n\r\n(Windows XP)\r\n\r\n1. Click Start\r\n\r\n2. Right-Click on My Computer\r\n\r\n3. Click Properties\r\n\r\nMy name is Sergio Woods and I''ve been studying computers for over 7 years now. I have a great deal of knowledge in aspects ranging from Internet Administration to software programming to hardware and component installation. In my studies I have come to realize that there are very general things even the most casual computer user should know how to do in order to keep their computer running at its peak performance.\r\n\r\nI feel the need to share my knowledge with any and everybody who has the desire I do to learn everything there is to know about the most revolutionary entity in our society. Also I''ve realized that there are a lot of people charging people an arm and a leg to give very common computer advise which is not worth that much at all. Sometimes people just need a little push in the right direction, and Computer Maintain.com is here to give you that push. Remember your comments and recommendations are greatly appreciated.', 24, 1, 1),
(3, 3, '2008-01-01 20:34:39', '2008-01-01 20:34:42', ' Providing A Secure Online Environment With SSL Server Certificates ', 'As we all know, the internet offers a wonderful opportunity for the entrepreneur to market product and services to countless potential customers all over the world, 24 hours a day, 7 days a week. There are many success stories which have contributed to the modern folklore of the self-made internet millionaire. In recent years, establishing an online store has become very easy and inexpensive.', 'As we all know, the internet offers a wonderful opportunity for the entrepreneur to market product and services to countless potential customers all over the world, 24 hours a day, 7 days a week. There are many success stories which have contributed to the modern folklore of the self-made internet millionaire.\r\n\r\nIn recent years, establishing an online store has become very easy and inexpensive. Assuming you already sourced the products, you can establish an online store in a matter of hours and at a very low cost. By far the biggest obstacles to your online success are a) the marketing of your store and b) providing a secure environment so that your customer is confident about using his (or her) credit card to purchase from your website.\r\n\r\nMuch has been written about Internet Marketing, so I will address the second obstacle and explain how to assure your customers a secure communication using industrial standard protocols such as Secure Sockets Layer (SSL) server certificates. These are designed to provide secure and safe link between the web browser and the web server\r\n\r\nYou can purchase SSL server certificates from many companies. For example ipsCA is the third party certification authority who allots SSL certificates. It will issue, revoke and renew digital certificates. You can source other SSL vendors from computersecuritycertificate.com.\r\n\r\nAs we have seen, SSL server certificates have now become a virtual requirement for online commerce. Fortunately, it is easy to purchase a certificate from reliable SSL digital certificates vendors such as ipsCA.', 31, 1, 1),
(4, 1, '2008-01-01 20:36:09', '2008-01-01 20:36:11', ' Keeping The Registry Clean With A Registry Cleaner', 'The registry is the backbone of the operating system. It is the record keeper of all that is stored and where it is stored on the system. Keeping the registry clean will keep your computer running smoothly.', 'Windows uses a system called the system registry.This is a central database that is used by all modern Windows platforms. This registry or central hierarchal database contains all the information that is required by the operating system to configure the system and make it operate efficiently. The operating system constantly refers to the registry for information. This may be several times a minute and the information sought may range from user profiles, which applications are installed on the machine, to what hardware is installed and which ports are registered and used for what service. The system registry was introduced in the late 1990''s along with Windows ninety-five and replaced the older version of recording data in INI files. The entire registry is composed of binary code and keeps on growing as the operating system adds entries to it. This slows down the system and it needs a registry cleaner to erase all the useless sentries to make the system more efficient.\r\n\r\nWhat is the Registry?\r\n\r\nAs we use the computer the operating system keeps updating the registry with the new data it has to refer to for smooth operation. Let us take for example the simple file saving information, when we save a document the system has to record where the document has been saved and when it was saved also by which user. All this information is entered in the system registry. No consider how many times you save a document on the system. In addition to this consider how many sites you access on the Internet. Each time you open a site entries are made in the system registry. This makes the registry grow and slow down. Registry cleaners are programs that scan the registry and remove all the redundant entries. Registry Cleaners such as Windows registry cleaner is programmed to identify redundant entries and remove them. This makes the system faster.\r\n\r\nSo How Does The Registry Slow The System?\r\n\r\nAs the programs refer to the registry for information such as the location of a particular file or folder it has to start rummaging through the file from the beginning until it comes to the file entry it is looking for. All the entries are entered in hierarchical order so every time the programs refer to the registry they have to start from the beginning. They will also have to go through the broken links and useless entries, which number many thousands. This is why the registry slows the system. A registry cleaner like Win XP registry Cleaner scans the registry and identifies all the broken links and redundant entries that are entries not associated with any application, and removes them. This speeds the system up greatly.\r\n\r\nAuthor is admin and technical expert associated with development of computer security and performance enhancing software like Registry Cleaner, Anti Spyware, Window Cleaner, Anti Spam Filter. Learn how clean registry increase efficiency of computer. Visit our Home page or Resource Center to read more about products and download free trial of a range of security and performance enhancing software like\r\n\r\n    * Windows Registry Cleaner\r\n    * Anti Spyware and Anti Adware\r\n    * Windows and Internet Cleaner\r\n    * Anti Spam Filter for MS Outlook\r\n    * Anti Spam Filter for Outlook Express', 58, 1, 1),
(5, 2, '2008-01-05 20:38:04', '2008-01-05 20:38:04', ' Introduction to Network', 'What is a Network? A network is a group of connected computers that allow users to share information and equipment.', 'What is a Network?\r\nA network is a group of connected computers that allow users to share information and equipment.\r\n\r\nNetwork Size\r\nA network can be any size. For Example, connecting two home computers so they can share data creates a simple network. Companies can have networks consisting of a few dozen computers or hundreds of computers. The Internet is the world''s largest network and connects millions of computers all over the world.\r\n\r\nLogging On\r\nNetwork users are usually required to identify themselves before they can gain access to the information on a network. This is known as logging on. Each user must enter a personalized user name and password to access a network. By keeping this information secret, users can prevent unauthorized people from accessing the network.\r\n\r\nSharing Information\r\nYou can use a network to share information with other people. Information can be ant form of data, such as a document created in a word processing program, a picture drawn in an imaging application or information from a database. Before networks, people often used floppy disks or any other storage device to exchange information between computers, which was a slow and unreliable process. With networks, exchanging information between computers is quick and easy.\r\n\r\nSharing Resources\r\nComputers connected to a network can share equipment and devices, called resources. The ability to share resources the cost of buying computer hardware. For example, instead of having to buy a printer for each person on a network, everyone can share one central printer.\r\n\r\nSharing Programs\r\nNetworks allow people to access programs stored on a central computer, such a s a spreadsheet or word processing program. Individuals can use their own computers to access and work with the programs. By sharing a program, a company can avoid having to install a copy of the program on each person''s computer.', 17, 1, 1),
(6, 3, '2008-01-02 20:39:02', '2008-01-02 20:39:05', ' Proxy Websites', 'I wanted to take a break form doing reviews and things like that today, this will be a semi informational post regarding proxies. I''m sure many of you have heard to word used, and maybe and came across a website of two that is a proxy. Well what exactly is a proxy?', 'I wanted to take a break form doing reviews and things like that today, this will be a semi informational post regarding proxies. I''m sure many of you have heard to word used, and maybe and came across a website of two that is a proxy. Well what exactly is a proxy?\r\n\r\nThere are two different types of proxy. One involves editing something on your local machine. The other is just visiting the proxy website and putting in the address you wish to visit.\r\n\r\nA proxy is a way for you to not only get privacy, it also is a way to view websites that are blocked on your network. Such as your school, work place, or even the library. When you use a proxy, or proxy website all of the information is transferred through that proxy instead of your local machine. This means not only a whole new level of privacy for you, but this also means any pesky limitations on your computer or network do not apply.\r\n\r\nIf you are interested in a web proxy one I like to use is Advected.com. It''s fast, free, and it also has small shortcuts to very common websites that are blocked by most network administrators. If you are interested running a proxy on your local machine you can check out Proxy4free.com. If you are unsure oh how to set the proxy on your computer read around their site, there are a few guides that you can use. But I always found it way more simple to use a web based proxy such as Advected.com', 108, 1, 1),
(7, 1, '2008-01-02 20:40:44', '2008-01-02 20:40:47', ' 3D Computer Animation - What Is 3D Computer Animation Anyway?', 'Computer 3D animation refers to the work of creating moving pictures in a digital environment that is three-dimensional due to careful sequencing of consecutive images, that are technically referred to also as "frames" so as to ensure that it is possible to simulate motion. This simulation of motion is done when each image continues in a very gradual manner to show the next image, step by step.', 'Computer 3D animation refers to the work of creating moving pictures in a digital environment that is three-dimensional due to careful sequencing of consecutive images, that are technically referred to also as "frames" so as to ensure that it is possible to simulate motion. This simulation of motion is done when each image continues in a very gradual manner to show the next image, step by step.\r\n\r\nWhat happens in animation is that motion is simulated in a way that the eyes tend to believe that actual motion has taken place while the fact is the perceived sense of motion is only because of the consecutive images that are passed through very fast.\r\n\r\nYou already may know that computer animation comprises 2D animation and computer 3d animation.\r\n\r\nThe traditional aspect of computer animation as an art form is well established in the application of 2D animation or two-dimensional animation is the more traditional face of the art form. In 2D animation, whatever drawings are done or created on paper are utilized and so are celluloid transparencies. In this form, it is also termed as cell animation and hand-drawn animation.\r\n\r\nLet''s get back to our main area of interest namely 3D animation which emerged as a new kind of art form that depends more on computers to bring forth characters or objects using a construct environment that is three dimensional in nature. So instead of any kind of hand drawings, the characters are all created within the computer not anywherelse because the character is subject to further modifications or manipulations in the online environment using highly advanced computer tools.\r\n\r\nSo if your ambition is to create your own remarkably unique 3D characters and animations, you should then procure a very good quality 3D animation software and we assume that you already have a good computer. Be aware of the fact that most studios currently make use of proprietary computer 3d animation software but for a beginner like yourself, you can check out a whole variety of software options in computer 3d animation.\r\n\r\nKeep in mind that a lot of these off-the-shelf computer animation packages are helpful but they differ in the levels of complexity and features that come along with them. So it would be advisable to learn computer 3d animation as well as the basic principles of 2D before you actually go out and get yourself any package.\r\n\r\nAnimation packages are plenty but some brands like Maya remain immortal because of its high-end 3D computer graphics as well as its highly powerful 3D modeling software package. This is so popular with the film as well as the entertainment industry so it''s a good choice. Take note that Maya has two versions, namely Maya Complete as well as Maya Unlimited. The former is less powerful and the latter is considered highly powerful and expensive. So it would be best to choose only according to your requirements as an animator.', 68, 1, 1),
(8, 2, '2008-01-02 20:41:51', '2008-01-02 20:41:53', 'Firefox vs Internet Explorer', 'Microsoft''s Internet Explorer (IE for short), and the open-source Mozilla Firefox are the two internet browsers which enjoy the largest market dominance. As of November 07, IE holds 57% of the browser market while Firefox holds around 36%. However, Firefox is growing rapidly and if it continues to do so at the same pace, Firefox will have over-taken IE within two years.\r\n', 'Microsoft''s Internet Explorer (IE for short), and the open-source Mozilla Firefox are the two internet browsers which enjoy the largest market dominance. As of November 07, IE holds 57% of the browser market while Firefox holds around 36%. However, Firefox is growing rapidly and if it continues to do so at the same pace it will have over-taken IE within two years.\r\n\r\nFirefox has often introduced new features before Internet Explorer has, and this has no doubt fueled its popularity, especially among "power-users", people who are well acquainted with computers. Tabbed browsing is probably the best example of this. Although Mozilla did not come up with the idea they implemented tabs well before Internet Explorer did and used it as a major selling-point. Another major and innovative feature introduced was applications - extensions made by the community to add to the feature-set.\r\n\r\nHowever, Microsoft, clearly aware of the threat Firefox poses on IE, included many of the features that made Firefox unique, such as tabbed browsing and RSS feeds in their latest implementation of their browser, IE7. One of the advantages that IE posses is its reduced start-up time compared to Firefox, as part of the program is loaded as Windows boots.\r\n\r\nOne of the reasons that Internet Explorer has enjoyed such a large market share for such a long time is that IE comes bundled with Microsoft Windows. Yet the market share that Firefox possesses is increasing, as more and more people become aware of IE alternatives and their benefits, no doubt fueled by the media''s critical eye on the lack of security in the latest IE browsers.\r\n\r\nIt seems that the days of Internet Explorer dominating the browser market are numbered, as more and more people make the switch more IE to Firefox. Yet as Microsoft plays catch-up, and starts to match the features present in Firefox, there is no indication of which browser will lead the future of web browsing.', 202, 1, 1),
(9, 3, '2008-01-12 21:39:19', '2008-01-12 00:00:00', 'Dell UltraSharp 3008 WFP 30" Widescreen LCD', 'Like high-end graphics cards setup in multi-GPU configurations, terabyte desktop drives, and 3GHz quad-core processors, 30-inch wide screen LCDs cater to what we like to call the "enthusiast" niche.', 'Like high-end graphics cards setup in multi-GPU configurations, terabyte desktop drives, and 3GHz quad-core processors, 30-inch wide screen LCDs cater to what we like to call the "enthusiast" niche.  And though this niche obviously drives lower volume demand versus the mainstream, you have to remember that the enthusiast end-user is a very influential segment of the market, often times assisting in the definition of what will become mainstream technology tomorrow.  Not to mention 30 inches of screen real-estate is a professional workstation designer''s nirvana, so perhaps this niche isn''t as small as it would appear on the surface. \r\n\r\nRegardless, though there are fewer in our audience who might find it practical to justify the cost of a 30" monitor, the undeniable allure of a panel of this size makes these products easily one of our most popular areas of coverage here at HotHardware.com.  There''s just something about them.  Maybe it''s a size thing.  We''ve got people buzzing over tiny, little Eee PCs and they''re also in a tizzy at the other end of the spectrum about huge LCDs.  Sexy is in the extremes we would surmise, though the ever-present "newness" factor is obviously a head-turner for these products as well.\r\n\r\nIt''s easy to see where Dell was going with the introduction of their new UltraSharp 3008 WFP 30" LCD.  Calling upon the input received from previous 30" panel incarnations and marrying these feature requests in with new technologies like a wider color gamut and the bleeding-edge of display interface technologies.  As the first DisplayPort-enabled LCD from Dell, the 3008 WFP is claiming that sexy is back.  No Justin, not you -- she''s getting a Dell?\r\n\r\nDiagonal Size 	30 inches\r\nDisplay Type 	Active Matrix - TFT LCD\r\nColor Gamut 	117%\r\nImage Scaling 	Built in image scaler/processor\r\nDepth 	9.35 inches\r\nHeight 	\r\n18.98 inches compressed\r\n22.52 inches extended\r\nWidth 	27.43 inches\r\nWeight (with stand) 	34.36 lbs.\r\nStand Adjustability 	Tilt, Swivel, Height Adjustable\r\nHorizontal Viewing Angle 	178o (typical)\r\nVertical Viewing Angle 	178o (typical)\r\nColor Support 	16.7 million colors\r\nContrast Ratio 	3000:1\r\nResponse Time 	\r\n8 ms (grey-to-grey)\r\nBrightness 	370 cd/m2\r\nResolution 	2560x1600 (max)\r\nPixel Pitch (Dot Pitch) 	0.2505 mm\r\nPorts 	\r\nAnalog, DVI-D (dual link) with HDCP x2, S-Video, Composite, Component, HDMI, DisplayPort\r\nUSB 2.0 (4)\r\n9-in-2 Media Card Reader\r\nKensington security port\r\nPower Consumption 	\r\n250W(max)\r\nLess than 2W switched off \r\n\r\nTaking what we know of Dell''s previous 30" LCD product, the 3007 WFP HC, you''ll note that there are more than a few upgrades provided with this newer 3008 version. Specifically, the 3008 WFP now has a 117% color gamut, in addition to having a 3000:1 contrast ratio versus the 1000:1 performance of its predecessor.  The panel also comes with the same pixel response time of 8ms but now has enhanced brightness capability at 370 cd/m2 (or nits if you prefer) versus 300 for the previous 3007 model.  Finally, Dell also heard our plea back when they introduced the 3007 WFP, and saw fit to adding significantly more connectivity to the panel, with not only two DVI-D inputs, but also HDMI, Composite, Component, S-Video and the new DisplayPort interface.  In short, anything you could want to hook up now or in the future, can be hooked up to this new Dell 30" panel.  Bravo, Dell, bravo.', 20, 1, 1),
(10, 1, '2008-01-14 21:14:34', '2008-01-14 13:58:21', 'JUNO - Review', 'Hollywood''s Woman of the Year is a pregnant 16-year-old, the incredibly hip, smart-mouthed and totally endearing heroine of the wise and witty Juno.', '<p>December 5, 2007 -- HOLLYWOOD''S Woman of the Year is a pregnant  16-year-old, the incredibly hip, smart-mouthed and totally endearing  heroine of the wise and witty &quot;Juno.&quot; </p>\r\n<p>Readers of my blog know I''ve been smitten with &quot;Juno&quot; - a sort of female &quot;Knocked Up&quot;  without that film''s contrivance and casual sexism - since I first laid  eyes on it back in September. </p>\r\n<p>Watching it twice more in the past week, I''m even more bowled  over by Ellen Page''s pitch-perfect performance as the eponymous  heroine, the hilarious but knowing and big-hearted script by newcomer  Diablo Cody - and the sure-footed direction by Jason Reitman. </p>\r\n<p>For maximum enjoyment, you should probably stop reading now and get in line at the nearest theater showing &quot;Juno.&quot; </p>\r\n<p>Like the 20-year-old Canadian actress who plays her - Ellen  Page, who took on a pedophile in the little-seen &quot;Hard Candy&quot; - Juno  MacGuff is a tiny force of nature, a hipster who seemingly has a ready  wisecrack for every occasion that might arise in her small Minnesota  town. </p>\r\n<p>But as anyone who has spent much time around teenage girls knows, her bravura masks deeper emotions. </p>\r\n<p>They''re emotions that Juno can''t always hide after she  accidentally becomes pregnant following an evening of experimentation  she initiates with her not-quite-boyfriend Paulie (the remarkable  Michael Cera). </p>\r\n<p>&quot;He''s good in chair,&quot; Juno quips of their non-horizontal liaison. </p>\r\n<p>She can''t joke off the unintended consequences, especially when  she decides to carry the child to term and give it away to a yuppie  couple she finds through an ad in a pennysaver. </p>\r\n<p>In synopsis, &quot;Juno&quot; sounds much like a typical teenage movie, but it totally transcends the genre in many ways. </p>\r\n<p>For starters, there''s Juno''s complex relationship with the adoptive parents, which plays out in surprising ways. </p>\r\n<p>The prospective father (a surprisingly great Jason Bateman), an  immature writer of jingles for TV commercials, enjoys discussing music  and slasher movies with Juno way too much. And his barren wife  (Jennifer Garner, never better) craves parenthood so much, she''s almost  painful to watch. </p>\r\n<p>Movies about teenagers tend to traffic in stereotypes, but  that''s definitely not the case here. Juno has an incredibly supportive,  working-class dad and stepmom - an HVAC specialist and nail technician  - played with great skill and subtlety by J.K. Simmons and Allison  Janney. </p>\r\n<p>Page is so deft at delivering self-deprecating quips (the  increasingly pregnant Juno is known around school as a &quot;cautionary  whale&quot;) that you''re almost surprised when she plumbs the character''s  emotions. She may well end up with a Best Actress nomination. </p>\r\n<p>Besides coping with her humiliation over her physical condition, Juno has got to sort out her feelings for the smitten Paulie. </p>\r\n<p>She coolly holds the kid at arm''s length while dealing with more  pressing matters - much to the distress of the inarticulate Paulie,  portrayed with a devastating lack of guile by &quot;Superbad&quot; star Cera. </p>\r\n<p>Screenwriter Cody - a former stripper turned blogger - has a  terrific ear for dialogue, and she gives many of the best lines to  Juno''s BFF Leah (Olivia Thirlby), who functions as the flick''s  one-woman Greek chorus. </p>\r\n<p>Director Reitman gets all the details right - compare Juno''s  modest digs with the prospective parents'' McMansion - and adds many  visual grace notes, including Paulie''s colorfully costumed track team,  which reappears throughout as a comic leitmotif. </p>\r\n<p>Most importantly, the filmmakers and ensemble put &quot;Juno&quot; on an  emotional roller coaster that not only had me doubled over in laughter  but, more importantly, crying at the end. </p>', 1264, 48, 1);

-- --------------------------------------------------------

--
-- Table structure for table `catmaintable`
--

CREATE TABLE IF NOT EXISTS `catmaintable` (
  `catMainID` mediumint(8) unsigned NOT NULL auto_increment,
  `catMainName` char(50) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`catMainID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `catmaintable`
--

INSERT INTO `catmaintable` (`catMainID`, `catMainName`) VALUES
(1, 'Computers And Technology'),
(2, 'News And Society'),
(3, 'Relationships'),
(4, 'Education'),
(5, 'Health And Fitness'),
(6, 'Self Improvement'),
(7, 'Recreation And Sports'),
(8, 'Food And Drink'),
(9, 'Arts And Entertainment');

-- --------------------------------------------------------

--
-- Table structure for table `catsubtable`
--

CREATE TABLE IF NOT EXISTS `catsubtable` (
  `catSubID` mediumint(8) unsigned NOT NULL auto_increment,
  `catMainID` mediumint(8) unsigned NOT NULL,
  `catSubName` varchar(50) collate latin1_general_ci NOT NULL,
  `feature` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`catSubID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `catsubtable`
--

INSERT INTO `catsubtable` (`catSubID`, `catMainID`, `catSubName`, `feature`) VALUES
(1, 1, 'Computers and Technology', 1),
(2, 1, 'Data Recovery', 1),
(3, 1, 'Games', 1),
(4, 1, 'Software', 1),
(5, 2, 'News and Society', 1),
(6, 2, 'Crime', 1),
(7, 2, 'Politics', 1),
(8, 3, 'Relationships', 1),
(9, 3, 'Affairs', 1),
(10, 3, 'Dating', 1),
(11, 3, 'Marriage', 1),
(12, 3, 'Divorce', 1),
(13, 4, 'Education', 1),
(14, 4, 'College University', 1),
(15, 4, 'Financial Aid', 1),
(16, 4, 'Online Education', 1),
(17, 5, 'Health And Fitness', 1),
(18, 5, 'Aerobics Cardio', 1),
(19, 5, 'Beauty', 1),
(20, 5, 'Build Muscles', 1),
(21, 5, 'Beauty', 1),
(22, 5, 'Dental Care', 1),
(23, 5, 'Drug Abuse', 1),
(24, 5, 'Eadting Disorders', 1),
(25, 5, 'Hair Loss', 1),
(26, 5, 'Obesity', 1),
(27, 6, 'Self Improvement', 1),
(28, 6, 'Addictions', 1),
(29, 6, 'Anger Management', 1),
(30, 6, 'Creativity', 1),
(31, 6, 'Strss Management', 1),
(32, 6, 'Time Management', 1),
(33, 7, 'Recreation And Sports', 1),
(34, 7, 'Basketball', 1),
(35, 7, 'Extreme', 1),
(36, 7, 'Fishing', 1),
(37, 7, 'Football', 1),
(38, 8, 'Food And Drink', 1),
(39, 8, 'Chocolates', 1),
(40, 8, 'Coffee', 1),
(41, 8, 'Cooking Tips', 1),
(42, 8, 'Desserts', 1),
(43, 8, 'Pasta Dishes', 1),
(44, 8, 'Soups', 1),
(45, 9, 'Arts And Entertainment', 1),
(46, 9, 'Astrology', 1),
(47, 9, 'Humor', 1),
(48, 9, 'Movies', 1),
(49, 9, 'TV Shows', 1),
(50, 9, 'Music', 1),
(51, 9, 'Books', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chatdata`
--

CREATE TABLE IF NOT EXISTS `chatdata` (
  `chatDataID` mediumint(8) unsigned NOT NULL auto_increment,
  `username` char(20) collate latin1_general_ci NOT NULL,
  `message` char(150) collate latin1_general_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`chatDataID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=63 ;

--
-- Dumping data for table `chatdata`
--

INSERT INTO `chatdata` (`chatDataID`, `username`, `message`, `date`) VALUES
(12, 'general', 'aa', '2007-12-31 01:05:13'),
(13, 'general', 'blah', '2007-12-31 13:21:32'),
(14, 'general', 'and blah', '2007-12-31 13:21:36'),
(15, 'general', 'more blah?', '2007-12-31 13:21:39'),
(16, 'general', 'still blah!', '2007-12-31 13:21:43'),
(17, 'general', 'hi', '2007-12-31 13:27:00'),
(18, 'general', 'hi', '2007-12-31 13:27:01'),
(19, 'general', 'hi', '2007-12-31 13:27:02'),
(20, 'general', 'hihihih', '2007-12-31 13:27:04'),
(21, 'general', 'hejhaljhdlas', '2007-12-31 13:27:05'),
(22, 'general', 'alkslxckahdpwh a', '2007-12-31 13:27:07'),
(23, 'general', ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;', '2007-12-31 18:09:31'),
(24, 'general', 'a', '2007-12-31 18:09:43'),
(25, 'general', 'a', '2007-12-31 18:09:44'),
(26, 'general', 'a', '2007-12-31 18:09:46'),
(27, 'lache', 'umo', '2007-12-31 18:31:22'),
(28, 'lache', 'hello', '2007-12-31 18:31:25'),
(29, 'general', 'hello', '2007-12-31 18:31:29'),
(30, 'lache', 'hello', '2007-12-31 18:31:33'),
(31, 'general', 'agsdkjasd', '2007-12-31 19:27:44'),
(32, 'anish', 'asdsad', '2007-12-31 19:27:47'),
(33, 'general', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2008-01-03 10:27:39'),
(34, 'general', 'kjjkkjkjkjkjkjkjlkjlkjgiyfkuyrfycgfkuryutdyjtgutyefdcyucdre', '2008-01-03 10:27:51'),
(35, 'general', '1111111111122222222222222223333333333333333', '2008-01-03 10:28:07'),
(36, 'general', '111111111111112222222222222222223333333333333333333333333333333333333333333444444444444444', '2008-01-03 10:28:17'),
(37, 'general', 'jj', '2008-01-03 10:28:42'),
(38, 'general', ',.', '2008-01-03 10:28:45'),
(39, 'general', 'asdsad', '2008-01-04 08:32:26'),
(40, 'general', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2008-01-06 01:46:11'),
(41, 'general', 'szaGFJAHFSDJHGFSAV HDGFAS JHGFDHJASGFDJHASGFD', '2008-01-11 22:45:11'),
(42, 'general', 'AAAAAAAAAAAAAAAAAAHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH', '2008-01-11 22:45:18'),
(43, 'general', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '2008-01-11 22:45:25'),
(44, 'general', 'ASDSADSADSADSADSADSADSADSADSADSADSADASD', '2008-01-11 22:45:32'),
(45, 'general', 'ASDASDBGSKA ASGD AJSDJFASK JDFKJAFSDKJAFSDKJASDKFASKJDF ASDASDASDA SDSKJAD KJASFD KSAFD', '2008-01-11 22:45:41'),
(46, 'general', 'ASSADSADSAD', '2008-01-11 22:46:15'),
(47, 'general', 'ASDSAD', '2008-01-11 22:46:19'),
(48, 'general', 'GGHSADJHSA', '2008-01-11 22:46:28'),
(49, 'anish', 'asdasd', '2008-01-12 08:58:33'),
(50, 'general', 'hdfkhsdkfh', '2008-01-12 13:43:53'),
(51, 'general', 'hello', '2008-01-12 13:43:56'),
(52, 'general', 'i jux wana test this one', '2008-01-12 13:44:02'),
(53, 'general', 'poh', '2008-01-12 13:44:03'),
(54, 'general', 'poa', '2008-01-12 13:44:05'),
(55, 'general', 'means how are you', '2008-01-12 13:44:08'),
(56, 'general', 'hehe', '2008-01-12 13:44:09'),
(57, 'general', 'take care', '2008-01-12 13:44:11'),
(58, 'general', 'baii', '2008-01-12 13:44:12'),
(59, 'general', '4546', '2008-01-19 13:42:57'),
(60, 'general', '2513', '2008-01-19 13:42:59'),
(61, 'anish', '565', '2008-01-19 13:43:23'),
(62, 'general', '2122', '2008-01-19 13:43:28');

-- --------------------------------------------------------

--
-- Table structure for table `commenttable`
--

CREATE TABLE IF NOT EXISTS `commenttable` (
  `commentID` mediumint(8) unsigned NOT NULL auto_increment,
  `articleID` mediumint(8) unsigned NOT NULL,
  `userID` mediumint(8) unsigned NOT NULL,
  `commentText` text collate latin1_general_ci NOT NULL,
  `replyto` mediumint(8) unsigned default NULL,
  `commentTime` timestamp NOT NULL default '0000-00-00 00:00:00',
  `commentFlag` tinyint(1) unsigned NOT NULL default '0',
  `commentStatus` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`commentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=75 ;

--
-- Dumping data for table `commenttable`
--

INSERT INTO `commenttable` (`commentID`, `articleID`, `userID`, `commentText`, `replyto`, `commentTime`, `commentFlag`, `commentStatus`) VALUES
(59, 10, 1, 'hi', NULL, '2008-02-05 00:48:27', 0, 1),
(60, 10, 1, 'check 1,2,3', NULL, '2008-02-05 00:50:38', 0, 1),
(61, 10, 1, 'aloha\r\n', NULL, '2008-02-05 00:57:36', 0, 1),
(62, 10, 1, 'a', NULL, '2008-02-05 00:57:40', 0, 1),
(63, 10, 1, 'a', NULL, '2008-02-05 00:57:50', 0, 1),
(64, 10, 1, 'kk', NULL, '2008-02-05 00:58:53', 0, 1),
(65, 10, 1, 'a', NULL, '2008-02-05 00:59:16', 0, 1),
(66, 10, 1, 'aa', NULL, '2008-02-05 01:02:25', 0, 0),
(67, 10, 1, 'aa', NULL, '2008-02-05 01:02:38', 0, 0),
(68, 10, 1, 'aloo<br /><ol><li>1</li><li>2</li><li>3</li></ol>', NULL, '2008-02-05 01:02:53', 0, 1),
(69, 10, 1, '21321321', 66, '2008-02-05 01:03:33', 0, 1),
(70, 10, 1, '456\r\n', NULL, '2008-02-05 03:59:40', 0, 1),
(71, 10, 1, '485\r\n', NULL, '2008-02-05 04:00:10', 0, 1),
(72, 9, 1, 'Well this suck!', NULL, '2008-02-11 15:26:55', 0, 1),
(73, 9, 3, 'does not', NULL, '2008-02-11 15:27:58', 0, 1),
(74, 3, 1, '<strong>This </strong><strike>is </strike><em>a </em><u>comment</u>!', NULL, '2008-02-16 09:51:38', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactlist`
--

CREATE TABLE IF NOT EXISTS `contactlist` (
  `userID` mediumint(8) unsigned NOT NULL,
  `contactID` mediumint(8) unsigned NOT NULL,
  `status` enum('Contact','Friend') collate latin1_general_ci NOT NULL default 'Contact' COMMENT 'Contact',
  KEY `userID` (`userID`,`contactID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `contactlist`
--


-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `favID` bigint(20) unsigned NOT NULL auto_increment,
  `userID` mediumint(8) unsigned NOT NULL,
  `articleID` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`favID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favID`, `userID`, `articleID`) VALUES
(1, 1, 10),
(2, 1, 9),
(3, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `grouptable`
--

CREATE TABLE IF NOT EXISTS `grouptable` (
  `groupID` tinyint(1) unsigned NOT NULL,
  `groupName` char(20) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `grouptable`
--

INSERT INTO `grouptable` (`groupID`, `groupName`) VALUES
(1, 'Maintenance Hand'),
(2, 'Mechanic Trainee'),
(3, 'Mechanic'),
(4, 'Junior Engineer'),
(5, 'Engineer'),
(6, 'Senior Engineer'),
(7, 'Manager'),
(8, 'Director'),
(9, 'CEO');

-- --------------------------------------------------------

--
-- Table structure for table `messagetable`
--

CREATE TABLE IF NOT EXISTS `messagetable` (
  `messageID` mediumint(8) unsigned NOT NULL auto_increment,
  `senderID` mediumint(8) unsigned NOT NULL,
  `recieverID` mediumint(8) unsigned NOT NULL,
  `subject` char(255) collate latin1_general_ci NOT NULL,
  `message` text collate latin1_general_ci NOT NULL,
  `sendDate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `flagged` tinyint(1) NOT NULL default '0',
  `read` tinyint(3) unsigned NOT NULL default '0',
  `senderStatus` enum('Outbox','Trash','Delete') collate latin1_general_ci NOT NULL default 'Outbox',
  `recieverStatus` enum('Inbox','Trash','Delete') collate latin1_general_ci NOT NULL default 'Inbox',
  PRIMARY KEY  (`messageID`),
  KEY `messageID` (`messageID`,`senderID`,`recieverID`,`subject`,`sendDate`,`senderStatus`,`recieverStatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `messagetable`
--

INSERT INTO `messagetable` (`messageID`, `senderID`, `recieverID`, `subject`, `message`, `sendDate`, `flagged`, `read`, `senderStatus`, `recieverStatus`) VALUES
(1, 2, 1, 'Dear Mr. Gilhooley,', '<p>Thank you very much for offering me the position of Marketing Manager with Hatfield Industries. It was a difficult decision to make, but, I have accepted a position with another company.</p>\r\n<p>I sincerely appreciate you taking the time to interview me and to share information on the opportunity and your company.</p>\r\n<p>Again, thank you for your consideration.</p>', '2008-02-19 02:20:17', 0, 0, 'Outbox', 'Inbox'),
(2, 3, 1, 'Hello', 'More Hellos', '2008-02-19 02:20:17', 0, 0, 'Outbox', 'Inbox'),
(3, 1, 3, 'testxxx', 'sometin somethin', '2008-02-19 02:20:17', 0, 0, 'Outbox', 'Inbox');

-- --------------------------------------------------------

--
-- Table structure for table `statustable`
--

CREATE TABLE IF NOT EXISTS `statustable` (
  `statusID` tinyint(1) NOT NULL,
  `statusName` char(20) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`statusID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `statustable`
--

INSERT INTO `statustable` (`statusID`, `statusName`) VALUES
(-1, 'Banned'),
(0, 'Inactive'),
(1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE IF NOT EXISTS `usertable` (
  `userID` mediumint(8) unsigned NOT NULL auto_increment,
  `userName` char(20) collate latin1_general_ci NOT NULL,
  `password` char(41) character set latin1 collate latin1_general_cs NOT NULL,
  `userHiddenQ` char(100) character set latin1 collate latin1_general_cs NOT NULL,
  `userHiddenA` char(100) character set latin1 collate latin1_general_cs NOT NULL,
  `userFirstName` varchar(40) collate latin1_general_ci NOT NULL,
  `userLastName` varchar(40) collate latin1_general_ci NOT NULL,
  `sex` enum('Unspecified','Male','Female') collate latin1_general_ci NOT NULL default 'Unspecified',
  `userDOB` datetime NOT NULL default '0000-00-00 00:00:00',
  `userAddress` char(100) collate latin1_general_ci default NULL,
  `userStreet` char(100) collate latin1_general_ci default NULL,
  `userCity` char(100) collate latin1_general_ci default NULL,
  `userCountry` char(100) collate latin1_general_ci default NULL,
  `userZIP` char(15) collate latin1_general_ci default NULL,
  `userHomePhone` char(20) collate latin1_general_ci default NULL,
  `userWorkPhone` char(20) collate latin1_general_ci default NULL,
  `userMobilePhone` char(20) collate latin1_general_ci default NULL,
  `userJoinDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `userGroup` tinyint(1) unsigned NOT NULL,
  `userStatus` tinyint(1) NOT NULL,
  `userEmail` char(100) collate latin1_general_ci NOT NULL,
  `userLastLogin` datetime NOT NULL default '0000-00-00 00:00:00',
  `userProfileStyle` enum('1','2','3','4','5') collate latin1_general_ci NOT NULL default '1',
  `userAvatar` char(255) collate latin1_general_ci NOT NULL default 'default_01.png',
  PRIMARY KEY  (`userID`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`userID`, `userName`, `password`, `userHiddenQ`, `userHiddenA`, `userFirstName`, `userLastName`, `sex`, `userDOB`, `userAddress`, `userStreet`, `userCity`, `userCountry`, `userZIP`, `userHomePhone`, `userWorkPhone`, `userMobilePhone`, `userJoinDate`, `userGroup`, `userStatus`, `userEmail`, `userLastLogin`, `userProfileStyle`, `userAvatar`) VALUES
(1, 'GeNeRaL', '9e3a8225470fb3b95925da28e9a3f0f077649838', 'hows you today mon', 'good is the dude', 'Abdul Ahad Ahmed', 'Nizar', 'Male', '1986-04-05 20:20:20', 'M.Ujaalaage', 'Miriyas Magu', 'Male', 'Maldives', '20299', '+9603312601', '+9603328246', '+9609900828', '2008-02-02 01:25:36', 9, 1, 'gen.ahad@gmail.com', '2008-02-19 00:16:42', '1', 'general.jpeg'),
(2, 'lache', '9e3a8225470fb3b95925da28e9a3f0f077649838', 'hows you mon today', 'good is the dude', 'Mohamed', 'Abdul Latheed', 'Male', '1986-07-15 20:20:20', 'asjghdkasjhdk', 'sadgaskjhgd', 'Male', 'Maldives', '16541', '9606546331', '9606654321', '9606549877', '2008-02-02 13:23:34', 1, 1, 'latche@hotmail.com', '2008-02-18 12:48:02', '5', 'lache.png'),
(3, 'anish', '9e3a8225470fb3b95925da28e9a3f0f077649838', 'how how how', 'fine fine fine', 'anish', 'saudh', 'Male', '1985-01-05 00:00:00', 'here', 'there', 'male', 'Maldives', '20220', '965461321', '465132164', '464646646', '2008-02-02 13:25:05', 1, 1, 'anish@gmail.com', '2008-02-18 12:47:28', '5', 'anish.png'),
(7, 'zaidhere', '9e3a8225470fb3b95925da28e9a3f0f077649838', 'somethinghere', 'somethinghere', '', '', 'Male', '1985-01-05 00:00:00', '', '', '', '', '', 'NULL', '', '', '2008-02-05 19:34:06', 1, 1, 'zaidhere@hotmail.com', '2008-02-05 19:34:16', '5', 'default_03.png'),
(8, 'testuser', '9e3a8225470fb3b95925da28e9a3f0f077649838', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaa', '', '', 'Male', '1985-01-05 00:00:00', '', '', '', '', '', '', '', '', '2008-02-05 19:53:26', 1, 1, 'a@b.c', '2008-02-05 19:54:06', '5', ''),
(9, 'anothertestuser', '9e3a8225470fb3b95925da28e9a3f0f077649838', 'aaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaa', '', '', 'Male', '1980-02-28 00:00:00', '', '', '', '', '', '', '', '', '2008-02-05 20:02:30', 1, 1, 'a@b.c', '2008-02-05 20:02:39', '5', 'default_01.png');
