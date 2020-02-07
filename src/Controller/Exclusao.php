<?php 

namespace Alura\Cursos\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMessageTrait;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;

class Exclusao implements RequestHandlerInterface
{

    use FlashMessageTrait;

     /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryString = $request->getQueryParams();
        $idEntidade = filter_var(
            $queryString['id'], 
            FILTER_VALIDATE_INT
        );    
        
        $entidade = $this->entityManager->getReference(Curso::class, $idEntidade);
        $this->entityManager->remove($entidade);
        $this->entityManager->flush();

        $this->defineMensagem('success', 'Curso excluído com sucesso!');

        return new Response(302, ['Location' => '/listar-cursos']);

    }

}



