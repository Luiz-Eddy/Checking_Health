-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Jun-2020 às 20:44
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_pi_2020`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_dependente` int(11) DEFAULT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `consultas`
--

INSERT INTO `consultas` (`id`, `id_usuario`, `id_dependente`, `status`) VALUES
(14, 21, NULL, '2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cor`
--

CREATE TABLE `cor` (
  `id` int(11) NOT NULL,
  `cor` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cor`
--

INSERT INTO `cor` (`id`, `cor`) VALUES
(1, 'Preto(a)'),
(2, 'Branco(a)'),
(3, 'Pardo(a)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dependente`
--

CREATE TABLE `dependente` (
  `id` int(30) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `sobrenome` varchar(32) NOT NULL,
  `dt_nasc` date NOT NULL,
  `rg` varchar(30) NOT NULL,
  `cpf` varchar(30) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_parentesco` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado_civil`
--

CREATE TABLE `estado_civil` (
  `id` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `estado_civil`
--

INSERT INTO `estado_civil` (`id`, `estado`) VALUES
(1, 'Solteiro(a)'),
(2, 'Casado(a)'),
(3, 'Viuvo(a)'),
(4, 'Divorciado(a)'),
(5, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `exames`
--

CREATE TABLE `exames` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_dependente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `frequencia`
--

CREATE TABLE `frequencia` (
  `id` int(11) NOT NULL,
  `alternativa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `frequencia`
--

INSERT INTO `frequencia` (`id`, `alternativa`) VALUES
(1, 'Diariamente'),
(2, 'Semanalmente'),
(3, 'Intervalo de Horas'),
(4, 'Intervalo de Dias'),
(5, 'Outro (Não aparece no painel)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `info_consultas`
--

CREATE TABLE `info_consultas` (
  `id` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `nome_consulta` varchar(255) NOT NULL,
  `nome_medico` varchar(255) NOT NULL,
  `data_consulta` date NOT NULL,
  `hora_consulta` time NOT NULL,
  `data_realizada` date DEFAULT NULL,
  `hora_realizada` time DEFAULT NULL,
  `local` varchar(255) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `info_exames`
--

CREATE TABLE `info_exames` (
  `id` int(11) NOT NULL,
  `data_exame` date NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `id_exames` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `info_medicamento`
--

CREATE TABLE `info_medicamento` (
  `id` int(11) NOT NULL,
  `id_medicamento` int(11) NOT NULL,
  `nome_medicamento` varchar(255) NOT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  `data_inicio` date NOT NULL,
  `data_termino` date DEFAULT NULL,
  `hora_inicio` time NOT NULL,
  `hora_termino` time DEFAULT NULL,
  `id_frequencia` int(11) NOT NULL,
  `info_frequencia` varchar(255) NOT NULL,
  `receita` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_dependente` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `opcoes`
--

CREATE TABLE `opcoes` (
  `id` int(11) NOT NULL,
  `opcao` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `opcoes`
--

INSERT INTO `opcoes` (`id`, `opcao`) VALUES
(1, 'Sim'),
(2, 'Não');

-- --------------------------------------------------------

--
-- Estrutura da tabela `parentesco`
--

CREATE TABLE `parentesco` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `parentesco`
--

INSERT INTO `parentesco` (`id`, `tipo`) VALUES
(1, 'Pai'),
(2, 'Mãe'),
(3, 'Filho(a)'),
(4, 'Avô(ó)'),
(5, 'Irmã(o)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recovery_codes`
--

CREATE TABLE `recovery_codes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `process` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sexo`
--

CREATE TABLE `sexo` (
  `id` int(11) NOT NULL,
  `sexo` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sexo`
--

INSERT INTO `sexo` (`id`, `sexo`) VALUES
(1, 'Feminino'),
(2, 'Masculino'),
(3, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_sangue`
--

CREATE TABLE `tipo_sangue` (
  `id` int(11) NOT NULL,
  `sangue` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipo_sangue`
--

INSERT INTO `tipo_sangue` (`id`, `sangue`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `sobrenome` varchar(30) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `email` varchar(40) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `dt_nasc` date DEFAULT NULL,
  `id_sexo` varchar(30) DEFAULT NULL,
  `id_estCivil` varchar(30) DEFAULT NULL,
  `id_cor` varchar(30) DEFAULT NULL,
  `rg` varchar(60) DEFAULT NULL,
  `sus` varchar(30) DEFAULT NULL,
  `alergia` varchar(255) DEFAULT NULL,
  `doencas` varchar(30) DEFAULT NULL,
  `id_sangue` varchar(30) DEFAULT NULL,
  `id_fumante` varchar(30) DEFAULT NULL,
  `id_alcool` varchar(30) DEFAULT NULL,
  `id_tatuagem` varchar(30) DEFAULT NULL,
  `quant_tatuagem` varchar(30) DEFAULT NULL,
  `cep` varchar(30) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` varchar(30) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `obs` varchar(255) DEFAULT NULL,
  `CREATE_DATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vacinacao`
--

CREATE TABLE `vacinacao` (
  `id` int(11) NOT NULL,
  `vacina` varchar(30) NOT NULL,
  `local_vacina` varchar(30) DEFAULT NULL,
  `dt_ven` date NOT NULL,
  `dt_dose` date DEFAULT NULL,
  `obs` varchar(255) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_dependente` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_dependente` (`id_dependente`) USING BTREE;

--
-- Índices para tabela `cor`
--
ALTER TABLE `cor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dependente`
--
ALTER TABLE `dependente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pk_usuario` (`id_usuario`) USING BTREE,
  ADD KEY `pk_parentesco` (`id_parentesco`);

--
-- Índices para tabela `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `exames`
--
ALTER TABLE `exames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pk_dependente` (`id_dependente`),
  ADD KEY `pk_usuario` (`id_usuario`) USING BTREE;

--
-- Índices para tabela `frequencia`
--
ALTER TABLE `frequencia`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `info_consultas`
--
ALTER TABLE `info_consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_consulta` (`id_consulta`);

--
-- Índices para tabela `info_exames`
--
ALTER TABLE `info_exames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pk_exames` (`id_exames`) USING BTREE;

--
-- Índices para tabela `info_medicamento`
--
ALTER TABLE `info_medicamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_medicamento` (`id_medicamento`),
  ADD KEY `id_frequencia` (`id_frequencia`);

--
-- Índices para tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_dependente` (`id_dependente`);

--
-- Índices para tabela `opcoes`
--
ALTER TABLE `opcoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `parentesco`
--
ALTER TABLE `parentesco`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `recovery_codes`
--
ALTER TABLE `recovery_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pk_usuario` (`id_usuario`) USING BTREE;

--
-- Índices para tabela `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tipo_sangue`
--
ALTER TABLE `tipo_sangue`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `vacinacao`
--
ALTER TABLE `vacinacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dependente` (`id_dependente`),
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `cor`
--
ALTER TABLE `cor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `dependente`
--
ALTER TABLE `dependente`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `exames`
--
ALTER TABLE `exames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `frequencia`
--
ALTER TABLE `frequencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `info_consultas`
--
ALTER TABLE `info_consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `info_exames`
--
ALTER TABLE `info_exames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `info_medicamento`
--
ALTER TABLE `info_medicamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `opcoes`
--
ALTER TABLE `opcoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `parentesco`
--
ALTER TABLE `parentesco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `recovery_codes`
--
ALTER TABLE `recovery_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tipo_sangue`
--
ALTER TABLE `tipo_sangue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `vacinacao`
--
ALTER TABLE `vacinacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `info_exames`
--
ALTER TABLE `info_exames`
  ADD CONSTRAINT `info_exames_ibfk_1` FOREIGN KEY (`id_exames`) REFERENCES `exames` (`id`);

--
-- Limitadores para a tabela `info_medicamento`
--
ALTER TABLE `info_medicamento`
  ADD CONSTRAINT `info_medicamento_ibfk_1` FOREIGN KEY (`id_frequencia`) REFERENCES `frequencia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `info_medicamento_ibfk_2` FOREIGN KEY (`id_medicamento`) REFERENCES `medicamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
