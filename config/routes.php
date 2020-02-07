<?php

use Alura\Cursos\Controller\FormularioInsercao;
use Alura\Cursos\Controller\ListarCursos;
use Alura\Cursos\Controller\FormularioLogin;
use Alura\Cursos\Controller\RealizarLogin;
use Alura\Cursos\Controller\Persistencia;
use Alura\Cursos\Controller\FormularioEdicao;


$rotas = [
    '/novo-curso' => FormularioInsercao::class,
    '/listar-cursos' => ListarCursos::class,
    '/login' => FormularioLogin::class,
    '/realiza-login' => RealizarLogin::class,
    '/salvar-curso' => Persistencia::class,
    '/alterar-curso' => FormularioEdicao::class,


];

return $rotas;

