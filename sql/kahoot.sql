-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-12-2019 a las 13:13:48
-- Versión del servidor: 5.7.28-0ubuntu0.19.04.2
-- Versión de PHP: 7.2.25-1+ubuntu19.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kahoot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `answer_name` varchar(150) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `answer`
--

INSERT INTO `answer` (`answer_id`, `answer_name`, `question_id`, `orden`, `correct`) VALUES
(1, 'Verdadero', 1, 1, 1),
(2, 'Falso', 1, 2, 0),
(3, 'Verdadero', 2, 1, 1),
(4, 'Falso', 2, 2, 0),
(5, 'Verdadero', 3, 1, 0),
(6, 'Falso', 3, 2, 1),
(7, 'Verdadero', 4, 1, 1),
(8, 'Falso', 4, 2, 0),
(9, 'Verdadero', 5, 1, 1),
(10, 'Falso', 5, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamer`
--

CREATE TABLE `gamer` (
  `gamer_id` int(11) NOT NULL,
  `gamer_name` varchar(30) NOT NULL,
  `kahoot_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kahoot`
--

CREATE TABLE `kahoot` (
  `kahoot_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kahoot_name` varchar(30) NOT NULL,
  `pin` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `limit_users` int(11) NOT NULL,
  `start_game` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `kahoot`
--

INSERT INTO `kahoot` (`kahoot_id`, `user_id`, `kahoot_name`, `pin`, `active`, `limit_users`, `start_game`) VALUES
(1, 1, 'Deportes', 43564, 0, 20, 0),
(2, 1, 'Wordpress', 24223, 0, 20, 0),
(3, 2, 'Wordpress', 12345, 0, 20, 0),
(4, 2, 'Sport', 98989, 0, 20, 0),
(5, 3, 'Futbol', 42455, 0, 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `question_name` varchar(150) NOT NULL,
  `kahoot_id` int(11) DEFAULT NULL,
  `time` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `question_points` int(11) NOT NULL,
  `image_path` text,
  `next` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `question`
--

INSERT INTO `question` (`question_id`, `question_name`, `kahoot_id`, `time`, `orden`, `question_points`, `image_path`, `next`) VALUES
(1, 'El Granada está en Primera División?', 5, 30, 1, 600, NULL, 0),
(2, 'El primer Clásico de la temporada se jugará el 18/12/2019?', 5, 20, 2, 1000, NULL, 0),
(3, 'El Madrid ganó la última Champions League?', 5, 20, 3, 750, NULL, 0),
(4, 'El FC Barcelona ha ganado 5 Champions League en toda su historia?', 5, 25, 4, 750, NULL, 0),
(5, 'El Valencia ganó la última Copa del Rey?', 5, 15, 5, 450, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ranking`
--

CREATE TABLE `ranking` (
  `ranking_id` int(11) NOT NULL,
  `points` int(11) DEFAULT NULL,
  `kahoot_id` int(11) DEFAULT NULL,
  `gamer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `selected`
--

CREATE TABLE `selected` (
  `selected_id` int(11) NOT NULL,
  `answer_name` varchar(30) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `gamer_id` int(11) DEFAULT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `token`
--

CREATE TABLE `token` (
  `token_id` int(11) NOT NULL,
  `token` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(5) NOT NULL,
  `expired` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `token`
--

INSERT INTO `token` (`token_id`, `token`, `user_id`, `type`, `expired`) VALUES
(1, '5a29f1cfde5b89cac4e2ea5634393fd1', 1, 'TOS', 1),
(2, '4bcd653812a9080b6c151fc97dc94132', 2, 'TOS', 1),
(3, '7a7a7b75392471f2c5f77587e7b3c0fe', 3, 'TOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `password` varchar(512) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `user_type` varchar(10) NOT NULL,
  `profile_image` varchar(200) DEFAULT 'img_defecto.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `email`, `user_type`, `profile_image`) VALUES
(1, 'Joel', '6bfcc4026b5f162799a6dc8305c09db9c1674ac616bd5c7422a45fbb6d0816ac163047c47a1f426f4f4c6b5b5042c671eabc4fdc7310fd5b183eef59dc274604', 'joel@gmail.com', 'PREMIUM', 'img_defecto.png'),
(2, 'Didac', '959bb4493362054abfdcfb0ec24b87c0c745cca282eb8a071ae39ed65199986789e011b7e336dd4d75ea2229b57f82dd346beff6d5409d4e93dcad0e088e5e55', 'didac@gmail.com', 'PREMIUM', 'img_defecto.png'),
(3, 'Marc', '93cc945e4eb44677799a68b6a0cd6615b1ca9b8d525812e7f6efc84853a6dc5d5a086bff517db5b7f21f04e6cccdd7b75f7b120545e163009a5af81b1aef657e', 'marc@gmail.com', 'PREMIUM', 'img_defecto.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indices de la tabla `gamer`
--
ALTER TABLE `gamer`
  ADD PRIMARY KEY (`gamer_id`),
  ADD KEY `kahoot_id` (`kahoot_id`);

--
-- Indices de la tabla `kahoot`
--
ALTER TABLE `kahoot`
  ADD PRIMARY KEY (`kahoot_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `kahoot_id` (`kahoot_id`);

--
-- Indices de la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`ranking_id`),
  ADD KEY `kahoot_id` (`kahoot_id`),
  ADD KEY `gamer_id` (`gamer_id`);

--
-- Indices de la tabla `selected`
--
ALTER TABLE `selected`
  ADD PRIMARY KEY (`selected_id`),
  ADD KEY `gamer_id` (`gamer_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Indices de la tabla `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `gamer`
--
ALTER TABLE `gamer`
  MODIFY `gamer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kahoot`
--
ALTER TABLE `kahoot`
  MODIFY `kahoot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ranking`
--
ALTER TABLE `ranking`
  MODIFY `ranking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `selected`
--
ALTER TABLE `selected`
  MODIFY `selected_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `token`
--
ALTER TABLE `token`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`);

--
-- Filtros para la tabla `gamer`
--
ALTER TABLE `gamer`
  ADD CONSTRAINT `gamer_ibfk_1` FOREIGN KEY (`kahoot_id`) REFERENCES `kahoot` (`kahoot_id`);

--
-- Filtros para la tabla `kahoot`
--
ALTER TABLE `kahoot`
  ADD CONSTRAINT `kahoot_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`kahoot_id`) REFERENCES `kahoot` (`kahoot_id`);

--
-- Filtros para la tabla `ranking`
--
ALTER TABLE `ranking`
  ADD CONSTRAINT `ranking_ibfk_1` FOREIGN KEY (`kahoot_id`) REFERENCES `kahoot` (`kahoot_id`),
  ADD CONSTRAINT `ranking_ibfk_2` FOREIGN KEY (`gamer_id`) REFERENCES `gamer` (`gamer_id`);

--
-- Filtros para la tabla `selected`
--
ALTER TABLE `selected`
  ADD CONSTRAINT `selected_ibfk_1` FOREIGN KEY (`gamer_id`) REFERENCES `gamer` (`gamer_id`),
  ADD CONSTRAINT `selected_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`answer_id`);

--
-- Filtros para la tabla `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
