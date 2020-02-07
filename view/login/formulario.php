<?php include __DIR__ . '/../inicio-html.php'; ?>

    <form action="/realiza-login" method="post">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email">
        
    </div>
    <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" class="form-control" name="senha" id="senha">
    </div>

    <button type="submit" class="btn btn-primary">Entrar</button>
    </form>    

<?php include __DIR__ . '/../fim-html.php'; ?>