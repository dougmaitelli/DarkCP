-- 
-- Estrutura da tabela `_config`
-- 

CREATE TABLE `{prefix}_config` (
  `Id` int(1) NOT NULL,
  `Laynome` varchar(100) NOT NULL default '',
  `Fuso` varchar(3) NOT NULL,
  `Local` varchar(100) NOT NULL,
  `Manutencao` int(1) NOT NULL default '0',
  `Cookienome` varchar(100) NOT NULL default '',
  `Cookietempo` bigint(100) NOT NULL default '0',
  `Cookieseguro` int(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `_eventos`
-- 

CREATE TABLE `{prefix}_eventos` (
  `Id` bigint(100) NOT NULL auto_increment,
  `Nome` varchar(100) NOT NULL default '',
  `Descricao` text NOT NULL,
  `Iniciod` int(2) NOT NULL default '0',
  `Fimd` int(2) default NULL,
  `Iniciom` int(2) NOT NULL default '0',
  `Inicioy` int(4) default NULL,
  `Fimm` int(2) default NULL,
  `Fimy` int(4) default NULL,
  `Allyear` int(1) NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Id` (`Id`),
  FULLTEXT KEY `Descricao` (`Descricao`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `_news`
-- 

CREATE TABLE `{prefix}_news` (
  `Id` bigint(100) NOT NULL auto_increment,
  `Nome` varchar(100) NOT NULL default '',
  `News` text NOT NULL,
  `Data` varchar(100) NOT NULL default '',
  `User` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Id` (`Id`),
  FULLTEXT KEY `News` (`News`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `_parcerias`
-- 

CREATE TABLE `{prefix}_parcerias` (
  `Id` bigint(100) NOT NULL auto_increment,
  `Nome` varchar(100) NOT NULL,
  `Link` varchar(100) NOT NULL,
  `Categoria` varchar(100) NOT NULL,
  `Descricao` text NOT NULL,
  `Banner` varchar(100) NOT NULL,
  PRIMARY KEY  (`Id`),
  FULLTEXT KEY `Descricao` (`Descricao`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `_projetos`
-- 

CREATE TABLE `{prefix}_projetos` (
  `Id` bigint(100) NOT NULL auto_increment,
  `Nome` varchar(100) NOT NULL default '',
  `Equipe` text NOT NULL,
  `Descricao` text NOT NULL,
  `Porcentagem` int(100) NOT NULL default '0',
  `Lancamento` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Id` (`Id`),
  FULLTEXT KEY `Equipe` (`Equipe`),
  FULLTEXT KEY `Descricao` (`Descricao`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `_users`
-- 

CREATE TABLE `{prefix}_users` (
  `Id` bigint(100) NOT NULL auto_increment,
  `Nome` varchar(100) NOT NULL default '',
  `Usuario` varchar(100) NOT NULL default '',
  `Password` varchar(100) NOT NULL default '',
  `Email` varchar(100) NOT NULL default '',
  `Autlvl` int(1) NOT NULL default '0',
  `Foto` varchar(100) NOT NULL default '',
  `Ip` varchar(100) NOT NULL default '',
  `Dia` int(2) default NULL,
  `Mes` int(2) default NULL,
  `Ano` int(4) default NULL,
  `Ativo` varchar(100) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `_enquetes`
-- 

CREATE TABLE `{prefix}_enquetes` (
  `Id` bigint(100) NOT NULL auto_increment,
  `Pergunta` varchar(100) NOT NULL,
  `Resp1` varchar(100) NOT NULL,
  `Resp2` varchar(100) NOT NULL,
  `Resp3` varchar(100) NOT NULL,
  `Resp4` varchar(100) NOT NULL,
  `Resp5` varchar(100) NOT NULL,
  `Num1` varchar(100) NOT NULL,
  `Num2` varchar(100) NOT NULL,
  `Num3` varchar(100) NOT NULL,
  `Num4` varchar(100) NOT NULL,
  `Num5` varchar(100) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `_contato`
-- 

CREATE TABLE `{prefix}_contato` (
  `Id` bigint(100) NOT NULL auto_increment,
  `Assunto` varchar(100) NOT NULL,
  `Texto` text NOT NULL,
  `Data` varchar(100) NOT NULL,
  `User` varchar(100) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Id` (`Id`),
  FULLTEXT KEY `Texto` (`Texto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

