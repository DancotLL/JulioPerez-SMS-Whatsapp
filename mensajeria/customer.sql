

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `correos` (
  `id` int(11) NOT NULL,
  `cliente` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `correos`
--

INSERT INTO `correos` (`id`, `cliente`, `email`) VALUES
(1, 'Diego Asturias', 'singma5@hotmail.com'),
(2, 'Victor ', 'victoral@mailinator.com'),
(3, 'Manuel', 'manuel@gmail.com'),
(4, 'Julio Perez', 'rededucativa.gt@gmail.com'),
(5, 'Lucky Elías', 'luckeli@gmail.com'),
(6, 'Dayrin Perez', 'dayrinperez@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
