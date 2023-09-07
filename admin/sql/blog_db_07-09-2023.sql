-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Sep 07, 2023 at 03:35 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(30) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `bio` tinytext DEFAULT NULL,
  `profile_picture` varchar(150) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `social_media` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `bio`, `profile_picture`, `website`, `social_media`, `created_at`, `updated_at`) VALUES
(2, 'Kalumba', 'Mweshi', 'kalukav55@gmail.com', 'Kalu', NULL, NULL, 'me.jpg', NULL, '', '2023-07-20 13:06:01', '2023-08-23 01:32:00'),
(44, 'kalu', 'kav', NULL, NULL, NULL, NULL, '1693883700_bg_profile.jpg', NULL, NULL, '2023-08-31 21:08:54', '2023-09-05 19:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(30) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `status`) VALUES
(2, 'Business', 'Business Category', 1),
(3, 'Culture', 'Culture category', 1),
(4, 'Sport', 'Sport category', 1),
(5, 'Food', 'Food category', 1),
(6, 'Politics', 'Politics category', 1),
(7, 'Technology', 'Technology category', 1),
(8, 'Science', 'Science category', 1),
(9, 'Celebrity', 'Celebrity', 1),
(10, 'Travel', 'Travel Category', 1),
(11, 'Design', 'Design category', 1),
(12, 'Fashion', 'Fashion category', 1),
(18, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(30) UNSIGNED NOT NULL,
  `parent_id` int(30) UNSIGNED DEFAULT NULL,
  `post_id` int(30) DEFAULT NULL,
  `user_id` int(30) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `content` text NOT NULL,
  `image_path` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `post_id`, `user_id`, `name`, `email`, `content`, `image_path`, `created_at`) VALUES
(54, NULL, NULL, NULL, 'Kalumba', 'kalu@mail.com', 'whats up?', 'me.jpg', '2023-07-27 23:26:49'),
(57, NULL, NULL, NULL, 'Kalu', 'kalukav55@gmail.com', 'okay', 'me-2.jpg', '2023-07-27 23:37:16'),
(58, NULL, NULL, NULL, 'Kalu kav', 'kalukav@gmail.com', 'lets go', 'me.jpg', '2023-07-28 03:09:31'),
(59, 58, NULL, NULL, 'kav', 'kav@mail.com', 'where?', NULL, '2023-07-28 20:13:52'),
(60, 58, NULL, NULL, 'kav', 'kav@mail.com', 'where?', NULL, '2023-07-28 20:13:59'),
(61, NULL, NULL, NULL, 'Bokotan Rize', 'bokoriz@mail.com', 'AI is the future', 'person-5.jpg', '2023-07-28 20:18:05'),
(132, 54, NULL, NULL, 'kav', 'kav@mail.com', 'wats up', NULL, '2023-07-28 20:23:46'),
(197, 57, NULL, NULL, 'kav', 'kav@mail.com', '?', NULL, '2023-07-28 20:34:49'),
(241, 61, NULL, NULL, 'kav', 'kav@mail.com', 'indeed it is', NULL, '2023-07-28 20:38:44'),
(258, 57, NULL, NULL, 'kav', 'kav@mail.com', 'okay?', NULL, '2023-07-28 20:41:40'),
(261, NULL, NULL, NULL, 'Kalu Kav', 'kalukav1@gmail.com', 'awesome', NULL, '2023-08-07 02:45:14'),
(277, NULL, 6, 8, NULL, NULL, 'yo', NULL, '2023-09-02 21:18:26'),
(295, NULL, 6, 12, NULL, NULL, 'whats up?', NULL, '2023-09-02 21:26:20'),
(296, NULL, 6, 8, NULL, NULL, 'hey', NULL, '2023-09-02 21:30:01');

-- --------------------------------------------------------

--
-- Table structure for table `dislikes`
--

CREATE TABLE `dislikes` (
  `id` int(30) UNSIGNED NOT NULL,
  `comment_id` int(30) UNSIGNED DEFAULT NULL,
  `user_id` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(30) UNSIGNED NOT NULL,
  `post_id` int(30) DEFAULT NULL,
  `comment_id` int(30) UNSIGNED DEFAULT NULL,
  `user_id` int(30) DEFAULT NULL,
  `liked` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `post` longtext NOT NULL,
  `category_id` int(30) UNSIGNED DEFAULT NULL,
  `author_id` int(30) UNSIGNED DEFAULT NULL,
  `img_path` text DEFAULT NULL,
  `caption` tinytext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= for review, 1= published',
  `latest` tinyint(1) UNSIGNED DEFAULT 0 COMMENT '1 = new',
  `trending` tinyint(1) UNSIGNED DEFAULT 0 COMMENT '1 = trending',
  `popular` tinyint(1) UNSIGNED DEFAULT 0 COMMENT '1 = popular',
  `likes` int(10) UNSIGNED DEFAULT 0,
  `shares` int(10) UNSIGNED DEFAULT 0,
  `views` int(10) UNSIGNED DEFAULT 0,
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_published` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `post`, `category_id`, `author_id`, `img_path`, `caption`, `status`, `latest`, `trending`, `popular`, `likes`, `shares`, `views`, `date_updated`, `date_published`) VALUES
(4, 'The New Trend That\'s Changing the World', '&lt;p&gt;In recent years, the world has witnessed a significant shift in consumer behavior, with an increasing focus on sustainability and environmental consciousness. This change in mindset is reflected in various industries, none more so than the fashion world. Today, sustainable fashion has become the new trend that&amp;rsquo;s not only reshaping the way we dress but also making a positive impact on the planet. Fast fashion, characterized by rapid production and low-cost garments, used to dominate the clothing market. However, this throwaway culture came at a high price for the environment. The excessive use of natural resources, toxic chemicals, and the massive generation of textile waste led to a significant ecological footprint. Enter sustainable fashion, a movement that seeks to address these issues by promoting environmentally friendly practices at every stage of the fashion lifecycle. From ethical sourcing of materials and eco-friendly production processes to fair labor practices, sustainable fashion aims to make a difference from the ground up. One of the key pillars of sustainable fashion is the use of organic and renewable materials. Designers now embrace materials like organic cotton, hemp, and recycled fibers, which require fewer resources and have a lower impact on the environment. These materials not only reduce water consumption but also minimize pollution and carbon emissions. In addition to materials, sustainable fashion champions slow and mindful production. Instead of churning out endless collections, designers focus on creating timeless, durable pieces that withstand the test of time. This shift from quantity to quality not only reduces waste but also encourages consumers to invest in pieces they truly love, promoting a more thoughtful and conscious approach to fashion. Moreover, the rise of sustainable fashion has given birth to innovative technologies. From 3D knitting to dyeing techniques that require minimal water, these advancements are revolutionizing the way clothes are made. Sustainable fashion is proving that style and innovation can coexist in harmony with environmental responsibility. Celebrities, influencers, and major fashion houses are also joining the movement, using their platforms to raise awareness about sustainable fashion and its impact on the planet. By promoting eco-friendly brands and incorporating sustainable practices into their own collections, they&amp;rsquo;re inspiring millions to make conscious choices when it comes to fashion. Sustainable fashion is not just a passing trend; it&amp;rsquo;s a transformative movement that&amp;rsquo;s shaping the future of the fashion industry. As more consumers demand transparency, ethical practices, and environmental responsibility from brands, the shift towards sustainability is gaining momentum. In conclusion, sustainable fashion is more than just a style statement; it&amp;rsquo;s a commitment to a better world. By choosing to support sustainable brands and embracing mindful consumption, we can all be part of this positive change. Together, we can redefine fashion, making it not only beautiful but also sustainable for generations to come.&lt;/p&gt;', 12, 2, '1693884180_fashion-1.jpg', NULL, 1, 0, 1, 1, 0, 0, 0, '2023-09-05 05:23:39', '2023-09-02 16:03:00'),
(5, 'The Rise of Remote Work: Redefining the Corporate Landscape', '&lt;p&gt;The corporate world is experiencing a transformative shift as remote work becomes the new norm. Accelerated by the global pandemic, businesses worldwide have embraced this flexible work arrangement. From improved work-life balance to cost savings for companies, remote work is revolutionizing the way we do business. As organizations adapt to this new paradigm, remote work is here to stay, shaping the future of the corporate landscape.&lt;/p&gt;', 2, 2, 'business-1.jpg', NULL, 1, 1, 0, 0, 0, 0, 0, '2023-08-23 03:27:34', '2023-08-23 03:27:00'),
(6, 'Embracing Diversity: The Cultural Mosaic of Modern Society', 'Cultural diversity is a defining aspect of today\'s society. As communities become more interconnected, we celebrate our differences, enriching our collective experience. The embrace of diverse cultures is not only visible in art, music, and cuisine but also in the workplace and education. By fostering inclusivity and understanding, we are building a cultural mosaic that represents the true essence of modern civilization.', 3, 2, 'post-landscape-1.jpg', NULL, 1, 0, 0, 0, 0, 0, 0, '2023-08-23 03:27:34', NULL),
(7, 'Plant-Based Revolution: The Growing Popularity of Vegan Cuisine', '&lt;p&gt;Veganism has transcended its niche status and is now a culinary sensation worldwide. With a surge in plant-based alternatives and vegan restaurants, more people are embracing a compassionate lifestyle. Beyond personal health benefits, veganism promotes sustainability and ethical food choices, leaving a positive impact on the planet. From vegan cheese to meatless burgers, this trend is reshaping the way we eat and think about food.&lt;/p&gt;', 5, 2, '1693960620_food-1.jpg', NULL, 1, 1, 0, 0, 0, 0, 0, '2023-09-06 02:37:12', '2023-07-20 21:50:59'),
(8, 'Esports: The Meteoric Rise of Competitive Gaming', 'Esports has evolved from a niche subculture to a global phenomenon. Competitive gaming attracts millions of enthusiasts and spectators alike, with esports tournaments rivaling traditional sports events in popularity. This digital sport has given rise to professional players, lucrative sponsorships, and dedicated fan bases. As the gaming industry continues to innovate, esports is poised to dominate the sports world, bridging the gap between virtual and physical realms.', 4, 2, 'sports-1.jpg', NULL, 1, 1, 1, 0, 0, 0, 0, '2023-08-23 03:27:34', '2023-07-19 21:50:59'),
(9, 'Youth Activism: The Voice of Change in Politics', 'The world has witnessed an unprecedented surge in youth activism, with young leaders driving change in politics. Empowered by social media and impassioned by global challenges, young activists are demanding accountability from policymakers. From climate action to social justice, their voices are shaping policies and influencing the political landscape. With their determination and idealism, the future of politics is in capable hands.', 6, 2, '', NULL, 1, 0, 1, 1, 0, 0, 0, '2023-08-23 03:27:34', '2023-07-15 21:50:59'),
(10, 'Breakthrough in Biotechnology: The Promise of Gene Editing', 'Gene editing technologies like CRISPR have unlocked incredible possibilities in biotechnology. Scientists are now on the cusp of revolutionizing healthcare, agriculture, and environmental conservation. From curing genetic diseases to enhancing crop yields, gene editing offers a myriad of applications that can transform our world for the better. As research progresses, the potential of this cutting-edge science is limitless.', 8, 2, 'science-1.jpg', NULL, 1, 1, 0, 1, 0, 0, 0, '2023-08-23 03:27:34', '2023-07-18 21:50:59'),
(11, 'Artificial Intelligence: Paving the Way for a Smarter Future', 'Artificial Intelligence (AI) is no longer confined to science fiction; it\'s now an integral part of our daily lives. From virtual assistants to predictive analytics, AI is transforming industries, making processes more efficient and accessible. As technology continues to evolve, AI\'s potential to address complex challenges and create innovative solutions is undeniable. The era of AI-driven advancements is upon us, shaping a smarter and more connected future.', 7, 2, 'tech-1.jpg', NULL, 1, 0, 1, 1, 0, 0, 0, '2023-08-23 03:27:34', '2023-07-17 21:50:59'),
(12, 'Sustainable Tourism: Exploring the World Responsibly', 'The travel industry is embracing sustainability to protect the natural wonders we love to explore. Responsible travel practices, eco-friendly accommodations, and community engagement are at the forefront of this movement. As travelers become more conscious of their impact, they seek authentic experiences that support local communities and preserve cultural heritage. Sustainable tourism is not just about visiting places; it\'s about leaving a positive legacy for future generations.', 10, 2, 'travel-1.jpg', NULL, 1, 1, 0, 1, 0, 0, 0, '2023-08-23 03:27:34', '2023-07-20 21:50:59'),
(13, 'Biophilic Design: Embracing Nature in Architecture', 'Biophilic design is redefining the way we interact with built environments. Inspired by nature, this design approach incorporates green spaces, natural light, and organic elements into buildings. As people seek harmony with the natural world, biophilic design promotes well-being, productivity, and creativity. From urban jungles to sustainable structures, this design trend blurs the boundaries between indoors and outdoors, reconnecting us with nature.', 11, 2, 'post-landscape-5.jpg', NULL, 1, 1, 0, 0, 0, 0, 0, '2023-08-23 03:27:34', '2023-07-16 21:50:59'),
(14, 'Influencer Activism: Celebrities Driving Social Change', 'Celebrities are leveraging their platforms to champion causes and ignite social change. Beyond their glamorous personas, many influencers are actively involved in philanthropy and advocacy. From environmental campaigns to human rights initiatives, celebrity activism has the power to mobilize millions and effect significant change. As these influential figures lead by example, they inspire their followers to become agents of positive transformation.\r\n\r\n', 9, 2, 'post-landscape-8.jpg', NULL, 1, 0, 1, 1, 0, 0, 0, '2023-08-23 03:27:34', '2023-07-14 21:50:59'),
(149, 'Ajax', '					                           						                           	&lt;p&gt;Jesus is Lord.&lt;/p&gt;					                           						                           	', 7, 44, '1693884240_1692136380_wp8697906-cool-pc-wallpapers.jpg', NULL, 0, 0, 0, 0, 0, 0, 0, '2023-09-05 20:50:49', '2023-09-03 15:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `post_author`
--

CREATE TABLE `post_author` (
  `post_id` int(30) NOT NULL,
  `author_id` int(30) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_author`
--

INSERT INTO `post_author` (`post_id`, `author_id`) VALUES
(6, 2),
(7, 2),
(8, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(149, 44);

-- --------------------------------------------------------

--
-- Table structure for table `post_img`
--

CREATE TABLE `post_img` (
  `id` int(30) NOT NULL,
  `post_id` int(30) NOT NULL,
  `fname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(30) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `about` longtext DEFAULT NULL,
  `site_name` text DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `contact`, `email`, `address`, `about`, `site_name`, `date_updated`) VALUES
(2, '+260 967 304 171', 'kaluKav55@gmail.com', 'Lusaka, Zambia', '&lt;p&gt;Jesus is Lord. My saviour.&lt;/p&gt;', 'Kalu&lt;strong class=&quot;text-orangeRed&quot;&gt;Blog&lt;/strong&gt;', '2023-09-03 19:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = admin',
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 0 = incative , 1 = active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_type`, `username`, `password`, `profile_picture`, `status`, `date_updated`) VALUES
(8, 'Kalu', 'Kav', 'kalukav55@gmail.com', 1, 'kalu', '$2y$10$hslf3kGgpbOw0dP9IhxUleh083ls0wwBmWaAFDT6du7MsmDgAD2Tu', '1693938480_me.jpg', 1, '2023-09-05 20:28:37'),
(9, 'Kalu', 'Mwe', 'kalu@gmail.com', 1, 'Kalumwe', '$2y$10$AWAP8W03ky6Gnb6WXyUi0u895Zc7B6IT6fjZw/6mZSghoexO98PKi', '1693011240_me.jpg', 1, '2023-08-29 04:24:07'),
(10, 'thandiwe ', 'lungu', 'kalumwe@gmail.co', 0, 'thandi', '$2y$10$DUqav4DAY12c6r8wYLEe/OXUT2illZ8IcE6kwRlMn1zNcCP/fSEki', NULL, 1, '2023-08-25 19:59:00'),
(12, 'Kalu', 'Kavyo', 'kalukav@gmail.com', 0, 'kalukav', '$2y$10$xJZwYd.4/0jmf/MrDF/EyeYZv3UT/NeE60rNKueUki4Xjqrv6IYLm', NULL, 1, '2023-08-30 02:29:18'),
(13, 'Kalumba', 'Mweshi', 'kalumweshi@gmail.com', 0, 'kalumweshi', '$2y$10$huh/FAJ0XX56pikWletjP.yhrqFCvqJfY9SaIAb75E0W2WOV.iLbW', NULL, 1, '2023-08-30 02:35:50'),
(14, 'sub', 'zero', 'subzero@gmail.com', 0, 'subzero', '$2y$10$rmpzUwhfK5u7yFJ2cJzEgewcSBugKJjhX.gAKh10cNU.qmfl3j3Em', NULL, 1, '2023-08-30 03:47:47'),
(15, 'john', 'cena', 'johnc@mail.com', 0, 'john', '$2y$10$rqEvOK8MzgWLHB1ktR7FfuGI0jEoTgBhpAnIUeEr65LqEz0nNL46W', NULL, 1, '2023-08-30 03:50:24'),
(16, 'leo', 'messi', 'leom@mail.com', 0, 'leo', '$2y$10$pN5phwgd8GnmRbgEwKwaZ.6aCfw4If8dI2tEarbWxmQGVZ0pXz0/C', NULL, 1, '2023-08-30 03:54:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`user_id`),
  ADD KEY `comment_post` (`post_id`);

--
-- Indexes for table `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dislike-comm` (`comment_id`),
  ADD KEY `dislike-users` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes-comm` (`comment_id`),
  ADD KEY `likes-users` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_author` (`author_id`),
  ADD KEY `posts-cat` (`category_id`);

--
-- Indexes for table `post_author`
--
ALTER TABLE `post_author`
  ADD PRIMARY KEY (`post_id`,`author_id`),
  ADD KEY `authorId` (`author_id`);

--
-- Indexes for table `post_img`
--
ALTER TABLE `post_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `post_img`
--
ALTER TABLE `post_img`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `dislike-comm` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dislike-users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes-comm` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes-users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts-cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `post_author`
--
ALTER TABLE `post_author`
  ADD CONSTRAINT `authorId` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `postId` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
