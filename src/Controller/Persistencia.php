<?php

namespace Alura\Cursos\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Alura\Cursos\Entity\Curso;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Alura\Cursos\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;

class Persistencia implements RequestHandlerInterface
{

    use FlashMessageTrait;

    private EntityManager $entityManager;
    private ObjectRepository $curso;

    public function __construct(EntityManager $entity)
    {
        $this->entityManager = $entity;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {

        $descricao = filter_var(
            $request->getParsedBody()['descricao'],
            FILTER_SANITIZE_STRING
        );    
    
        $curso = new Curso();
        $curso->setDescricao($descricao);

        $queryString = $request->getQueryParams();
        $id = $queryString['id'];

        if (!is_null($id) && $id !== false) {
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $this->defineMensagem('success', 'Curso alterado com sucesso!');
        } else {
            $this->entityManager->persist($curso);
            $this->defineMensagem('success', 'Curso cadastrado com sucesso!');
        }    

        $this->entityManager->flush();
        
        return new Response(302, ['Location' => '/listar-cursos']);

    }


}