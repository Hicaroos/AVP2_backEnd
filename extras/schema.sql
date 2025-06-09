CREATE DATABASE IF NOT EXISTS avp2;

USE avp2;

CREATE TABLE IF NOT EXISTS produtos(
	id VARCHAR(36) NOT NULL DEFAULT (UUID()) PRIMARY KEY UNIQUE,
    nome VARCHAR(64) NOT NULL,
    tipo VARCHAR(32),
    valor FLOAT NOT NULL
);

CREATE TABLE IF NOT EXISTS compras(
	id VARCHAR(36) NOT NULL DEFAULT (UUID()) PRIMARY KEY UNIQUE,
    idProduto VARCHAR(36) NOT NULL,
    valorEntrada FLOAT NOT NULL,
    qtdParcelas INT NOT NULL,
    FOREIGN KEY (idProduto) REFERENCES produtos(id),
    vlrParcela FLOAT,
    jurosAplicados FLOAT
);

create table if not exists juros(
	id int primary key auto_increment,
    dataInicial date,
    dataFinal date,
    juros float
);
