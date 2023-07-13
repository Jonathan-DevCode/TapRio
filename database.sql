-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Mar-2023 às 02:15
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `th`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

CREATE TABLE `agenda` (
  `agenda_id` int(11) NOT NULL,
  `agenda_imovel` int(11) DEFAULT NULL,
  `agenda_cliente` int(11) DEFAULT NULL,
  `agenda_usuario` int(11) DEFAULT NULL,
  `agenda_horario` datetime DEFAULT NULL,
  `agenda_status` int(11) DEFAULT NULL,
  `agenda_obs` longtext DEFAULT NULL,
  `agenda_imob_id` int(11) DEFAULT NULL,
  `agenda_created` timestamp NULL DEFAULT current_timestamp(),
  `agenda_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atributo`
--

CREATE TABLE `atributo` (
  `atributo_id` int(11) NOT NULL,
  `atributo_titulo` varchar(255) DEFAULT NULL,
  `atributo_icone` varchar(255) DEFAULT NULL,
  `atributo_imob_id` int(11) DEFAULT NULL,
  `atributo_created` timestamp NULL DEFAULT current_timestamp(),
  `atributo_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `atributo`
--

INSERT INTO `atributo` (`atributo_id`, `atributo_titulo`, `atributo_icone`, `atributo_imob_id`, `atributo_created`, `atributo_updated`) VALUES
(2, 'Quartos', 'fas fa-bed', 1, '2021-12-06 16:53:32', '2023-01-26 20:08:15'),
(3, 'Vagas\\\'', 'fa-car', 1, '2021-12-06 16:54:37', '2023-03-14 02:25:40'),
(4, 'Área Útil (m²)', 'fa-anchor', NULL, '2023-03-18 00:03:00', '2023-03-18 00:03:00'),
(5, 'Área Útil (H)', 'fa-anchor', NULL, '2023-03-18 00:03:29', '2023-03-18 00:03:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `atributo_imovel`
--

CREATE TABLE `atributo_imovel` (
  `atributo_imovel_id` int(11) NOT NULL,
  `atributo_imovel_imovel_id` int(11) DEFAULT NULL,
  `atributo_imovel_atributo_id` int(11) DEFAULT NULL,
  `atributo_imovel_valor` varchar(255) DEFAULT NULL,
  `atributo_imovel_imob_id` int(11) DEFAULT NULL,
  `atributo_imovel_created` timestamp NULL DEFAULT current_timestamp(),
  `atributo_imovel_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `atributo_imovel`
--

INSERT INTO `atributo_imovel` (`atributo_imovel_id`, `atributo_imovel_imovel_id`, `atributo_imovel_atributo_id`, `atributo_imovel_valor`, `atributo_imovel_imob_id`, `atributo_imovel_created`, `atributo_imovel_updated`) VALUES
(3, 3, 2, '5', 1, '2021-12-06 16:54:05', '2023-01-26 20:08:16'),
(4, 3, 3, '4', 1, '2021-12-06 16:54:37', '2023-01-26 20:08:16'),
(5, 2, 2, '3', 1, '2021-12-06 20:44:22', '2023-01-26 20:08:16'),
(6, 2, 3, '2', 1, '2021-12-06 20:44:27', '2023-01-26 20:08:16'),
(8, 3, 4, '20', NULL, '2023-03-18 00:03:00', '2023-03-18 00:03:00'),
(9, 3, 5, '15', NULL, '2023-03-18 00:03:29', '2023-03-18 00:03:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao_imovel`
--

CREATE TABLE `avaliacao_imovel` (
  `avaliacao_imovel_id` int(11) NOT NULL,
  `avaliacao_imovel_imovel` int(11) DEFAULT NULL,
  `avaliacao_imovel_status` int(11) DEFAULT NULL,
  `avaliacao_imovel_descricao` varchar(255) DEFAULT NULL,
  `avaliacao_imovel_cliente` int(11) DEFAULT NULL,
  `avaliacao_imovel_nota` int(11) DEFAULT NULL,
  `avaliacao_imovel_imob_id` int(11) DEFAULT NULL,
  `avaliacao_imovel_created` timestamp NULL DEFAULT current_timestamp(),
  `avaliacao_imovel_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bairro`
--

CREATE TABLE `bairro` (
  `bairro_id` int(11) NOT NULL,
  `bairro_titulo` varchar(225) DEFAULT NULL,
  `bairro_cidade` int(11) DEFAULT NULL,
  `bairro_imob_id` int(11) DEFAULT NULL,
  `bairro_created` timestamp NULL DEFAULT current_timestamp(),
  `bairro_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `bairro`
--

INSERT INTO `bairro` (`bairro_id`, `bairro_titulo`, `bairro_cidade`, `bairro_imob_id`, `bairro_created`, `bairro_updated`) VALUES
(1, 'Tupi', 1, 1, '2021-10-05 22:32:28', '2023-01-26 20:08:16'),
(2, 'Gonzaga', 2, 1, '2021-12-06 20:36:13', '2023-01-26 20:08:16'),
(3, 'teste', 1, NULL, '2023-03-14 02:15:40', '2023-03-14 02:15:40'),
(4, 'bvbbb', 1, NULL, '2023-03-14 02:16:33', '2023-03-14 02:16:33'),
(5, 'aaaa', 1, NULL, '2023-03-14 02:17:25', '2023-03-14 02:17:25'),
(6, 'eeee', 6, NULL, '2023-03-14 02:17:38', '2023-03-14 02:17:38'),
(7, 'abe', 4, NULL, '2023-03-14 02:19:31', '2023-03-14 02:19:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `caracteristica`
--

CREATE TABLE `caracteristica` (
  `caracteristica_id` int(11) NOT NULL,
  `caracteristica_nome` varchar(255) DEFAULT NULL,
  `caracteristica_diferencial` int(1) DEFAULT 0,
  `caracteristica_tipo` varchar(16) DEFAULT 'imovel',
  `caracteristica_categoria_id` int(11) DEFAULT NULL,
  `caracteristica_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `caracteristica_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `caracteristica`
--

INSERT INTO `caracteristica` (`caracteristica_id`, `caracteristica_nome`, `caracteristica_diferencial`, `caracteristica_tipo`, `caracteristica_categoria_id`, `caracteristica_created`, `caracteristica_updated`) VALUES
(2, 'Aceita animais', 1, 'ambos', 4, '2023-03-17 11:10:56', '2023-03-17 17:10:01'),
(3, 'Ar condicionado', 0, 'imovel', 4, '2023-03-17 17:10:21', '2023-03-17 17:10:21'),
(4, 'Espaço aberto', 1, 'Condomínio', 4, '2023-03-17 17:10:40', '2023-03-17 17:13:36'),
(5, 'No centro', 0, 'ambos', 3, '2023-03-17 17:10:59', '2023-03-17 17:10:59'),
(6, 'Portaria remota', 0, 'ambos', 2, '2023-03-17 17:11:10', '2023-03-17 17:11:10'),
(7, 'Segurança 24h', 0, 'Condomínio', 2, '2023-03-17 17:11:31', '2023-03-17 17:11:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `caracteristica_categoria`
--

CREATE TABLE `caracteristica_categoria` (
  `caracteristica_categoria_id` int(11) NOT NULL,
  `caracteristica_categoria_nome` varchar(255) DEFAULT NULL,
  `caracteristica_categoria_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `caracteristica_categoria_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `caracteristica_categoria`
--

INSERT INTO `caracteristica_categoria` (`caracteristica_categoria_id`, `caracteristica_categoria_nome`, `caracteristica_categoria_created`, `caracteristica_categoria_updated`) VALUES
(2, 'Segurança', '2023-03-16 22:04:01', '2023-03-16 22:04:01'),
(3, 'Mobilidade', '2023-03-16 22:04:06', '2023-03-16 22:04:06'),
(4, 'Lazer', '2023-03-17 17:07:00', '2023-03-17 17:07:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_imovel`
--

CREATE TABLE `categoria_imovel` (
  `categoria_imovel_id` int(11) NOT NULL,
  `categoria_imovel_nome` varchar(200) DEFAULT NULL,
  `categoria_imovel_url` varchar(200) DEFAULT NULL,
  `categoria_imovel_img_capa` text DEFAULT NULL,
  `categoria_imovel_imob_id` int(11) DEFAULT NULL,
  `categoria_imovel_created` timestamp NULL DEFAULT current_timestamp(),
  `categoria_imovel_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categoria_imovel`
--

INSERT INTO `categoria_imovel` (`categoria_imovel_id`, `categoria_imovel_nome`, `categoria_imovel_url`, `categoria_imovel_img_capa`, `categoria_imovel_imob_id`, `categoria_imovel_created`, `categoria_imovel_updated`) VALUES
(1, 'Apartamento', NULL, '32-18-10-2021-1634602014616e0c1e1bda5-04-11-2021-1636059103618447df38614.jpg', 1, '2021-10-05 22:31:55', '2023-01-26 20:08:16'),
(2, 'Casa', NULL, 'portada-17-11-2021-1637181895619569c74585a.jpg', 1, '2021-11-04 20:31:37', '2023-01-26 20:08:16'),
(3, 'Chalé', NULL, 'architecture-building-design-house-wallpaper-preview-17-11-2021-163718276861956d30b3eeb.jpg', 1, '2021-11-04 20:31:50', '2023-01-26 20:08:16'),
(5, 'vvvv', NULL, NULL, NULL, '2023-03-13 18:36:16', '2023-03-13 18:36:16'),
(6, 'xxx', NULL, 'whatsapp-image-2023-03-11-at-19-13-03-2023-1678760791640fdb57355d3.jpeg', NULL, '2023-03-14 02:17:47', '2023-03-14 02:26:31'),
(7, 'bbb', NULL, NULL, NULL, '2023-03-14 02:18:24', '2023-03-14 02:18:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE `cidade` (
  `cidade_id` int(11) NOT NULL,
  `cidade_titulo` varchar(225) DEFAULT NULL,
  `cidade_uf` int(11) DEFAULT NULL,
  `cidade_imob_id` int(11) DEFAULT NULL,
  `cidade_created` timestamp NULL DEFAULT current_timestamp(),
  `cidade_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`cidade_id`, `cidade_titulo`, `cidade_uf`, `cidade_imob_id`, `cidade_created`, `cidade_updated`) VALUES
(1, 'Praia Grande', 25, 1, '2021-10-05 22:32:22', '2023-01-26 20:08:16'),
(2, 'Santos', 25, 1, '2021-11-04 20:32:53', '2023-01-26 20:08:16'),
(3, 'São Paulo', 25, 1, '2021-11-04 20:33:04', '2023-01-26 20:08:16'),
(4, 'Buzios', 19, 1, '2021-11-04 20:33:15', '2023-01-26 20:08:16'),
(5, 'Maresias', 25, 1, '2021-11-04 20:33:26', '2023-01-26 20:08:16'),
(6, 'bbb', 8, NULL, '2023-03-14 02:17:34', '2023-03-14 02:17:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(11) NOT NULL,
  `cliente_nome` varchar(255) DEFAULT NULL,
  `cliente_cpf` varchar(20) DEFAULT NULL,
  `cliente_rg` varchar(20) DEFAULT NULL,
  `cliente_sexo` int(11) DEFAULT NULL,
  `cliente_telefone` varchar(20) DEFAULT NULL,
  `cliente_telefone2` varchar(20) DEFAULT NULL,
  `cliente_celular` varchar(20) DEFAULT NULL,
  `cliente_celular2` varchar(20) DEFAULT NULL,
  `cliente_email` varchar(255) DEFAULT NULL,
  `cliente_email2` varchar(255) DEFAULT NULL,
  `cliente_password` varchar(255) DEFAULT NULL,
  `cliente_token` varchar(255) DEFAULT NULL,
  `cliente_cep` varchar(15) DEFAULT NULL,
  `cliente_rua` varchar(200) DEFAULT NULL,
  `cliente_num` varchar(20) DEFAULT NULL,
  `cliente_bairro` varchar(255) DEFAULT NULL,
  `cliente_cidade` varchar(255) DEFAULT NULL,
  `cliente_uf` varchar(2) DEFAULT NULL,
  `cliente_nascimento` date DEFAULT NULL,
  `cliente_complemento` varchar(200) DEFAULT NULL,
  `cliente_obs` text DEFAULT NULL,
  `cliente_status` int(11) DEFAULT 1,
  `cliente_imob_id` int(11) DEFAULT NULL,
  `cliente_created` timestamp NULL DEFAULT current_timestamp(),
  `cliente_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `condominio`
--

CREATE TABLE `condominio` (
  `condominio_id` int(11) NOT NULL,
  `condominio_nome` varchar(255) DEFAULT NULL,
  `condominio_qtd_andar` int(3) DEFAULT NULL,
  `condominio_qtd_unidades_por_andar` int(3) DEFAULT NULL,
  `condominio_qtd_torres` int(3) DEFAULT NULL,
  `condominio_ano_construcao` int(4) DEFAULT NULL,
  `condominio_uf_id` int(11) DEFAULT NULL,
  `condominio_cidade_id` int(11) DEFAULT NULL,
  `condominio_bairro_id` int(11) DEFAULT NULL,
  `condominio_cep` varchar(16) DEFAULT NULL,
  `condominio_rua` varchar(255) DEFAULT NULL,
  `condominio_num` varchar(16) DEFAULT NULL,
  `condominio_destaque` int(1) DEFAULT 0,
  `condominio_status` int(1) DEFAULT 1,
  `condominio_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `condominio_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `condominio`
--

INSERT INTO `condominio` (`condominio_id`, `condominio_nome`, `condominio_qtd_andar`, `condominio_qtd_unidades_por_andar`, `condominio_qtd_torres`, `condominio_ano_construcao`, `condominio_uf_id`, `condominio_cidade_id`, `condominio_bairro_id`, `condominio_cep`, `condominio_rua`, `condominio_num`, `condominio_destaque`, `condominio_status`, `condominio_created`, `condominio_updated`) VALUES
(5, 'Tapajuras', 2, 2, 2, 2022, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2023-03-18 00:56:29', '2023-03-18 00:56:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `condominio_caracteristica`
--

CREATE TABLE `condominio_caracteristica` (
  `condominio_caracteristica_id` int(11) NOT NULL,
  `condominio_caracteristica_condominio_id` int(11) DEFAULT NULL,
  `condominio_caracteristica_caracteristica_id` int(11) DEFAULT NULL,
  `condominio_caracteristica_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `condominio_caracteristica_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `config_id` int(11) NOT NULL,
  `config_site_title` varchar(200) DEFAULT NULL,
  `config_site_logo` varchar(200) DEFAULT NULL,
  `config_site_titulo_lading` text DEFAULT NULL,
  `config_site_tema_categoria` int(11) NOT NULL DEFAULT 1,
  `config_site_tema_imovel` int(11) NOT NULL DEFAULT 1,
  `config_site_tema_search` int(11) NOT NULL DEFAULT 1,
  `config_site_top_gradient` int(11) NOT NULL DEFAULT 1,
  `config_site_text_lading` text DEFAULT NULL,
  `config_site_fundo_search` varchar(255) DEFAULT NULL,
  `config_site_altura_search` int(11) NOT NULL DEFAULT 1,
  `config_site_search_posicao` int(11) NOT NULL DEFAULT 1,
  `config_site_color_search` varchar(16) DEFAULT NULL,
  `config_site_slogan` varchar(200) DEFAULT NULL,
  `config_site_favicon` varchar(200) DEFAULT NULL,
  `config_site_author` varchar(200) DEFAULT NULL,
  `config_site_description` text DEFAULT NULL,
  `config_site_about` longtext DEFAULT NULL,
  `config_site_keywords` text DEFAULT NULL,
  `config_site_ga_id` varchar(200) DEFAULT NULL,
  `config_site_ga_code` varchar(255) DEFAULT NULL,
  `config_site_tm_code` varchar(255) DEFAULT NULL,
  `config_site_chat_code` longtext DEFAULT NULL,
  `config_site_funcionamento` varchar(200) DEFAULT NULL,
  `config_tema_id` int(11) DEFAULT 1,
  `config_site_telefone` varchar(16) DEFAULT NULL,
  `config_site_telefone2` varchar(16) DEFAULT NULL,
  `config_site_email` varchar(200) DEFAULT NULL,
  `config_site_cnpj` varchar(30) DEFAULT NULL,
  `config_site_creci` varchar(30) DEFAULT NULL,
  `config_site_cep` varchar(16) DEFAULT NULL,
  `config_site_rua` varchar(200) DEFAULT NULL,
  `config_site_num` varchar(16) DEFAULT NULL,
  `config_site_bairro` varchar(200) DEFAULT NULL,
  `config_site_cidade` varchar(200) DEFAULT NULL,
  `config_site_uf` varchar(3) DEFAULT NULL,
  `config_lgpd_texto` varchar(255) DEFAULT NULL,
  `config_lgpd_link` varchar(255) DEFAULT NULL,
  `config_site_modo` int(11) DEFAULT 1,
  `config_site_layout` int(11) DEFAULT 1,
  `config_site_logo_formato` int(11) NOT NULL DEFAULT 1,
  `config_imob_id` int(11) DEFAULT NULL,
  `config_created` timestamp NULL DEFAULT current_timestamp(),
  `config_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`config_id`, `config_site_title`, `config_site_logo`, `config_site_titulo_lading`, `config_site_tema_categoria`, `config_site_tema_imovel`, `config_site_tema_search`, `config_site_top_gradient`, `config_site_text_lading`, `config_site_fundo_search`, `config_site_altura_search`, `config_site_search_posicao`, `config_site_color_search`, `config_site_slogan`, `config_site_favicon`, `config_site_author`, `config_site_description`, `config_site_about`, `config_site_keywords`, `config_site_ga_id`, `config_site_ga_code`, `config_site_tm_code`, `config_site_chat_code`, `config_site_funcionamento`, `config_tema_id`, `config_site_telefone`, `config_site_telefone2`, `config_site_email`, `config_site_cnpj`, `config_site_creci`, `config_site_cep`, `config_site_rua`, `config_site_num`, `config_site_bairro`, `config_site_cidade`, `config_site_uf`, `config_lgpd_texto`, `config_lgpd_link`, `config_site_modo`, `config_site_layout`, `config_site_logo_formato`, `config_imob_id`, `config_created`, `config_updated`) VALUES
(1, 'ThinkerHouse', 'logo-thinkercode-04-11-2021-163605574061843abc6b6d5.png', 'Venha conhecer nossos imóveis', 2, 2, 2, 1, 'Diversas opções para você conferir!', 'bg10-01-11-2021-16358200826180a23251ba1.jpg', 600, 3, '#ffffff', 'Plataforma de Imobiliária', 'pc-coding-12-10-2021-163404911461659c5a78bbb.png', 'Thinker Code', '', ' Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolor assumenda nihil tenetur ipsum ducimus officia impedit dolores rerum repellat molestiae, aperiam labore. Repudiandae atque cum incidunt pariatur reiciendis voluptates nemo.', '', '', 'aeae', 'aeae', ' fvfv ', 'doakoea 2kaoeka 2', 1, '(13) 33333-3333', '(13) 99999-9999', 'email@email.com', '', '', '11703-570', 'Rua Morubixaba', '348', 'Tupi', 'Praia Grande', 'SP', 'Ao acessar nosso site, você concorda com os nossos termos de privacidade.', 'vfvfv', 1, 1, 1, 1, '2021-10-04 22:06:02', '2023-01-26 20:08:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config_cores`
--

CREATE TABLE `config_cores` (
  `config_cores_id` int(11) NOT NULL,
  `config_cores_local` varchar(40) DEFAULT NULL,
  `config_cores_fundo` varchar(16) DEFAULT NULL,
  `config_cores_texto` varchar(16) DEFAULT NULL,
  `config_cores_hover_fundo` varchar(16) DEFAULT NULL,
  `config_cores_hover_texto` varchar(16) DEFAULT NULL,
  `config_cores_imob_id` int(11) DEFAULT NULL,
  `config_cores_created` timestamp NULL DEFAULT current_timestamp(),
  `config_cores_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `config_cores`
--

INSERT INTO `config_cores` (`config_cores_id`, `config_cores_local`, `config_cores_fundo`, `config_cores_texto`, `config_cores_hover_fundo`, `config_cores_hover_texto`, `config_cores_imob_id`, `config_cores_created`, `config_cores_updated`) VALUES
(1, 'Topo', '#000000', '#000000', '#000', '#000000', 1, '2021-10-30 15:54:54', '2023-01-26 20:08:16'),
(2, 'Menu', '#000000', '#000000', '#000', '#000000', 1, '2021-10-30 15:54:54', '2023-01-26 20:08:16'),
(3, 'Imobiliária', '#000000', '#000000', '#000', '#000', 1, '2021-10-30 15:54:54', '2023-01-26 20:08:16'),
(4, 'Redes Sociais', '#000000', '#000000', '#000', '#000', 1, '2021-10-30 15:54:54', '2023-01-26 20:08:16'),
(5, 'Rodapé Informações', '#000000', '#000000', '#000', '#000000', 1, '2021-10-30 15:54:54', '2023-01-26 20:08:16'),
(6, 'Rodapé', '#000000', '#000000', '#000', '#000', 1, '2021-10-30 15:54:54', '2023-01-26 20:08:16'),
(7, 'Botões Principais', '#000000', '#000000', '#000000', '#000000', 1, '2021-10-30 15:54:55', '2023-01-26 20:08:16'),
(8, 'Botões de Sucesso', '#000000', '#000000', '#000000', '#000000', 1, '2021-10-30 15:54:55', '2023-01-26 20:08:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `foto_imovel`
--

CREATE TABLE `foto_imovel` (
  `foto_imovel_id` int(11) NOT NULL,
  `foto_imovel_imovel` int(11) DEFAULT NULL,
  `foto_imovel_img` varchar(255) DEFAULT NULL,
  `foto_imovel_url` text DEFAULT NULL,
  `foto_imovel_pos` int(11) DEFAULT 9999,
  `foto_imovel_imob_id` int(11) DEFAULT NULL,
  `foto_imovel_created` timestamp NULL DEFAULT current_timestamp(),
  `foto_imovel_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `foto_imovel`
--

INSERT INTO `foto_imovel` (`foto_imovel_id`, `foto_imovel_imovel`, `foto_imovel_img`, `foto_imovel_url`, `foto_imovel_pos`, `foto_imovel_imob_id`, `foto_imovel_created`, `foto_imovel_updated`) VALUES
(6, 2, 'architecture-building-design-house-wallpaper-preview-06-12-2021-163880186761ae21cbee5cc.jpg', '/var/www/html/thinkercode/thinkerhouse/media/imovel/architecture-building-design-house-wallpaper-preview-06-12-2021-163880186761ae21cbee5cc.jpg', 9999, 1, '2021-12-06 14:44:27', '2023-01-26 20:08:16'),
(7, 3, 'portada-06-12-2021-163880254861ae247452110.jpg', '/var/www/html/thinkercode/thinkerhouse/media/imovel/portada-06-12-2021-163880254861ae247452110.jpg', 9999, 1, '2021-12-06 14:55:48', '2023-01-26 20:08:16'),
(8, 4, 'joao-pessoa-06-12-2021-163880270961ae25156540b.jpg', '/var/www/html/thinkercode/thinkerhouse/media/imovel/joao-pessoa-06-12-2021-163880270961ae25156540b.jpg', 2, 1, '2021-12-06 14:58:29', '2023-03-14 02:33:08'),
(11, 4, 'whatsapp-image-2023-03-11-at-19-13-03-2023-1678761106640fdc922860e.jpeg', 'C:\\xampp\\htdocs\\projects\\miles\\thinkerhouse\\media\\imovel\\whatsapp-image-2023-03-11-at-19-13-03-2023-1678761106640fdc922860e.jpeg', 1, NULL, '2023-03-14 02:31:46', '2023-03-14 02:32:47'),
(12, 4, 'whatsapp-image-2023-03-09-at-15-13-03-2023-1678761106640fdc9242782.jpeg', 'C:\\xampp\\htdocs\\projects\\miles\\thinkerhouse\\media\\imovel\\whatsapp-image-2023-03-09-at-15-13-03-2023-1678761106640fdc9242782.jpeg', 3, NULL, '2023-03-14 02:31:46', '2023-03-14 02:33:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imoveis_relacionados`
--

CREATE TABLE `imoveis_relacionados` (
  `imoveis_relacionados_id` int(11) NOT NULL,
  `imoveis_relacionados_imovel1` int(11) DEFAULT NULL,
  `imoveis_relacionados_imovel2` int(11) DEFAULT NULL,
  `imoveis_relacionados_imob_id` int(11) DEFAULT NULL,
  `imoveis_relacionados_created` timestamp NULL DEFAULT current_timestamp(),
  `imoveis_relacionados_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imovel`
--

CREATE TABLE `imovel` (
  `imovel_id` int(11) NOT NULL,
  `imovel_titulo` varchar(255) DEFAULT NULL,
  `imovel_tipo` varchar(16) NOT NULL DEFAULT 'residencial',
  `imovel_desc` longtext DEFAULT NULL,
  `imovel_video` varchar(255) DEFAULT NULL,
  `imovel_link_tour` varchar(255) DEFAULT NULL,
  `imovel_mostra_fotos` int(1) NOT NULL DEFAULT 1,
  `imovel_modelo_id` int(11) DEFAULT NULL,
  `imovel_condominio_id` int(11) DEFAULT NULL,
  `imovel_user_id` int(11) DEFAULT NULL,
  `imovel_desc_title` varchar(255) DEFAULT NULL,
  `imovel_categoria` int(11) DEFAULT NULL,
  `imovel_ref` varchar(255) DEFAULT NULL,
  `imovel_tipo_negociacao` varchar(16) NOT NULL DEFAULT 'venda',
  `imovel_isento_condominio` int(1) NOT NULL DEFAULT 0,
  `imovel_valor_condominio` decimal(10,2) DEFAULT NULL,
  `imovel_isento_iptu` int(1) NOT NULL DEFAULT 0,
  `imovel_valor_iptu` decimal(10,2) DEFAULT NULL,
  `imovel_temporada` int(11) DEFAULT 0,
  `imovel_valor_venda` double DEFAULT NULL,
  `imovel_valor_locacao` double DEFAULT NULL,
  `imovel_uf_id` int(11) DEFAULT NULL,
  `imovel_cidade_id` int(11) DEFAULT NULL,
  `imovel_bairro_id` int(11) DEFAULT NULL,
  `imovel_rua` varchar(255) DEFAULT NULL,
  `imovel_num` varchar(16) DEFAULT NULL,
  `imovel_cep` varchar(16) DEFAULT NULL,
  `imovel_complemento` varchar(255) DEFAULT NULL,
  `imovel_complemento_view` int(1) NOT NULL DEFAULT 1,
  `imovel_rua_view` int(1) NOT NULL DEFAULT 1,
  `imovel_num_view` int(1) NOT NULL DEFAULT 1,
  `imovel_bairro_view` int(1) NOT NULL DEFAULT 1,
  `imovel_cidade_view` int(1) NOT NULL DEFAULT 1,
  `imovel_uf_view` int(1) NOT NULL DEFAULT 1,
  `imovel_proprietario_nome` varchar(255) DEFAULT NULL,
  `imovel_proprietario_telefone` varchar(20) DEFAULT NULL,
  `imovel_proprietario_email` varchar(255) DEFAULT NULL,
  `imovel_destaque` int(11) DEFAULT 0,
  `imovel_status` int(11) DEFAULT 1,
  `imovel_imob_id` int(11) DEFAULT NULL,
  `imovel_created` timestamp NULL DEFAULT current_timestamp(),
  `imovel_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `imovel`
--

INSERT INTO `imovel` (`imovel_id`, `imovel_titulo`, `imovel_tipo`, `imovel_desc`, `imovel_video`, `imovel_link_tour`, `imovel_mostra_fotos`, `imovel_modelo_id`, `imovel_condominio_id`, `imovel_user_id`, `imovel_desc_title`, `imovel_categoria`, `imovel_ref`, `imovel_tipo_negociacao`, `imovel_isento_condominio`, `imovel_valor_condominio`, `imovel_isento_iptu`, `imovel_valor_iptu`, `imovel_temporada`, `imovel_valor_venda`, `imovel_valor_locacao`, `imovel_uf_id`, `imovel_cidade_id`, `imovel_bairro_id`, `imovel_rua`, `imovel_num`, `imovel_cep`, `imovel_complemento`, `imovel_complemento_view`, `imovel_rua_view`, `imovel_num_view`, `imovel_bairro_view`, `imovel_cidade_view`, `imovel_uf_view`, `imovel_proprietario_nome`, `imovel_proprietario_telefone`, `imovel_proprietario_email`, `imovel_destaque`, `imovel_status`, `imovel_imob_id`, `imovel_created`, `imovel_updated`) VALUES
(2, 'Imóvel 1', 'residencial', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, '001', 'venda', 0, NULL, 0, NULL, 2, 180000, 850, 25, 1, 1, 'Rua apinajes', '250', '11703-570', NULL, 1, 1, 1, 1, 1, 1, 'aeae', '', '', 1, 1, 1, '2021-10-12 13:23:45', '2023-01-26 20:08:16'),
(3, '', 'residencial', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, '', 'venda', 0, NULL, 0, NULL, 2, 7000000, 0, 25, 1, 1, 'Rua Apinajés', '250', '11703-770', 'apto 72', 1, 1, 1, 0, 0, 1, '', '', '', 2, 1, 1, '2021-12-06 14:54:30', '2023-03-18 00:08:54'),
(4, '', 'residencial', '   <span style=\"background-color: rgb(255, 255, 0);\">   bvfgbfgdbddfbfdbaaaaaaaaaaaaaaaaaaaaaaaaa\'</span>', NULL, NULL, 1, NULL, NULL, NULL, NULL, 2, '', 'venda', 0, NULL, 0, NULL, 1, 180000, 1200, 25, 2, 2, '', '', '', NULL, 1, 1, 1, 1, 1, 1, '', '', '', 1, 1, 1, '2021-12-06 14:58:15', '2023-03-14 02:40:14'),
(5, 'aaaaa', 'residencial', '                                                                                 <p>aaa</p>\r\n      \r\n      \r\n      \r\n      \r\n      \r\n      \r\n      \r\n      \r\n      ', 'aeaea', 'xxx', 1, 3, NULL, 1, 'Título da descricao', 5, 'cd', 'venda_aluguel', 1, '0.00', 0, '250.00', 2, 380000, 1500, 25, 1, 1, 'teste', '', '', '', 1, 1, 1, 1, 1, 1, '', '', '', 2, 1, NULL, '2023-03-13 18:37:02', '2023-03-18 00:53:46'),
(6, '', 'residencial', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, '', 'venda', 0, NULL, 0, NULL, 2, 0, 0, 25, 1, 1, '', '', '', NULL, 1, 1, 1, 1, 1, 1, '', NULL, '', 2, 1, NULL, '2023-03-13 19:29:16', '2023-03-13 19:29:16'),
(7, '', 'residencial', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, 3, '', 'venda', 0, NULL, 0, NULL, 2, 0, 0, 19, 4, 7, '', '', '', NULL, 1, 1, 1, 1, 1, 1, 'nome', '(22) 22222-2222', 'email@email.com', 2, 1, NULL, '2023-03-14 01:34:34', '2023-03-14 02:19:48'),
(8, '', 'comercial', '', '', '', 0, 2, 5, 1, NULL, 1, '', 'venda', 0, NULL, 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, '', '', '', 2, 1, NULL, '2023-03-18 01:01:11', '2023-03-18 01:01:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imovel_caracteristica`
--

CREATE TABLE `imovel_caracteristica` (
  `imovel_caracteristica_id` int(11) NOT NULL,
  `imovel_caracteristica_imovel_id` int(11) DEFAULT NULL,
  `imovel_caracteristica_caracteristica_id` int(11) DEFAULT NULL,
  `imovel_caracteristica_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `imovel_caracteristica_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `imovel_caracteristica`
--

INSERT INTO `imovel_caracteristica` (`imovel_caracteristica_id`, `imovel_caracteristica_imovel_id`, `imovel_caracteristica_caracteristica_id`, `imovel_caracteristica_created`, `imovel_caracteristica_updated`) VALUES
(2, 3, 3, '2023-03-18 00:09:01', '2023-03-18 00:09:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelo_imovel`
--

CREATE TABLE `modelo_imovel` (
  `modelo_imovel_id` int(11) NOT NULL,
  `modelo_imovel_nome` varchar(255) DEFAULT NULL,
  `modelo_imovel_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modelo_imovel_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `modelo_imovel`
--

INSERT INTO `modelo_imovel` (`modelo_imovel_id`, `modelo_imovel_nome`, `modelo_imovel_created`, `modelo_imovel_updated`) VALUES
(2, 'Kitnet', '2023-03-18 00:25:56', '2023-03-18 00:25:56'),
(3, 'Sobrado', '2023-03-18 00:26:30', '2023-03-18 00:26:30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `newsletter`
--

CREATE TABLE `newsletter` (
  `newsletter_id` int(11) NOT NULL,
  `newsletter_email` varchar(360) DEFAULT NULL,
  `newsletter_nome` varchar(360) DEFAULT NULL,
  `newsletter_status` int(11) DEFAULT NULL,
  `newsletter_imob_id` int(11) DEFAULT NULL,
  `newsletter_created` timestamp NULL DEFAULT current_timestamp(),
  `newsletter_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_home`
--

CREATE TABLE `order_home` (
  `order_home_id` int(11) NOT NULL,
  `order_home_view` varchar(255) DEFAULT NULL,
  `order_home_apelido` varchar(255) DEFAULT NULL,
  `order_home_order` int(11) DEFAULT NULL,
  `order_home_status` int(11) DEFAULT 1,
  `order_home_imob_id` int(11) DEFAULT NULL,
  `order_home_created` timestamp NULL DEFAULT current_timestamp(),
  `order_home_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parceiro`
--

CREATE TABLE `parceiro` (
  `parceiro_id` int(11) NOT NULL,
  `parceiro_nome` varchar(200) DEFAULT NULL,
  `parceiro_logo` varchar(200) DEFAULT NULL,
  `parceiro_link` varchar(200) DEFAULT NULL,
  `parceiro_pos` int(11) DEFAULT NULL,
  `parceiro_status` int(11) DEFAULT NULL,
  `parceiro_imob_id` int(11) DEFAULT NULL,
  `parceiro_created` timestamp NULL DEFAULT current_timestamp(),
  `parceiro_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `parceiro`
--

INSERT INTO `parceiro` (`parceiro_id`, `parceiro_nome`, `parceiro_logo`, `parceiro_link`, `parceiro_pos`, `parceiro_status`, `parceiro_imob_id`, `parceiro_created`, `parceiro_updated`) VALUES
(1, 'Braun', 'logo-sharing-expertise-02-01-2022-164113133961d1ad4b09aa6.jpg', 'https://teste.com.br', NULL, 1, 1, '2022-01-02 13:48:59', '2023-03-13 18:33:59'),
(4, 'bbbbbbb', 'whatsapp-image-2023-03-11-at-19-13-03-2023-1678732467640f6cb3efaf2.jpeg', '', NULL, 1, NULL, '2023-03-13 18:34:28', '2023-03-13 18:34:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rede_social`
--

CREATE TABLE `rede_social` (
  `rede_social_id` int(11) NOT NULL,
  `rede_social_facebook` varchar(200) DEFAULT NULL,
  `rede_social_twitter` varchar(200) DEFAULT NULL,
  `rede_social_instagram` varchar(200) DEFAULT NULL,
  `rede_social_linkedin` varchar(200) DEFAULT NULL,
  `rede_social_youtube` varchar(200) DEFAULT NULL,
  `rede_social_imob_id` int(11) DEFAULT NULL,
  `rede_social_created` timestamp NULL DEFAULT current_timestamp(),
  `rede_social_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `rede_social`
--

INSERT INTO `rede_social` (`rede_social_id`, `rede_social_facebook`, `rede_social_twitter`, `rede_social_instagram`, `rede_social_linkedin`, `rede_social_youtube`, `rede_social_imob_id`, `rede_social_created`, `rede_social_updated`) VALUES
(1, 'http://facebook.com/', 'http://twitter.com/', '', 'http://linkedin.com/', 'https://www.youtube.com/', 1, '2021-10-04 22:05:59', '2023-01-26 20:08:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `slide`
--

CREATE TABLE `slide` (
  `slide_id` int(11) NOT NULL,
  `slide_img` varchar(255) DEFAULT NULL,
  `slide_status` int(11) DEFAULT 1,
  `slide_pos` int(11) DEFAULT 999,
  `slide_url` varchar(255) DEFAULT NULL,
  `slide_tipo` int(11) DEFAULT 1,
  `slide_imob_id` int(11) DEFAULT NULL,
  `slide_created` timestamp NULL DEFAULT current_timestamp(),
  `slide_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `slide`
--

INSERT INTO `slide` (`slide_id`, `slide_img`, `slide_status`, `slide_pos`, `slide_url`, `slide_tipo`, `slide_imob_id`, `slide_created`, `slide_updated`) VALUES
(1, '32-18-10-2021-1634602014616e0c1e1bda5.jpg', 1, 1, NULL, 1, 1, '2021-10-19 00:05:17', '2023-01-26 20:08:16'),
(3, 'portada-06-12-2021-163880100561ae1e6de0631.jpg', 1, 999, NULL, 2, 1, '2021-12-06 14:30:05', '2023-01-26 20:08:16'),
(7, 'whatsapp-image-2023-03-11-at-19-13-03-2023-1678737610640f80ca4de49.jpeg', 1, 999, NULL, 4, NULL, '2023-03-13 20:00:10', '2023-03-13 20:00:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `smtp`
--

CREATE TABLE `smtp` (
  `smtp_id` int(11) NOT NULL,
  `smtp_host` varchar(200) DEFAULT NULL,
  `smtp_email` varchar(200) DEFAULT NULL,
  `smtp_pass` varchar(200) DEFAULT NULL,
  `smtp_port` varchar(200) DEFAULT NULL,
  `smtp_secure` varchar(200) DEFAULT NULL,
  `smtp_nome` varchar(200) DEFAULT NULL,
  `smtp_imob_id` int(11) DEFAULT NULL,
  `smtp_created` timestamp NULL DEFAULT current_timestamp(),
  `smtp_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `smtp`
--

INSERT INTO `smtp` (`smtp_id`, `smtp_host`, `smtp_email`, `smtp_pass`, `smtp_port`, `smtp_secure`, `smtp_nome`, `smtp_imob_id`, `smtp_created`, `smtp_updated`) VALUES
(1, 'host.com.br', 'email@host.com.br', '123senha', '587', '1', 'Teste', 1, '2021-10-04 22:05:58', '2023-01-26 20:08:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `uf`
--

CREATE TABLE `uf` (
  `uf_id` int(11) NOT NULL,
  `uf_estado` varchar(32) DEFAULT NULL,
  `uf_sigla` varchar(2) DEFAULT NULL,
  `uf_imob_id` int(11) DEFAULT NULL,
  `uf_created` timestamp NULL DEFAULT current_timestamp(),
  `uf_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `uf`
--

INSERT INTO `uf` (`uf_id`, `uf_estado`, `uf_sigla`, `uf_imob_id`, `uf_created`, `uf_updated`) VALUES
(1, 'Acre', 'AC', 1, '2021-10-04 22:05:50', '2023-01-26 20:08:16'),
(2, 'Alagoas', 'AL', 1, '2021-10-04 22:05:50', '2023-01-26 20:08:16'),
(3, 'Amapá', 'AP', 1, '2021-10-04 22:05:50', '2023-01-26 20:08:16'),
(4, 'Amazonas', 'AM', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(5, 'Bahia', 'BA', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(6, 'Ceará', 'CE', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(7, 'Distrito Federal', 'DF', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(8, 'Espirito Santo', 'ES', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(9, 'Goiás', 'GO', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(10, 'Maranhão', 'MA', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(11, 'Mato Grosso', 'MT', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(12, 'Mato Grosso do Sul', 'MS', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(13, 'Minas Gerais', 'MG', 1, '2021-10-04 22:05:51', '2023-01-26 20:08:16'),
(14, 'Pará', 'PA', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(15, 'Paraíba', 'PB', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(16, 'Paraná', 'PR', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(17, 'Pernambuco', 'PE', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(18, 'Piauí', 'PI', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(19, 'Rio de Janeiro', 'RJ', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(20, 'Rio Grande do Norte', 'RN', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(21, 'Rio Grande do Sul', 'RS', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(22, 'Rondônia', 'RO', 1, '2021-10-04 22:05:52', '2023-01-26 20:08:16'),
(23, 'Roraima', 'RR', 1, '2021-10-04 22:05:53', '2023-01-26 20:08:16'),
(24, 'Santa Catarina', 'SC', 1, '2021-10-04 22:05:53', '2023-01-26 20:08:16'),
(25, 'São Paulo', 'SP', 1, '2021-10-04 22:05:53', '2023-01-26 20:08:16'),
(26, 'Sergipe', 'SE', 1, '2021-10-04 22:05:53', '2023-01-26 20:08:16'),
(27, 'Tocantins', 'TO', 1, '2021-10-04 22:05:53', '2023-01-26 20:08:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nome` varchar(200) DEFAULT NULL,
  `usuario_telefone` varchar(20) DEFAULT NULL,
  `usuario_email` varchar(255) DEFAULT NULL,
  `usuario_pass` varchar(255) DEFAULT NULL,
  `usuario_avatar` varchar(255) DEFAULT NULL,
  `usuario_token` varchar(200) DEFAULT NULL,
  `usuario_level` int(11) DEFAULT 1,
  `usuario_status` int(11) DEFAULT 1,
  `usuario_imob_id` int(11) DEFAULT NULL,
  `usuario_created` timestamp NULL DEFAULT current_timestamp(),
  `usuario_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nome`, `usuario_telefone`, `usuario_email`, `usuario_pass`, `usuario_avatar`, `usuario_token`, `usuario_level`, `usuario_status`, `usuario_imob_id`, `usuario_created`, `usuario_updated`) VALUES
(1, 'Admin', NULL, 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '', NULL, 1, 1, 1, '2021-10-04 22:06:00', '2023-03-14 02:21:24'),
(3, 'aeaea', NULL, 'aeae@amkmae.com', '', NULL, NULL, 1, 1, NULL, '2023-03-13 19:54:28', '2023-03-13 19:54:38');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`agenda_id`);

--
-- Índices para tabela `atributo`
--
ALTER TABLE `atributo`
  ADD PRIMARY KEY (`atributo_id`);

--
-- Índices para tabela `atributo_imovel`
--
ALTER TABLE `atributo_imovel`
  ADD PRIMARY KEY (`atributo_imovel_id`);

--
-- Índices para tabela `avaliacao_imovel`
--
ALTER TABLE `avaliacao_imovel`
  ADD PRIMARY KEY (`avaliacao_imovel_id`);

--
-- Índices para tabela `bairro`
--
ALTER TABLE `bairro`
  ADD PRIMARY KEY (`bairro_id`);

--
-- Índices para tabela `caracteristica`
--
ALTER TABLE `caracteristica`
  ADD PRIMARY KEY (`caracteristica_id`);

--
-- Índices para tabela `caracteristica_categoria`
--
ALTER TABLE `caracteristica_categoria`
  ADD PRIMARY KEY (`caracteristica_categoria_id`);

--
-- Índices para tabela `categoria_imovel`
--
ALTER TABLE `categoria_imovel`
  ADD PRIMARY KEY (`categoria_imovel_id`);

--
-- Índices para tabela `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`cidade_id`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Índices para tabela `condominio`
--
ALTER TABLE `condominio`
  ADD PRIMARY KEY (`condominio_id`);

--
-- Índices para tabela `condominio_caracteristica`
--
ALTER TABLE `condominio_caracteristica`
  ADD PRIMARY KEY (`condominio_caracteristica_id`);

--
-- Índices para tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`config_id`);

--
-- Índices para tabela `config_cores`
--
ALTER TABLE `config_cores`
  ADD PRIMARY KEY (`config_cores_id`);

--
-- Índices para tabela `foto_imovel`
--
ALTER TABLE `foto_imovel`
  ADD PRIMARY KEY (`foto_imovel_id`);

--
-- Índices para tabela `imoveis_relacionados`
--
ALTER TABLE `imoveis_relacionados`
  ADD PRIMARY KEY (`imoveis_relacionados_id`);

--
-- Índices para tabela `imovel`
--
ALTER TABLE `imovel`
  ADD PRIMARY KEY (`imovel_id`);

--
-- Índices para tabela `imovel_caracteristica`
--
ALTER TABLE `imovel_caracteristica`
  ADD PRIMARY KEY (`imovel_caracteristica_id`);

--
-- Índices para tabela `modelo_imovel`
--
ALTER TABLE `modelo_imovel`
  ADD PRIMARY KEY (`modelo_imovel_id`);

--
-- Índices para tabela `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`newsletter_id`);

--
-- Índices para tabela `order_home`
--
ALTER TABLE `order_home`
  ADD PRIMARY KEY (`order_home_id`);

--
-- Índices para tabela `parceiro`
--
ALTER TABLE `parceiro`
  ADD PRIMARY KEY (`parceiro_id`);

--
-- Índices para tabela `rede_social`
--
ALTER TABLE `rede_social`
  ADD PRIMARY KEY (`rede_social_id`);

--
-- Índices para tabela `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`slide_id`);

--
-- Índices para tabela `smtp`
--
ALTER TABLE `smtp`
  ADD PRIMARY KEY (`smtp_id`);

--
-- Índices para tabela `uf`
--
ALTER TABLE `uf`
  ADD PRIMARY KEY (`uf_id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `agenda_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `atributo`
--
ALTER TABLE `atributo`
  MODIFY `atributo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `atributo_imovel`
--
ALTER TABLE `atributo_imovel`
  MODIFY `atributo_imovel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `avaliacao_imovel`
--
ALTER TABLE `avaliacao_imovel`
  MODIFY `avaliacao_imovel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `bairro`
--
ALTER TABLE `bairro`
  MODIFY `bairro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `caracteristica`
--
ALTER TABLE `caracteristica`
  MODIFY `caracteristica_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `caracteristica_categoria`
--
ALTER TABLE `caracteristica_categoria`
  MODIFY `caracteristica_categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `categoria_imovel`
--
ALTER TABLE `categoria_imovel`
  MODIFY `categoria_imovel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `cidade`
--
ALTER TABLE `cidade`
  MODIFY `cidade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `condominio`
--
ALTER TABLE `condominio`
  MODIFY `condominio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `condominio_caracteristica`
--
ALTER TABLE `condominio_caracteristica`
  MODIFY `condominio_caracteristica_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `config_cores`
--
ALTER TABLE `config_cores`
  MODIFY `config_cores_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `foto_imovel`
--
ALTER TABLE `foto_imovel`
  MODIFY `foto_imovel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `imoveis_relacionados`
--
ALTER TABLE `imoveis_relacionados`
  MODIFY `imoveis_relacionados_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `imovel`
--
ALTER TABLE `imovel`
  MODIFY `imovel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `imovel_caracteristica`
--
ALTER TABLE `imovel_caracteristica`
  MODIFY `imovel_caracteristica_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `modelo_imovel`
--
ALTER TABLE `modelo_imovel`
  MODIFY `modelo_imovel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `order_home`
--
ALTER TABLE `order_home`
  MODIFY `order_home_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `parceiro`
--
ALTER TABLE `parceiro`
  MODIFY `parceiro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `rede_social`
--
ALTER TABLE `rede_social`
  MODIFY `rede_social_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `slide`
--
ALTER TABLE `slide`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `smtp`
--
ALTER TABLE `smtp`
  MODIFY `smtp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `uf`
--
ALTER TABLE `uf`
  MODIFY `uf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
