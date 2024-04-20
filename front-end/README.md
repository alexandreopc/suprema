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
