create database biblioteca;
use biblioteca;

CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome_usuario VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,  
    senha VARCHAR(50) NOT NULL,
    img_url VARCHAR(255) DEFAULT "../imgs/default/default.png",
    coins INT NOT NULL DEFAULT 3000,
    nivel INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS livros (
    id_livro INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    autores TEXT NOT NULL,
    preco int NOT NULL,
    capa VARCHAR(200) DEFAULT "../imgs/default/sem_capa.jpg",
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id_categoria)
);

CREATE TABLE IF NOT EXISTS categoria (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nome_categoria VARCHAR(100) DEFAULT "outros",
    qtd_livros INT
);

INSERT INTO categoria (nome_categoria, qtd_livros) VALUES
    ('Ficção Científica e Fantasia', 0),
    ('Mistério e Suspense', 0),
    ('Romance Histórico', 0),
    ('Ciência e Tecnologia', 0),
    ('Desenvolvimento pessoal', 0),
    ('Outros', 0);

create table mensagens(
id_mensagem int primary key auto_increment,
usuario_id int, 
texto VARCHAR(255),
data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (usuario_id) REFERENCES usuario(id_usuario)
);

INSERT INTO livros (titulo, autores, preco, capa, categoria_id) VALUES
    ('Duna', 'Frank Herbert', 299, '../imgs/books/livro_1.jpg', 1),
    ('A Batalha do Labirinto', 'Rick Riordan', 209, '../imgs/books/livro_10.jpg', 1),
    ('O Código Da Vinci', 'Dan Brown', 249, '../imgs/books/livro_11.jpg', 2),
    ('Os Homens que Não Amavam as Mulheres', 'Stieg Larsson', 269, '../imgs/books/livro_12.jpg', 2),
    ('Sherlock Holmes', 'Arthur Conan Doyle', 189, '../imgs/books/livro_13.jpg', 2),
    ('Harry Potter e a Saga Inteira', 'J.K. Rowling', 999, '../imgs/books/livro_25.jpg', 1),
    ('O Poder do Agora', 'Eckhart Tolle', 219, '../imgs/books/livro_18.jpg', 5),  
    ('Tolkien', 'Autor Desconhecido', 299, '../imgs/books/livro_2.jpg', 1),
    ('O Pintassilgo', 'Donna Tartt', 299, '../imgs/books/livro_20.jpg', 1),
    ('Neuromancer', 'William Gibson', 229, '../imgs/books/livro_3.jpg', 1),
    ('O Guia do Mochileiro das Galáxias', 'Douglas Adams', 199, '../imgs/books/livro_4.jpg', 1),
    ('Cem Anos de Solidão', 'Gabriel García Márquez', 279, '../imgs/books/livro_5.jpg', 1),
    ('A Mão Esquerda da Escuridão', 'Ursula K. Le Guin', 239, '../imgs/books/livro_6.jpg', 1),
    ('Fahrenheit 451', 'Ray Bradbury', 219, '../imgs/books/livro_7.jpg', 1),
    ('Fundação e Império', 'Isaac Asimov', 359, '../imgs/books/livro_9.jpg', 1);

CREATE TABLE carrinho_compras (
    id_carrinho INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_livro INT,
    quantidade INT,
    preco_unitario DECIMAL(10, 2),
    data_adicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_livro) REFERENCES livros(id_livro)
);

CREATE TABLE IF NOT EXISTS compras (
    id_compra INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_livro INT,
    quantidade INT,
    preco_total DECIMAL(10, 2),
    data_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_livro) REFERENCES livros(id_livro)
);


INSERT INTO usuario (nome_usuario, email, senha, nivel)
VALUES ('Admin', 'admin@example.com', 'senha_admin', 1);

/* Pode utilizar esse insert para ser admin do site! Terá acesso a alguns recursos escondidos que alguns só podem ser acessado pela url! (maioria da pasta src!) */
