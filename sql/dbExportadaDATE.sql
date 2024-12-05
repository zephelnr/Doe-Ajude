-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/12/2024 às 22:38
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mydb`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `interesse`
--

CREATE TABLE `interesse` (
  `idinteresse` int(11) NOT NULL,
  `usuario_email` varchar(100) NOT NULL,
  `publicacao_idpublicacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `publicacao`
--

CREATE TABLE `publicacao` (
  `idpublicacao` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `telefone` varchar(12) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `status` varchar(45) NOT NULL,
  `data` date NOT NULL,
  `usuario_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `publicacao`
--

INSERT INTO `publicacao` (`idpublicacao`, `titulo`, `descricao`, `cidade`, `estado`, `telefone`, `foto`, `status`, `data`, `usuario_email`) VALUES
(1, 'Televisão', 'televisão 42 polegadas', 'Jaraguá do Sul', 'Santa Catarina', '47900000000', '', 'Disponível', '2024-11-23', 'j@email.com'),
(2, 'Geladeira', 'geladeira eletrolux usada ', 'Florianópolis', 'Santa Catarina', '47900000001', '', 'Disponível', '2024-11-23', 'j@email.com'),
(4, 'Microondas', 'usado', 'Ibituba', 'SC', '47900000002', '', 'Indisponível', '2024-11-23', 'j@email.com'),
(5, 'Boneco', 'Brinquedo infantil', 'Corupá', 'Santa Catarina', '47999999998', '', 'Disponível', '2024-11-25', 'j@email.com'),
(6, 'Mesa', 'mesa branca usada', 'Joinville', 'Santa Catarina', '47999999988', '', 'Disponível', '2024-11-26', 'j@email.com'),
(8, 'celular', 'smartphone samsung', 'Corupá', 'SC', '47855996633', '', 'Disponível', '2024-12-02', 'j@email.com'),
(9, 'livro', 'livro harry potter 1', 'Jaraguá do Sul', 'SC', '478559966', '', 'Disponível', '2024-12-02', 'j@email.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `email` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nomeCompleto` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`email`, `cpf`, `nomeCompleto`, `senha`) VALUES
('a@email.com', '00000000066', 'Ambressa Noxus', '931145d4ddd1811be545e4ac88a81f1fdbfaf0779c437efba16b884595274d11'),
('j@email.com', '00011122200', 'João Alexandre', '931145d4ddd1811be545e4ac88a81f1fdbfaf0779c437efba16b884595274d11');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `interesse`
--
ALTER TABLE `interesse`
  ADD PRIMARY KEY (`idinteresse`),
  ADD KEY `fk_interesse_usuario1_idx` (`usuario_email`),
  ADD KEY `fk_interesse_publicacao1_idx` (`publicacao_idpublicacao`);

--
-- Índices de tabela `publicacao`
--
ALTER TABLE `publicacao`
  ADD PRIMARY KEY (`idpublicacao`),
  ADD KEY `fk_publicacao_usuario_idx` (`usuario_email`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `interesse`
--
ALTER TABLE `interesse`
  MODIFY `idinteresse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `publicacao`
--
ALTER TABLE `publicacao`
  MODIFY `idpublicacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `interesse`
--
ALTER TABLE `interesse`
  ADD CONSTRAINT `fk_interesse_publicacao1` FOREIGN KEY (`publicacao_idpublicacao`) REFERENCES `publicacao` (`idpublicacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_interesse_usuario1` FOREIGN KEY (`usuario_email`) REFERENCES `usuario` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `publicacao`
--
ALTER TABLE `publicacao`
  ADD CONSTRAINT `fk_publicacao_usuario` FOREIGN KEY (`usuario_email`) REFERENCES `usuario` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
