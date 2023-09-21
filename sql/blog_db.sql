-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 08, 2023 at 04:17 PM
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
  `email` varchar(40) NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `bio` tinytext DEFAULT NULL,
  `profile_picture` varchar(30) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `social_media` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `bio`, `profile_picture`, `website`, `social_media`, `created_at`, `updated_at`) VALUES
(1, 'Cameron ', 'Williamson', 'Willcam@gmail.com', NULL, NULL, NULL, NULL, NULL, '', '2023-07-19 22:05:36', '2023-07-19 22:05:36'),
(2, 'Kalumba', 'Mweshi', 'kalukav55@gmail.com', 'Kalu', NULL, NULL, 'me.jpg', NULL, '', '2023-07-20 13:06:01', '2023-07-20 19:36:51');

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
(12, 'Fashion', 'Fashion category', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(30) UNSIGNED NOT NULL,
  `parent_id` int(30) UNSIGNED DEFAULT NULL,
  `post_id` int(30) DEFAULT NULL,
  `user_id` int(30) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
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
(262, NULL, 5, 8, 'Kalu Kav', 'kalukav55@gmail.com', 'interesting', NULL, '2023-08-07 18:29:58');

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
  `latest` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1 = new',
  `trending` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1 = trending',
  `popular` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1 = popular',
  `likes` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `shares` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_published` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `post`, `category_id`, `author_id`, `img_path`, `caption`, `status`, `latest`, `trending`, `popular`, `likes`, `shares`, `views`, `date_updated`, `date_published`) VALUES
(4, 'The New Trend That\'s Changing the World', 'In recent years, the world has witnessed a significant shift in consumer behavior, with an increasing focus on sustainability and environmental consciousness. This change in mindset is reflected in various industries, none more so than the fashion world. Today, sustainable fashion has become the new trend that\'s not only reshaping the way we dress but also making a positive impact on the planet.\r\n\r\nFast fashion, characterized by rapid production and low-cost garments, used to dominate the clothing market. However, this throwaway culture came at a high price for the environment. The excessive use of natural resources, toxic chemicals, and the massive generation of textile waste led to a significant ecological footprint.\r\n\r\nEnter sustainable fashion, a movement that seeks to address these issues by promoting environmentally friendly practices at every stage of the fashion lifecycle. From ethical sourcing of materials and eco-friendly production processes to fair labor practices, sustainable fashion aims to make a difference from the ground up.\r\n\r\nOne of the key pillars of sustainable fashion is the use of organic and renewable materials. Designers now embrace materials like organic cotton, hemp, and recycled fibers, which require fewer resources and have a lower impact on the environment. These materials not only reduce water consumption but also minimize pollution and carbon emissions.\r\n\r\nIn addition to materials, sustainable fashion champions slow and mindful production. Instead of churning out endless collections, designers focus on creating timeless, durable pieces that withstand the test of time. This shift from quantity to quality not only reduces waste but also encourages consumers to invest in pieces they truly love, promoting a more thoughtful and conscious approach to fashion.\r\n\r\nMoreover, the rise of sustainable fashion has given birth to innovative technologies. From 3D knitting to dyeing techniques that require minimal water, these advancements are revolutionizing the way clothes are made. Sustainable fashion is proving that style and innovation can coexist in harmony with environmental responsibility.\r\n\r\nCelebrities, influencers, and major fashion houses are also joining the movement, using their platforms to raise awareness about sustainable fashion and its impact on the planet. By promoting eco-friendly brands and incorporating sustainable practices into their own collections, they\'re inspiring millions to make conscious choices when it comes to fashion.\r\n\r\nSustainable fashion is not just a passing trend; it\'s a transformative movement that\'s shaping the future of the fashion industry. As more consumers demand transparency, ethical practices, and environmental responsibility from brands, the shift towards sustainability is gaining momentum.\r\n\r\nIn conclusion, sustainable fashion is more than just a style statement; it\'s a commitment to a better world. By choosing to support sustainable brands and embracing mindful consumption, we can all be part of this positive change. Together, we can redefine fashion, making it not only beautiful but also sustainable for generations to come.\r\n\r\n', 12, 2, 'fashion-1.jpg', NULL, 1, 0, 1, 1, 0, 0, 0, '2023-07-22 16:05:29', '2023-07-20 21:44:00'),
(5, 'The Rise of Remote Work: Redefining the Corporate Landscape', 'The corporate world is experiencing a transformative shift as remote work becomes the new norm. Accelerated by the global pandemic, businesses worldwide have embraced this flexible work arrangement. From improved work-life balance to cost savings for companies, remote work is revolutionizing the way we do business. As organizations adapt to this new paradigm, remote work is here to stay, shaping the future of the corporate landscape.', 2, 2, 'business-1.jpg', NULL, 1, 1, 0, 0, 0, 0, 0, '2023-07-22 16:05:29', '2023-07-20 10:07:00'),
(6, 'Embracing Diversity: The Cultural Mosaic of Modern Society', 'Cultural diversity is a defining aspect of today\'s society. As communities become more interconnected, we celebrate our differences, enriching our collective experience. The embrace of diverse cultures is not only visible in art, music, and cuisine but also in the workplace and education. By fostering inclusivity and understanding, we are building a cultural mosaic that represents the true essence of modern civilization.', 3, 2, 'post-landscape-1.jpg', NULL, 1, 0, 0, 0, 0, 0, 0, '2023-07-20 15:31:04', NULL),
(7, 'Plant-Based Revolution: The Growing Popularity of Vegan Cuisine', 'Veganism has transcended its niche status and is now a culinary sensation worldwide. With a surge in plant-based alternatives and vegan restaurants, more people are embracing a compassionate lifestyle. Beyond personal health benefits, veganism promotes sustainability and ethical food choices, leaving a positive impact on the planet. From vegan cheese to meatless burgers, this trend is reshaping the way we eat and think about food.', 5, 2, 'food-1.jpg', NULL, 1, 1, 0, 0, 0, 0, 0, '2023-07-22 16:05:29', '2023-07-20 21:50:59'),
(8, 'Esports: The Meteoric Rise of Competitive Gaming', 'Esports has evolved from a niche subculture to a global phenomenon. Competitive gaming attracts millions of enthusiasts and spectators alike, with esports tournaments rivaling traditional sports events in popularity. This digital sport has given rise to professional players, lucrative sponsorships, and dedicated fan bases. As the gaming industry continues to innovate, esports is poised to dominate the sports world, bridging the gap between virtual and physical realms.', 4, 2, 'sports-1.jpg', NULL, 1, 1, 1, 0, 0, 0, 0, '2023-07-22 16:05:30', '2023-07-19 21:50:59'),
(9, 'Youth Activism: The Voice of Change in Politics', 'The world has witnessed an unprecedented surge in youth activism, with young leaders driving change in politics. Empowered by social media and impassioned by global challenges, young activists are demanding accountability from policymakers. From climate action to social justice, their voices are shaping policies and influencing the political landscape. With their determination and idealism, the future of politics is in capable hands.', 6, 2, '', NULL, 1, 0, 1, 1, 0, 0, 0, '2023-07-22 16:05:30', '2023-07-15 21:50:59'),
(10, 'Breakthrough in Biotechnology: The Promise of Gene Editing', 'Gene editing technologies like CRISPR have unlocked incredible possibilities in biotechnology. Scientists are now on the cusp of revolutionizing healthcare, agriculture, and environmental conservation. From curing genetic diseases to enhancing crop yields, gene editing offers a myriad of applications that can transform our world for the better. As research progresses, the potential of this cutting-edge science is limitless.', 8, 2, 'science-1.jpg', NULL, 1, 1, 0, 1, 0, 0, 0, '2023-07-22 16:05:30', '2023-07-18 21:50:59'),
(11, 'Artificial Intelligence: Paving the Way for a Smarter Future', 'Artificial Intelligence (AI) is no longer confined to science fiction; it\'s now an integral part of our daily lives. From virtual assistants to predictive analytics, AI is transforming industries, making processes more efficient and accessible. As technology continues to evolve, AI\'s potential to address complex challenges and create innovative solutions is undeniable. The era of AI-driven advancements is upon us, shaping a smarter and more connected future.', 7, 2, 'tech-1.jpg', NULL, 1, 0, 1, 1, 0, 0, 0, '2023-07-22 16:05:30', '2023-07-17 21:50:59'),
(12, 'Sustainable Tourism: Exploring the World Responsibly', 'The travel industry is embracing sustainability to protect the natural wonders we love to explore. Responsible travel practices, eco-friendly accommodations, and community engagement are at the forefront of this movement. As travelers become more conscious of their impact, they seek authentic experiences that support local communities and preserve cultural heritage. Sustainable tourism is not just about visiting places; it\'s about leaving a positive legacy for future generations.', 10, 2, 'travel-1.jpg', NULL, 1, 1, 0, 1, 0, 0, 0, '2023-07-22 16:05:30', '2023-07-20 21:50:59'),
(13, 'Biophilic Design: Embracing Nature in Architecture', 'Biophilic design is redefining the way we interact with built environments. Inspired by nature, this design approach incorporates green spaces, natural light, and organic elements into buildings. As people seek harmony with the natural world, biophilic design promotes well-being, productivity, and creativity. From urban jungles to sustainable structures, this design trend blurs the boundaries between indoors and outdoors, reconnecting us with nature.', 11, 2, 'post-landscape-5.jpg', NULL, 1, 1, 0, 0, 0, 0, 0, '2023-07-22 16:05:30', '2023-07-16 21:50:59'),
(14, 'Influencer Activism: Celebrities Driving Social Change', 'Celebrities are leveraging their platforms to champion causes and ignite social change. Beyond their glamorous personas, many influencers are actively involved in philanthropy and advocacy. From environmental campaigns to human rights initiatives, celebrity activism has the power to mobilize millions and effect significant change. As these influential figures lead by example, they inspire their followers to become agents of positive transformation.\r\n\r\n', 9, 2, 'post-landscape-8.jpg', NULL, 1, 0, 1, 1, 0, 0, 0, '2023-07-22 16:05:30', '2023-07-14 21:50:59');

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
  `address` varchar(200) NOT NULL,
  `about` longtext NOT NULL,
  `blog_name` text NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `contact`, `email`, `address`, `about`, `blog_name`, `date_updated`) VALUES
(1, '+14526-5455-44', 'sampleblogsite@sample.com', '', '&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;b style=&quot;background: transparent; position: relative; font-size: 14px;&quot;&gt;&lt;span style=&quot;background: transparent; position: relative; font-size: 24px;&quot;&gt;About us&lt;/span&gt;&lt;/b&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-weight: bolder; margin: 0px; padding: 0px; text-align: justify;&quot;&gt;Lorem Ipsum&lt;/span&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; text-align: justify;&quot;&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&rsquo;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;/p&gt;', 'Sample Blog Site', '2020-09-10 11:34:40'),
(2, '+260967304171', 'kalu@gmail.com', '', '', 'My Blog', '2023-07-18 02:53:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = admin',
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 0 = incative , 1 = active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_type`, `username`, `password`, `status`, `date_updated`) VALUES
(1, 'Administrator', '', 1, 'admin', 'admin123', 1, '2020-09-08 16:42:28'),
(2, 'John Smith', '', 2, 'jsmth', 'admin123', 1, '2023-08-01 19:58:26'),
(3, 'Sample User', '', 1, 'sample', 'sampl123', 1, '2020-09-09 11:34:14'),
(8, 'Kalu kav', 'kalukav55@gmail.com', 0, 'kalu', '$2y$10$hslf3kGgpbOw0dP9IhxUleh083ls0wwBmWaAFDT6du7MsmDgAD2Tu', 1, '2023-08-02 20:54:41'),
(9, 'Kalu mwe', 'kalu@gmail.com', 1, 'kav', '$2y$10$dhJEUhpvUUDNsb3DeZLLq.F947PIgG3AojjPzGz7ZBZum0l4Kvb1i', 1, '2023-08-03 21:30:56'),
(10, 'thandiwe lungu', 'kalumwe@gmail.co', 0, 'thandi', '$2y$10$DUqav4DAY12c6r8wYLEe/OXUT2illZ8IcE6kwRlMn1zNcCP/fSEki', 1, '2023-08-02 22:41:31');

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
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

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
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `posts-cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
