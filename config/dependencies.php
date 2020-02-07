<?php

use Alura\Cursos\Controller\FormularioEdicao;
use Alura\Cursos\Controller\FormularioInsercao;
use Alura\Cursos\Controller\FormularioLogin;
use Alura\Cursos\Controller\ListarCursos;
use Alura\Cursos\Controller\RealizarLogin;
use Alura\Cursos\Controller\Persistencia;

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Alura\Cursos\Infra\EntityManagerCreator;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([

    EntityManagerInterface::class => function() {
        return (new EntityManagerCreator())->getEntityManager();
    },

    ListarCursos::class => function() {
        return (new ListarCursos(
            $entity = (new EntityManagerCreator())->getEntityManager()));    
    },

    FormularioLogin::class => function() {
        return (new FormularioLogin());
    },
    
    RealizarLogin::class => function() {
        return (new RealizarLogin(
            $entity = (new EntityManagerCreator())->getEntityManager()));    
    },

    FormularioInsercao::class => function() {
        return new FormularioInsercao();
    },
    
    Persistencia::class => function () {
        return (new Persistencia(
            $entity = (new EntityManagerCreator())->getEntityManager()));    
    },

    FormularioEdicao::class => function () {
        return (new FormularioEdicao(
            $entity = (new EntityManagerCreator())->getEntityManager()));
    },
    
]);

return $containerBuilder->build();
