-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/04/2025 às 16:27
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto1`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acessibilidade`
--

CREATE TABLE `acessibilidade` (
  `acessibilidade_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pictograma` int(1) NOT NULL,
  `pictograma_tamanho` int(11) NOT NULL,
  `daltonico` int(1) NOT NULL,
  `protanopia` int(1) NOT NULL,
  `deuteranopia` int(1) NOT NULL,
  `tritanopia` int(1) NOT NULL,
  `legenda` int(1) NOT NULL,
  `legenda_velocidade` int(11) NOT NULL,
  `legenda_cor` varchar(10) NOT NULL,
  `legenda_tamanho` int(11) NOT NULL,
  `legenda_posicao` int(11) NOT NULL,
  `legenda_fundo` varchar(10) NOT NULL,
  `musica` int(1) NOT NULL,
  `musica_volume` int(10) NOT NULL,
  `efeitos_sonoros` int(1) NOT NULL,
  `efeitos_sonoros_volume` int(10) NOT NULL,
  `interprete` int(1) NOT NULL,
  `interprete_expressoes_faciais` int(1) NOT NULL,
  `interprete_gestos` int(1) NOT NULL,
  `interprete_audio` int(11) NOT NULL,
  `interprete_audio_velocidade` int(11) NOT NULL,
  `interprete_audio_volume` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `acessibilidade`
--

INSERT INTO `acessibilidade` (`acessibilidade_id`, `usuario_id`, `pictograma`, `pictograma_tamanho`, `daltonico`, `protanopia`, `deuteranopia`, `tritanopia`, `legenda`, `legenda_velocidade`, `legenda_cor`, `legenda_tamanho`, `legenda_posicao`, `legenda_fundo`, `musica`, `musica_volume`, `efeitos_sonoros`, `efeitos_sonoros_volume`, `interprete`, `interprete_expressoes_faciais`, `interprete_gestos`, `interprete_audio`, `interprete_audio_velocidade`, `interprete_audio_volume`) VALUES
(1, 1, 1, 3, 1, 0, 0, 0, 0, 1, '#4d4c52', 1, 1, '#ffffff', 0, 3, 0, 0, 0, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nome`, `senha`, `email`) VALUES
(1, 'Lara', '1', 'lara.oberderfer@gmail.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `acessibilidade`
--
ALTER TABLE `acessibilidade`
  ADD PRIMARY KEY (`acessibilidade_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acessibilidade`
--
ALTER TABLE `acessibilidade`
  MODIFY `acessibilidade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
