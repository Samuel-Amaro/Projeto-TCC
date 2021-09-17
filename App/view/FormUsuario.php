<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de cadastro do usuário</title>
    <meta name="description" content="Pagina de cadastro para novos usuarios serem permitidos de usarem o sistema.">
    <meta name="keywords" content="Cadastro, Central Cestas, Pagina Cadastro, Cadastrar Usuario">
    <meta name="author" content="Samuel Amaro">
    <link rel="stylesheet" href="../../Public/css/estilo_form_usuario.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <script type="text/javascript" src="../../Public/scripts/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript" src="../../Public/scripts/jquery.maskedinput-1.1.4.pack.js"></script>
</head>
<body>
    <main class="content">
        <div class="flex-container">
            <header class="conteiner-description">
                <div class="conteiner-h2">
                    <h2>Criar conta usuário</h2>
                </div>
                <div class="conteiner-p">
                    <p>Ao cadastrar um novo usuário se atente ao tipo de usuário que estará cadastrando isso poderá dar permissões que você não queira a pessoas não confiáveis.</p>
                </div>
            </header>
            <form action="" method="POST" name="form_usuario" id="form_usuario" title="Formulario de cadastro de um novo usuario" enctype="multipart/form-data" accept-charset="utf8" autocomplete="on">
                <input type="hidden" name="operacao" value="cadastro">
                <div class="container-row-not-flex">
                    <label for="nome" id="labels">Nome Completo</label>
                    <input type="text" name="nome" id="nome" title="Informe seu nome completo" required placeholder="Informe seu nome completo" maxlength="70">
                    <span class="limit-char"></span>
                </div>
                <div class="linha-grupo-label">
                    <label for="cpf" class="labels-flex-group-1">CPF</label>
                    <label for="celular" class="labels-flex-group-1">Telefone Pessoal</label>
                </div>
                <div class="linha-grupo-inputs">
                    <input type="text" name="cpf" id="cpf" class="primeiro-input" title="Informe somente os numeros de seu cpf" required placeholder="Informe Seu cpf somente numeros">
                    <input type="text" name="telefone" id="telefone" class="segundo-input" required title="Informe somente os numeros de seu telefone, incluindo DD" placeholder="Informe seu telefone somente numeros" maxlength="15">
                </div>
                <div class="linha-grupo-label">
                    <label for="email" id="labels-flex">Email Pessoal</label>
                    <label for="cargo" id="labels-flex">Cargo ou Função</label>
                </div>
                <div class="linha-grupo-inputs">
                    <input type="email" name="email" id="email" class="primeiro-input" title="Informe seu email pessoal por favor" required placeholder="Informe seu email email@dominio.com">
                    <input type="text" name="cargo" id="cargo" class="segundo-input" title="Informe o cargo ou função que você exerce dentro da instituição" required placeholder="Informe cargo ou função" maxlength="100">
                </div>
                <div class="linha-grupo-label">
                    <label for="tipo" id="labels-flex">Tipo usuário</label>
                    <label for="senha" id="labels-flex">Senha</label>
                </div>
                <div class="linha-grupo-inputs">
                    <select name="tipo" id="tipo" required title="Escolha o tipo de perfil de usuário que satisfará o objetivo do usuário em utilizar o sistema, lembre-se de acordo com o tipo de usuário existem funcionalidades no sistema que certos perfis não poderão utilizar.
                    " class="primeiro-input">
                        <option value="adm">Administrador</option>
                        <option value="comun">Comun</option>
                    </select>
                    <input type="password" name="senha" id="senha" required title="Informe uma senha válida entre 6 a 12 caracteres válidos." class="segundo-input" placeholder="Informe uma senha" minlength="6" maxlength="12">
                </div>
                <div class="conteiner-buttons">
                    <a href="PainelControle.php" target="_self" rel="next" id="link"> <i class="fas fa-arrow-left"></i> Voltar</a>
                    <input type="submit" value="Cadastrar" id="button">
                </div>
            </form>
        </div>
    </main>
    <div class="conteiner-modal">
            <div class="conteiner-header-modal alert-success alert-warning">
                <h3 class="titulo-modal"></h3>
            </div>
            <div class="modal-content alert-success alert-warning">
                <span class="close">&times;</span>
                <p class="msg-content"></p>
            </div>
            <div class="conteiner-footer-modal alert-success alert-warning">
                <a href="#" id="button-1-modal" target="_self" rel="next"></a>
                <a href="#" target="_self" rel="next" id="button-2-modal"></a>
            </div>
    </div>
    <script src="../../Public/scripts/form-usuario.js"></script>
</body>
</html>