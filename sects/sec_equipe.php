<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
include_once('include/inc_header.php');

/* ─────────────────────────────────────────────────────────────
   Helpers
───────────────────────────────────────────────────────────── */
function result_to_array($result) {
    $arr = [];
    if (!$result || $result->num_rows === 0) return $arr;
    while ($row = $result->fetch_assoc()) {
        $arr[] = $row;
    }
    return $arr;
}

function get_avatar_url($u) {
    $file = !empty($u['avatar']) ? $u['avatar'] : 'user-' . ($u['sexo'] ?? 'm') . '.png';
    return '/uploads/fotos/' . htmlspecialchars($file);
}

function render_user_cards($users) {
    echo '<div class="row row-cards">';
    foreach ($users as $i => $u) {
        $nome = htmlspecialchars($u['nome']);
        $bio  = !empty($u['biografia']) ? strip_tags($u['biografia']) : '';
        if (strlen($bio) > 100) $bio = mb_substr($bio, 0, 100) . '...';
        if (empty($bio)) $bio = 'Sem biografia.';

        $link = '/index.php/equipe/' . htmlspecialchars($u['slug']) . '/';
        $tipo = ucfirst($u['perfil'] ?? 'Membro');

        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 fade-in-up">';
        echo '<div class="card-noticia">'; 
        
        // Image Wrap matching Home
        $is_default = empty($u['avatar']);
        $img_class  = $is_default ? 'default-avatar' : '';
        
        echo '<div class="card-img-wrap" data-tipo="' . htmlspecialchars($tipo) . '">';
        echo '<a href="' . $link . '">';
        echo '<img src="' . get_avatar_url($u) . '" alt="' . $nome . '" class="' . $img_class . '" loading="lazy">';
        echo '</a>';
        echo '<span class="card-tipo">' . htmlspecialchars($tipo) . '</span>';
        echo '</div>';

        echo '<div class="card-body">';
        echo '<h3 class="card-title"><a href="' . $link . '">' . $nome . '</a></h3>';
        echo '<p class="card-excerpt">' . $bio . '</p>';
        echo '<a href="' . $link . '" class="card-link">Ver perfil <span class="arrow">&#8594;</span></a>';
        echo '</div>';
        
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

function render_load_more($name, $current_val, $label) {
     echo '<div class="text-center mt-5 mb-5 fade-in-up">';
     echo '<form method="post" style="display:inline;">';
     echo '<input type="hidden" name="' . $name . '" value="' . ($current_val + 12) . '">';
     echo '<button type="submit" class="btn btn-outline-dark px-4 py-2 rounded-pill shadow-sm">';
     echo '<i class="material-icons align-middle mr-1">add</i> ' . $label;
     echo '</button></form></div>';
}
?>

<!-- Header Section -->
<div class="bg-blue">
    <div class="container pt-5 pb-5 text-dark text-center">
        <div class="row align-items-center">
            <div class="col-12 col-md-8 offset-md-2">
                <h1 class="display-4 font-weight-bold mb-3">Quem somos</h1>
                <p class="lead">Conheça nossos colaboradores atuais e parceiros que fazem parte da nossa história.</p>
            </div>
        </div>
    </div>
</div>

<div class="container pt-5 pb-5">

    <!-- Visitantes & Parceiros (Grid) -->
    <?php
    $visitantes = result_to_array(read_usuario(['perfil' => 'visitante', 'limit' => 50]));
    if (!empty($visitantes)) :
    ?>
    <div class="mb-5 fade-in-up">
        <h3 class="h4 mb-4 pb-2 border-bottom border-secondary">Visitantes & Parceiros</h3>
        <?php render_user_cards($visitantes); ?>
    </div>
    <?php endif; ?>


    <!-- Equipe Principal (Grid) -->
    <div class="mb-5">
        <h3 class="h4 mb-4 pb-2 border-bottom border-secondary">Nossa Equipe</h3>
        <?php
        $count = isset($_REQUEST['count']) ? (int)$_REQUEST['count'] : 12;
        $equipe = result_to_array(read_usuario(['limit' => $count]));
        
        if (!empty($equipe)) {
            render_user_cards($equipe);
            // Verifica se precisa botão "Carregar Mais"
            // Nota: read_usuario com limit retorna APENAS o limit. 
            // Para saber se tem mais, o ideal seria contar o total, mas sem query extra,
            // podemos assumir que se retornou quantidade == limit, provavelmente tem mais.
            // O código original fazia: if ($equipe->num_rows > $count - 1)
            // Vou usar count >= $count para simplificar
            if (count($equipe) >= $count) {
                render_load_more('count', $count, 'Carregar mais membros');
            }
        } else {
            echo '<p class="text-muted text-center py-5">Nenhum membro encontrado.</p>';
        }
        ?>
    </div>

</div>

<?php
// JS do Slider e Active Menu e Intersection Observer
$pag = '
<script>
$(document).ready(function(){
    $(".leem").addClass("active");
    
    if ("IntersectionObserver" in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.05 });
        document.querySelectorAll(".fade-in-up").forEach(function(el) { obs.observe(el); });
    } else {
        document.querySelectorAll(".fade-in-up").forEach(function(el) { el.classList.add("visible"); });
    }
});
</script>';

include_once("include/inc_rodape.php");
?>
