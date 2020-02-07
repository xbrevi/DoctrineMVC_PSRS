<?php

namespace Alura\Cursos\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Alura\Cursos\Entity\Curso;

use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;

class FormularioEdicao implements RequestHandlerInterface
{

    use RenderizadorDeHtmlTrait; 
    private EntityManager $entityManager;
    private ObjectRepository $repositorioCursos;

    public function __construct(EntityManager $entity)
    {
        $this->entityManager = $entity;
        $this->repositorioCursos = $this->entityManager->getRepository(Curso::class);
    }    

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        
        $queryString = $request->getQueryParams();
        $id = $queryString['id'];

        if (is_null($id) || $id === false) {
            return new Response(302, ['Location' => '/listar-cursos']);
        }
        
        $curso = $this->repositorioCursos->find($id);

        $html = $this->renderizaHtml('cursos/formulario.php', [
            'curso' => $curso,
            'titulo' => 'Alterar Curso '
        ]);

        return new Response(200, [], $html);
        
    }

}