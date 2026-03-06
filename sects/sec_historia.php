<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');
?>

<!-- Conteúdo -->
<div class="bg-blue">
    <div class="container pt-5 pb-5 text-dark text-center">
        <div class="row align-items-center text-uppercase">
            <div class="col-12 col-md-6">
                <h2 class="h1 font-weight-light">Nossa história</h2>
            </div>
            <div class="col-12 col-md-6">
                <p class="h5 font-weight-light">Nesta seção você conhecerá a história do instituto.
                    São diversas fotos e vídeos contando um pouco da nossa história.</p>
            </div>
        </div>
    </div>
</div>
<div class="container pt-5">
    <div class="bg-white p-4">
        <h3 class="mb-3 pb-3 border-bottom">Histórico do Grupo</h3>
        <p>Quando começamos a estudar as adaptações dos peixes da Amazônia aos seus ambientes, de pronto percebemos a dimensão da empreitada. A cada análise, um vasto conjunto de perguntas surgia e cada pergunta poderia ser um projeto, como de fato foi em muitos casos. Diante desse cenário, concluímos ser fundamental montar um grupo de trabalho robusto que pudesse contribuir com a capacitação de estudantes em nível de pós-graduação.</p>

        <p>Envolvemo-nos, naquele momento, com um programa de pós-graduação relacionado à biologia aquática, e demos início a uma empreitada da qual nos orgulhamos muito: a formação de pessoal para a pesquisa científica na Amazônia. Valemo-nos das perguntas que nos desafiavam e junto com brilhantes estudantes que buscavam se capacitar em nível de mestrado e doutorado buscamos as respostas. Com as respostas novas perguntas. Novos estudantes - novas perguntas - novos estudantes.</p> 

        <p>Os estudantes graduados foram constituindo novos grupos de estudos em outras instituições, mantendo o elo com o grupo de trabalho que ia se fortalecendo. Redes de estudos foram formadas. A cooperação científica, vital para o avanço próprio da ciência, fortalecia-se tanto em nível nacional como internacional. Aprendemos muito com todos os estudantes e depois de mais de 30 anos nos demos conta de que a família cresceu e que deveríamos iniciar um conjunto de ações para reunir nossas ideias e tentar contribuir com a socialização do conhecimento gerado desde então.</p>

        <p>Resolvemos elaborar um portal com os diferentes projetos e dar acesso aos trabalhos e livros que elaboramos. Assim, neste portal, você poderá encontrar o registro de nossos colaboradores atuais e de quem já colaborou conosco por meio das centenas de documentos que produzimos e que podem ser consultados por meio desse portal eletrônico. Cada um de nós tem sua página e, se você se interessar, poderá até ser direcionado ao link de laboratórios/colaboradores no Brasil e no Exterior.</p>
    </div>
</div>

<?php
$pag = 
    '<script>
    var pag = $(".nossa-historia");
    if(!pag.hasClass("active")){
        pag.addClass("active");
    }
</script>';

include_once("include/inc_rodape.php");
?>
