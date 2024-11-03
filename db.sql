-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 01:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `genre`, `description`, `release_year`, `poster_url`) VALUES
(1, 'Toy Story', 'Animation', 'A story about the secret life of toys.', 1995, 'https://i5.walmartimages.com/asr/eb75cea5-0f86-4f73-baa7-7fb3366f893c_1.200c494617bf1aee14639f2e2573db5f.jpeg?odnWidth=400&odnHeight=400&odnBg=ffffff'),
(2, 'Finding Nemo', 'Animation', 'A clown fish searches for his son.', 2003, 'https://image.tmdb.org/t/p/original/eHuGQ10FUzK1mdOY69wF5pGgEf5.jpg'),
(3, 'Frozen', 'Animation', 'Two sisters fight to end the eternal winter.', 2013, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQUVomXpt2opvChUg1Z5BGT_vjViBuNw8bfZw&s'),
(4, 'The Lion King', 'Animation', 'A lion cub must reclaim his kingdom.', 1994, 'https://rukminim2.flixcart.com/image/850/1000/kyvvtzk0/poster/j/v/t/medium-the-lion-king-limited-matte-finish-poster-urbanprint5711-original-imagbygdzhgshzmz.jpeg?q=90&crop=false'),
(5, 'Shrek', 'Animation', 'An ogre and a donkey set out to rescue a princess.', 2001, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSs2N_N9qZ_dDyGi20wDO8GzHTE31bPmE_U6Q&s'),
(6, 'Zootopia', 'Animation', 'A bunny cop and a cynical con artist fox must work together.', 2016, 'https://lumiere-a.akamaihd.net/v1/images/movie_poster_zootopia_866a1bf2.jpeg'),
(7, 'Inside Out', 'Animation', 'An adventurous girl named Riley is guided by her emotions.', 2015, 'https://lumiere-a.akamaihd.net/v1/images/p_insideout_19751_af12286c.jpeg'),
(8, 'Up', 'Animation', 'An old man fulfills his dream by tying thousands of balloons to his house.', 2009, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9QeTwzz7JEDdkymH5yKFbH996jiKOXYOC8Q&s'),
(9, 'WALL-E', 'Animation', 'A small waste-collecting robot embarks on a space journey.', 2008, 'https://image.tmdb.org/t/p/original/hbhFnRzzg6ZDmm8YAmxBnQpQIPh.jpg'),
(10, 'Coco', 'Animation', 'A boy embarks on a journey to the Land of the Dead to discover his family\'s history.', 2017, 'https://rukminim2.flixcart.com/image/850/1000/kvzkosw0/poster/x/w/s/medium-coco-animated-movies-disney-movies-matte-finish-poster-original-imag8rk4ath3becb.jpeg?q=90&crop=false'),
(11, 'The Hangover', 'Comedy', 'Three buddies wake up from a bachelor party in Las Vegas with no memory of the previous night and the bachelor missing.', 2009, 'https://m.media-amazon.com/images/I/810-lQCEXRL._AC_UF894,1000_QL80_.jpg'),
(12, 'Superbad', 'Comedy', 'Two high school friends try to make the most of their last days before graduation.', 2007, 'https://m.media-amazon.com/images/I/71eXNTrJgjL._AC_UF894,1000_QL80_.jpg'),
(13, 'Step Brothers', 'Comedy', 'Two middle-aged, lazy men become stepbrothers and are forced to live together.', 2008, 'https://m.media-amazon.com/images/I/71+R6uqPFhL._AC_UF894,1000_QL80_.jpg'),
(14, 'Bridesmaids', 'Comedy', 'Competition between the maid of honor and a bridesmaid over who is the brids best friend.', 2011, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlyqBQjbErzEBVaPCnmnSI5y1ywIG7eE04MA&s'),
(15, 'Mean Girls', 'Comedy', 'Cady Heron, a teenager, moves to a new town and is introduced to the ins and outs of high school cliques.', 2004, 'https://fiu-original.b-cdn.net/fontsinuse.com/use-images/157/157966/157966.jpeg?filename=MV5BMjE1MDQ4MjI1OV5BMl5BanBnXkFtZTcwNzcwODAzMw@@._V1_FMjpg_UX1000_.jpg'),
(16, 'Anchorman', 'Comedy', 'A top-rated anchorman in San Diego faces a challenge when a new female reporter arrives.', 2004, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRSxNqZv81fPxgx7u-SvwMy7W-yXWzIoKCVxg&s'),
(17, 'The 40-Year-Old Virgin', 'Comedy', 'A middle-aged man who has never had sex is encouraged by his friends to find a girlfriend.', 2005, 'https://image.tmdb.org/t/p/original/mVeoqL37gzhMXQVpONi9DGOQ3tZ.jpg'),
(18, 'Horrible Bosses', 'Comedy', 'Three friends conspire to murder their awful bosses.', 2011, 'https://image.tmdb.org/t/p/original/4OTkcs1UxN60fJigyecYunEtzLY.jpg'),
(19, 'Crazy, Stupid, Love.', 'Comedy', 'A man learns to navigate the dating world after his marriage ends.', 2011, 'https://image.tmdb.org/t/p/original/p4RafgAPk558muOjnBMHhMArjS2.jpg'),
(20, '21 Jump Street', 'Comedy', 'Two cops go undercover at a high school to bring down a synthetic drug ring.', 2012, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGKr4fvRioATjh1s-eiEQosfSRrN3DGlvbzg&s');

-- --------------------------------------------------------

--
-- Table structure for table `movie_ratings`
--

CREATE TABLE `movie_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_ratings`
--

INSERT INTO `movie_ratings` (`id`, `user_id`, `movie_id`, `rating`, `rated_at`) VALUES
(13, 3, 11, 2, '2024-11-02 15:08:09'),
(14, 3, 2, 2, '2024-11-02 15:09:59'),
(15, 2, 1, 4, '2024-11-02 15:19:42'),
(16, 2, 2, 4, '2024-11-02 15:19:44'),
(17, 2, 3, 5, '2024-11-02 15:19:47'),
(18, 2, 5, 4, '2024-11-02 15:19:49'),
(19, 2, 4, 3, '2024-11-02 15:19:57'),
(20, 2, 6, 4, '2024-11-02 15:20:00'),
(21, 1, 12, 1, '2024-11-02 15:20:24'),
(22, 1, 13, 3, '2024-11-02 15:20:27'),
(23, 1, 11, 3, '2024-11-02 15:20:30'),
(24, 1, 14, 3, '2024-11-02 15:20:35'),
(25, 1, 15, 1, '2024-11-02 15:27:35'),
(26, 1, 1, 2, '2024-11-02 15:27:52'),
(27, 1, 18, 4, '2024-11-02 15:28:33'),
(28, 1, 16, 2, '2024-11-02 15:30:43'),
(29, 1, 19, 1, '2024-11-02 15:31:16'),
(30, 1, 17, 1, '2024-11-02 15:32:20'),
(31, 1, 20, 4, '2024-11-02 15:32:30'),
(32, 2, 11, 1, '2024-11-02 16:39:35'),
(33, 2, 12, 5, '2024-11-02 16:39:40'),
(34, 4, 11, 2, '2024-11-03 01:44:17'),
(35, 4, 12, 4, '2024-11-03 01:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nickname`, `password`, `created_at`, `email`, `phone`, `address`) VALUES
(1, 'joshua', 'opop', '$2y$10$xikawS8VJ6U7bxsVT4.iJeW1YV/.uNbNY9YMpihRILtEIAa2qzwjy', '2024-11-02 13:39:31', 'joshau@gmail.com', '09065804521', 'zone3SANKANAN'),
(2, 'ace', 'firefist', '$2y$10$Em2hPKKR6y4I1RM5MLMiAO/K5e7tUmQQvk6ZWeEY9PzG.q5mFREKe', '2024-11-02 13:51:47', 'pirate@gmail.com', '09665788443', 'southblue'),
(3, 'opop', 'cheepcode29', '$2y$10$XvtNLQ2WiO8MKGzAiQM3QO9Gf0tebiK8hZY8Wb8zJgSvJsPMJAG.e', '2024-11-02 14:07:36', 'cheepcode@outlook.com', '094433226478', 'woldforcode'),
(4, 'zoro', 'god of hell', '$2y$10$i8c7qdq.A/x5P8o817McjuoOJUv2oAz.9si3DeXbOz0JXpFDDo0My', '2024-11-03 01:43:08', 'zoro@gmail.com', '09445367889', 'southblue');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_ratings`
--
ALTER TABLE `movie_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `movie_ratings`
--
ALTER TABLE `movie_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movie_ratings`
--
ALTER TABLE `movie_ratings`
  ADD CONSTRAINT `movie_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_ratings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
