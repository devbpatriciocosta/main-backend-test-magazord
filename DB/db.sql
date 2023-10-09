SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Estrutura da tabela para a tabela 'user';
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nome` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_description` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_cpf` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_foto` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_criado` timestamp NOT NULL,
  `usuario_atualizado` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Inserção de dados para a tabela 'user';
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nome`, `usuario_description`, `usuario_email`, `usuario_usuario`, `usuario_cpf`, `usuario_foto`, `usuario_criado`, `usuario_atualizado`) VALUES
(1, 'Administrador', 'Principal', 'admin@admin.com', 'Administrador', '$2y$10$F0J8k.lFjgGAK6I/tcbhyuMKSaitXy8ENMSBVZWErIoA6.VSU8MQy', '', '2023-10-06 18:48:05', '2023-10-06 18:48:05');

--
-- Indices da tabela 'usuario';
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT da tabela 'usuario';
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
