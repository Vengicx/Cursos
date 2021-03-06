-- MySQL Script generated by MySQL Workbench
-- Wed Feb  7 18:40:57 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `login` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `ativo` CHAR(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `professor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `professor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `foto` VARCHAR(45) NULL,
  `cargo` VARCHAR(100) NOT NULL,
  `curriculo` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `curso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `curso` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `resumo` VARCHAR(250) NOT NULL,
  `descricao` TEXT NOT NULL,
  `imagem` VARCHAR(45) NULL,
  `video` VARCHAR(150) NULL,
  `mensalidade` DOUBLE NOT NULL,
  `parcelas` INT NOT NULL,
  `ativo` CHAR(3) NOT NULL,
  `professor_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_curso_professor_idx` (`professor_id` ASC),
  INDEX `fk_curso_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_curso_professor`
    FOREIGN KEY (`professor_id`)
    REFERENCES `professor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curso_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aluno` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `foto` VARCHAR(45) NULL,
  `cpf` CHAR(14) NOT NULL,
  `datanascimento` VARCHAR(45) NULL,
  `email` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `celular` VARCHAR(16) NOT NULL,
  `ativo` CHAR(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `matricula`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `matricula` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `data` DATE NOT NULL,
  `ativo` CHAR(3) NULL,
  `curso_id` INT NOT NULL,
  `aluno_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_matricula_curso1_idx` (`curso_id` ASC),
  INDEX `fk_matricula_aluno1_idx` (`aluno_id` ASC),
  CONSTRAINT `fk_matricula_curso1`
    FOREIGN KEY (`curso_id`)
    REFERENCES `curso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matricula_aluno1`
    FOREIGN KEY (`aluno_id`)
    REFERENCES `aluno` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parcela`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parcela` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `datalancamento` DATE NOT NULL,
  `datavencimento` DATE NOT NULL,
  `datapagamento` DATE NULL,
  `valor` DOUBLE NOT NULL,
  `valorpago` DOUBLE NULL,
  `ativo` CHAR(3) NOT NULL,
  `matricula_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_parcela_matricula1_idx` (`matricula_id` ASC),
  CONSTRAINT `fk_parcela_matricula1`
    FOREIGN KEY (`matricula_id`)
    REFERENCES `matricula` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
