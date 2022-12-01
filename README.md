<p align="center">
 <img src=".github/logo-tcc.png" alt="banner" />
</p>

<br />

## Conteúdo

- [Sobre](#sobre)
- [Tecnologias](#tecnologias)
- [Pré-requisitos](#pre-requisitos)
- [Como usar](#como-usar)
- [Como contibuir](#como-contribuir)

<a id="sobre"></a>

## :bookmark: Sobre

<strong>HealtData</strong> é uma API destinada para a área da sáude, onde integramos informações importantes entre as unidades como uma ficha integrada do paciente e também seu histórico médico, contendo informações importantes para a qualidade da consulta.
O objetivo é facilitar a comunicação entre os hospitais, fornecendo uma API REST de fácil consumo e de rápida implementação.
Como se trata de um projeto piloto, existem muitas contribuições e features que podem ser implementadas ou melhoradas, fique a vontade para contribuir com o projeto.

Documentação da API: https://documenter.getpostman.com/view/22793690/2s8Yt1qp9h

<a id="tecnologias-utilizadas"></a>

## :rocket: Tecnologias Utilizadas

O projeto foi desenvolvido utilizando as seguintes tecnologias

- [Laravel 7.30.6](https://laravel.com/docs/7.x/releases)
- [Mysql 8.0.31-0ubuntu0.22.04.1](https://www.mysql.com/)
- [PHP 7.4](https://www.php.net/)

<a id="pre-requisitos"></a>

## :fire: **Pré-requisitos**

- [Composer/version >= 2.4.2](https://getcomposer.org/)

<a id="como-usar"></a>

## :zap: Como usar

- Faça um clone desse repositório: 
`git clone https://github.com/Giovanni-786/health-data-api`

- Copie e cole o arquivo `.env.example` e renomeie para `.env` e insira as informações das variáveis:
    - DB_DATABASE -> nome do banco de dados criado
    - DB_USERNAME -> usuário do banco
    - DB_PASSWORD -> senha
- Rode o comando para instalação dos pacotes: `composer install`
- Rode o comando para criar as migrations: `php artisan migrate`
- Crie a chave do projeto: `php artisan key:generate`
- Inicie a aplicação: `php artisan serve`
 
 

<a id="como-contribuir"></a>

## :recycle: Como contribuir

- Faça um Fork desse repositório,
- Crie uma branch com a sua feature: `git checkout -b my-feature`
- Commit suas mudanças: `git commit -m 'feat: My new feature'`
- Push a sua branch: `git push origin my-feature`
---

<h4 align=center>Made with 💙 by <a href="https://www.linkedin.com/in/giovanni-sena/">Giovanni Lima</a></h4>
