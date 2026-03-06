<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');
?>

<div class="text-center pt-3">
    <div class="container bg-white pt-3 pb-3">
        <section class="text-left">

            <?php
            //Verifica se a sessão está ativa
            if (sessao_ativa()) :
                $avatar = read_avatar($usuario_logado['id']);
            ?>

            <h2 class="text-center mb-3 border-bottom pb-3">Alteração do perfil</h2>
            <div class="row align-items-center">
                <div class="col-12 col-lg-8 m-auto h-100">
                    <form method="post" id="form_avatar" class="p-3">
                        <div class="form-row align-items-center">
                            <div class="col-12">
                                <div class="form-group text-center m-0">
                                    <button class="btn btn-sm bg-blue text-white position-absolute" type="button" id="btnVatar">
                                        <i class="material-icons align-middle"> photo </i>Alterar
                                    </button>
                                    <img src="/uploads/fotos/<?php echo $avatar; ?>" id="fotoPerfil" width="180" class="mb-3 border avatar rounded p-2 bg-white">
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <h1 class="h3 font-weight-normal">
                                    <?php echo $usuario['nome']; ?>
                                </h1>
                            </div>
                            <div class="input-group mb-3">
                                <div class="custom-file d-none">
                                    <input type="file" class="form-control border-blue" accept="image/jpeg" id="avatar" aria-describedby="btnFoto">
                                    <label class="custom-file-label" for="avatar">Escolha uma foto</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-lg-8 m-auto h-100">
                    <form method="post" id="form_perfil" class="p-3">
                        <div class="form-row">
                            <div class="border-bottom mb-3"></div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nome" class="h5">E-mail</label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $usuario['email']; ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-center">
                                    <div class="form-group">
                                        <div class="border">
                                            <label for="nome" class="h5 border-bottom pt-3 pb-3 mb-3 d-block">Fale um pouco sobre você</label>
                                            <textarea rows="6" class="form-control border-0" name="biografia" id="biografia" maxlength="1000" value="<?php echo $usuario['lattes']; ?>"><?php echo $usuario['biografia']; ?></textarea>
                                            <small>Máx.: 1000</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="lattes" class="font-weight-bold">Lattes</label>
                                    <input type="text" class="form-control form-control-sm" name="lattes" id="lattes" value="<?php echo $usuario['lattes']; ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="lattes" class="font-weight-bold">ResearchGate</label>
                                    <input type="text" class="form-control form-control-sm" name="research" id="research" value="<?php echo $usuario['research']; ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="lattes" class="font-weight-bold">Orcid</label>
                                    <input type="text" class="form-control form-control-sm" name="orcid" id="orcid" value="<?php echo $usuario['orcid']; ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="lattes" class="font-weight-bold">Mais</label>
                                    <input type="text" class="form-control form-control-sm" name="curriculo" id="curriculo" value="<?php echo $usuario['curriculo']; ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="instagram" class="font-weight-bold">Instagram</label>
                                    <input type="text" class="form-control form-control-sm" name="instagram" id="instagram" value="<?php echo $usuario['instagram']; ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="twitter" class="font-weight-bold">Twitter</label>
                                    <input type="text" class="form-control form-control-sm" name="twitter" id="twitter" value="<?php echo $usuario['twitter']; ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="facebook" class="font-weight-bold">Facebook</label>
                                    <input type="text" class="form-control form-control-sm" name="facebook" id="facebook" value="<?php echo $usuario['facebook']; ?>">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <a href="/equipe/<?php echo $usuario_logado['slug'];?>" class="btn btn-block bg-danger text-white ml-auto">Cancelar</a>
                            </div>
                            <div class="col-12 col-md-4">
                                <button type="button" class="btn btn-block bg-green" data-toggle="collapse" href="#collapseSenha" role="button" aria-expanded="false" aria-controls="collapseExample">Alterar senha</button>
                            </div>
                            <div class="col-12 col-md-4">
                                <button type="submit" class="btn btn-block bg-blue border-0 rounded text-white">Salvar alterações</button>
                            </div>
                        </div>
                    </form>

                    <div class="collapse rounded-lg" id="collapseSenha" style="background: #e5e8e7">
                        <form method="post" id="form_senha" class="p-3">
                            <div class="form-group">
                                <input type="hidden" name="email" value="<?php echo $usuario['email']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="token" value="<?php echo $usuario['senha']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="senha" class="h5">Digte abaixo sua nova senha</label>
                                <input type="password" class="form-control" name="senha" id="senha">
                            </div>
                            <div class="navbar p-0">
                                <button type="submit" class="btn bg-blue border-0 rounded text-white ml-auto">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            else :
                ?>

            <!-- Conteúdo -->
            <p class="alert alert-danger border-0">Você precisa entrar para acessar esta área.</p>

            <?php
            endif;
            ?>

    </div>

    <?php
    include_once("include/inc_rodape.php");
    ?>
