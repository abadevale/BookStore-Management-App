CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL
);


INSERT INTO `admin` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Abade V', 'abade@gmail.com', '$2y$10$P5L5LaI5ONPbm1oNA4SmnOdYrOyVwP1Pjw5Y1GS.84w6k3KUx0Dfq');


ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

