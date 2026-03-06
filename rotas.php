<?php
/////////////////////////////////
//Sitema de rotas da aplicação //
/////////////////////////////////
require_once __DIR__ . DIRECTORY_SEPARATOR . 'configs.php';

if(!isset($_REQUEST)){ retorna_json(false, 'Isto parece um erro.'); }

//Processa a rota definida pela ação do usuário na aplicação
if(isset($_REQUEST['rota'])){

    $rota = $_REQUEST['rota'];

    switch($rota){
        case 'entrada': //Prcessa a entrada do usuário na aplicação
            app_entrada($_REQUEST);
            break;

        case 'recupera': //Processa o envio de e-mail da recuperação de senha
            if(isset($_REQUEST['email'])){
                app_recupera($_REQUEST['email']);
            }
            break;

        case 'senha': //Processa alteração de senha do usuário
            if(isset($_REQUEST['email']) && isset($_REQUEST['senha'])){
                update_senha($_REQUEST);
            }
            break;

        case 'atualiza-avatar': //Processa alterações no avatar do usuário
            if(isset($_FILES)){
                update_avatar($_FILES);
            }
            break;

        case 'atualiza-perfil': //Processa alterações no perfil do usuário
            if(isset($_REQUEST)){
                update_perfil($_REQUEST);
            }
            break;

        case 'cria-pesquisa': //Adiciona nova pesquisa
            if(isset($_REQUEST) && isset($_FILES)){
                create_pesquisa($_REQUEST, $_FILES);
            }else{
                create_pesquisa($_REQUEST);
            }
            break;

        case 'edita-pesquisa': //Adiciona nova pesquisa
            if(isset($_REQUEST) && isset($_FILES)){
                update_pesquisa($_REQUEST, $_FILES);
            }else{
                update_pesquisa($_REQUEST);
            }
            break;

        case 'apaga-pesquisa': //Adiciona nova pesquisa
            if(isset($_REQUEST['slug'])){
                delete_pesquisa($_REQUEST['slug']);
            }
            break;

        case 'add-usuario-projeto': //Adiciona um usuário no projeto
            if(isset($_REQUEST)){
                create_usuario_projeto($_REQUEST);
            }
            break;

        case 'cria-usuario': //Cria usuário
            if(isset($_REQUEST)){
                create_usuario($_REQUEST);
            }
            break;

        case 'edita-usuario': //Edita usuário
            if(isset($_REQUEST)){
                update_usuario($_REQUEST);
            }
            break;

        case 'ativa-usuario': //Edita usuário
            if(isset($_REQUEST)){
                ativa_usuario($_REQUEST);
            }
            break;

        case 'apaga-usuario': //Apaga usuário
            if(isset($_REQUEST['id_usuario'])){
                delete_usuario($_REQUEST['id_usuario']);
            }
            break;

        case 'cria-imagem': //Cria imagem
            if(isset($_FILES['imagem'])){
                create_imagem($_FILES['imagem']);
            }
            break;

        case 'apaga-imagem': //Apaga imagem
            if(isset($_REQUEST['id_imagem'])){
                delete_imagem($_REQUEST['id_imagem']);
            }
            break;

        case 'cria-projeto': //Cria projeto
            if(isset($_REQUEST) && isset($_FILES['foto'])){
                create_projeto($_REQUEST, $_FILES['foto']);
            }
            break;

        case 'edita-projeto': //Projeto projeto
            if(isset($_REQUEST) && isset($_FILES['foto'])){
                update_projeto($_REQUEST, $_FILES['foto']);
            }
            break;

        case 'apaga-projeto': //Apaga projeto
            if(isset($_REQUEST['id_projeto'])){
                delete_projeto($_REQUEST['id_projeto']);
            }
            break;

        case 'cria-materia': //Cria materia
            if(isset($_REQUEST) && isset($_FILES)){
                create_materia($_REQUEST, $_FILES);
            }
            break;

        case 'apaga-materia': //Apaga materia
            if(isset($_REQUEST['id_materia'])){
                delete_materia($_REQUEST['id_materia']);
            }
            break;

        case 'edita-materia': //Apaga materia
            if(isset($_REQUEST) && isset($_FILES)){
                update_materia($_REQUEST, $_FILES);
            }
            
            break;

        case 'cria-video': //Cria video
            if(isset($_REQUEST)){
                create_video($_REQUEST);
            }
            break;

        case 'apaga-video': //Cria video
            if(isset($_REQUEST['id_video'])){
                delete_video($_REQUEST['id_video']);
            }
            break;

        case 'cria-cronograma': //Cria materia
            if(isset($_REQUEST)){
                create_cronograma($_REQUEST);
            }
            break;

        case 'edita-cronograma': //Cria materia
            if(isset($_REQUEST)){
                update_cronograma($_REQUEST);
            }
            break;

        case 'apaga-cronograma': //Cria materia
            if(isset($_REQUEST['id'])){
                delete_cronograma($_REQUEST['id']);
            }
            break;

        case 'cria-apoiador': //Cria destaque
            if(isset($_REQUEST['nome']) && isset($_FILES['foto'])){
                create_apoiador($_REQUEST['nome'], $_FILES['foto']);
            }
            break;

        case 'apaga-apoiador': //Apaga destaque
            if(isset($_REQUEST['id_apoiador'])){
                delete_apoiador($_REQUEST['id_apoiador']);
            }
            break;

        case 'reporta-bug': //Reporta bug
            if(isset($_REQUEST['bug'])){
                reporta_bug($_REQUEST);
            }
            break;

        case 'saida'://Processa o logout do usuário
            app_saida();
            break;

        default://Processa o retorno padrão para uma rota não definida
            retorna_json(false, 'Faltam informações');
            break;
    }

}else{
    retorna_json(false, 'Nada informado');
}
