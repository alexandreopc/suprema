Sistema em PHP para cadastrar pessoas e seus telefones 

Para executar o back-end, antes de tudo é preciso trocar duas variaveis locais do 'arquivo db.php', sendo elas 'usuario' e 'senha'. 
As mudancas sao necessárias para configurar o projeto com o banco local Postgres. (A depender da sua configuracao de banco, outras variaveis podem mudar)

Comandos para criar a database e as tabelas:

CREATE DATABASE desafioPHP;

CREATE TABLE pessoa(
id SERIAL PRIMARY KEY,
"nome" TEXT NOT NULL,
"cpf" TEXT NOT NULL,
"rg" TEXT NOT NULL,
"cep" TEXT NOT NULL,
"logradouro" TEXT NOT NULL,
"complemento" TEXT NOT NULL,
"setor" TEXT NOT NULL,
"cidade" TEXT NOT NULL,
"uf" TEXT NOT NULL
);

CREATE TABLE telefones(
id SERIAL PRIMARY KEY,
"pessoaId" INTEGER NOT NULL REFERENCES "pessoa"("id"),
"numero" TEXT NOT NULL,
"descricao" TEXT NOT NULL
);



Foi utilizado o XAMPP para rodar o servidor localmente no windows, se for o caso, sera necessário a seguinte configuraçãos:
-> No local de intalacao do programa ( xampp\apache\conf\httpd.conf ) modificar as seguintes variaveis do arquivo 'httpd.con' com o endereço do projeto:
      DocumentRoot "D:\Projetos\suprema\back-end"
      <Directory "D:\Projetos\suprema\back-end">
Assim, tornadno possivel acessar o back-end pelo endereco 'localhost/'

Para rodar o front-end, são necessários dois comandos:
-> npm i (instala modulos e dependecias do projeto)
-> npm start (inicia o projeto)

