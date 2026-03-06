<h2 class="h3">Solicitações de novos usuários</h2>
<div class="p-3">
    <div class="row">

        <?php
        $usuarios = read_usuario(array('ativo'=>0));
        if($usuarios->num_rows > 0){
            foreach($usuarios as $usuario):
            $avatar = read_avatar($usuario['id']);

        ?>

        <div class="col-12 col-lg-6 p-1">
            <div class="bg-white h-100 border rounded p-1">
                <div class="row m-0 usuario">
                    <div class="col-12 p-0">
                        <div class="bg-white p-3">
                            <img src="/uploads/fotos/<?php echo $avatar;?>" width="60px" height="60px" class="rounded-circle mr-3">
                            <h3 class="h5 d-inline-block"><a href="/equipe/<?php echo $usuario['slug'];?>" target="_blank" class="text-dark"><?php echo substr($usuario['nome'], 0,20);?></a>...
                                <div class="pt-2 small text-capitalize <?php $cor = ($usuario['perfil'] == 'visitante')? 'text-warning': 'text-dark'; echo $cor; ?>">
                                    <i class="material-icons align-middle"> stars </i> <?php echo $usuario['perfil'];?>
                                </div>
                            </h3>
                        </div>
                    </div>
                    <div class="col-12 p-0 border-top mb-1 mt-1"></div>
                    <div class="col-12 col-sm-4 p-1">
                        <a href="javascript:void(0)" 
                           data-id-usuario="<?php echo $usuario['id'];?>"
                           data-email="<?php echo $usuario['email'];?>"
                           class="btn btn-block btn-sm text-white bg-success aceita">
                            <i class="material-icons align-middle"> check </i> Aceitar
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 p-1">
                        <a href="/admin/usuarios/apaga-usuario/<?php echo $usuario['id'];?>/" class="btn btn-block btn-sm text-white bg-danger recusa">
                            <i class="material-icons align-middle"> close </i> Recusar
                        </a>
                    </div>
                    <div class="col-12 col-sm-4 p-1">
                        <a href="/admin/usuarios/edita-usuario/<?php echo $usuario['id'];?>/" class="btn btn-block btn-sm text-white bg-blue">
                            <i class="material-icons align-middle"> edit </i> Alterar
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>

        <?php
            endforeach;
        }else{
            echo '<p class="bg-green text-white p-3 w-100"><i class="material-icons align-middle mr-3"> check_circle </i> Não há pendências.</p>';
        }
        ?>

    </div>
</div>
