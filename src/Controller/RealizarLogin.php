<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Helper\FlashMessageTrait;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Alura\Cursos\Entity\Usuario;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;


class RealizarLogin implements RequestHandlerInterface
{
    use FlashMessageTrait, RenderizadorDeHtmlTrait;

    private EntityManager $entityManager;
    private ObjectRepository $repositorioUsuarios;

    public function __construct(EntityManager $entity)
    {
        $this->entityManager = $entity;
        $this->repositorioUsuarios = $this->entityManager->getRepository(Usuario::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        // USUARIO: vinicius@alura.com.br // Senha = 123456    

        $dados = $request->getParsedBody();
        $email = filter_var($dados['email'], FILTER_VALIDATE_EMAIL);

        //ALTERNATIVA:
        /*
        $email = filter_var(
            $request->getParsedBody()['email'],
            FILTER_VALIDATE_EMAIL
        );
        */

        if (is_null($email) || $email === false) {
            $this->defineMensagem('danger', 'O e-mail digitado não é válido!');
            $html = $this->renderizaHtml('login/formulario.php', [
                'titulo' => 'Login',
            ]);
            return new Response(200, [], $html);
        }

        $senha = filter_var($dados['senha'], FILTER_SANITIZE_STRING); 

        /** @var  $usuario */
        $usuario = $this->repositorioUsuarios->findOneBy(['email' => $email]);
    
        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            $this->defineMensagem('danger', 'E-mail ou Senha inválidos');
            $html = $this->renderizaHtml('login/formulario.php', [
                'titulo' => 'Login',
            ]);
            return new Response(200, [], $html);    
        }

        $_SESSION['logado'] = true;
        $_SESSION['email'] = $email;
        return new Response(302, ['Location' => '/listar-cursos']);
    }        


}