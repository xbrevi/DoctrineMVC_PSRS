<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;
use Alura\Cursos\Entity\Curso;
use Doctrine\ORM\EntityManager;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;

class ListarCursos implements RequestHandlerInterface
{

    use RenderizadorDeHtmlTrait;

    private EntityManager $entityManager;
    private $repositorioDeCursos;

    public function __construct(EntityManager $entity)
    {
        $this->entityManager = $entity;   
        $this->repositorioDeCursos = $this->entityManager->getRepository(Curso::class); 
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->renderizaHtml('cursos/listar-cursos.php', [
            'cursos' => $this->repositorioDeCursos->findAll(),
            'titulo' => 'Lista de cursos'
        ]);

        return new Response(200, [], $html);
    }

}