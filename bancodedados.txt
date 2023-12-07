create database if not exists biblioteca;
use biblioteca;

create table usuario(
id_usuario int primary key auto_increment, 
nome_usuario varchar(255) not null,
email varchar(255) not null,  
senha varchar(50) not null,
img_url varchar(255) default "../imgs/default/default.png" null, 
coins int not null default 3000,
nivel int not null default 0
);

create table livros(
id_livro int primary key auto_increment,
titulo varchar(255) not null, 
autores varchar(255) not null, 
preco double(10, 2) not null, 
capa varchar(200) not null, 
categoria varchar(200) not null
);

insert into usuario(nome_usuairo, email, senha, img_url, coins, nivel) values ('Caique'. caique@gmail.com', 'caique230906@', default, 10000, 1);
insert into usuario(nome_usuario, email, senha, img_url, coins, nivel) values ('Ingrid', 'ingrid@gmail.com', '12321', default, 5000, 0);

