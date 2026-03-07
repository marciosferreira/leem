<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'configs.php';
header('Content-Type: text/html; charset=utf-8');
include_once('include/inc_header.php');
include_once("include/templates/inc_materia_min.php");

/* ─────────────────────────────────────────────────────────────
   Helper: converte mysqli_result em array PHP puro.
   Necessário porque mysqli_result só pode ser iterado UMA vez.
───────────────────────────────────────────────────────────── */
function result_to_array($result) {
    $arr = [];
    if (!$result || $result->num_rows === 0) return $arr;
    while ($row = $result->fetch_assoc()) {
        $arr[] = $row;
    }
    return $arr;
}

/* ─────────────────────────────────────────────────────────────
   Helper: renderiza grid de cards para um array de matérias.
   $opts:
     tipo      => label do badge
     featured  => true mostra o 1º card maior
     dark      => true usa card-dark (fundo escuro)
     excerpt   => true mostra resumo no card
───────────────────────────────────────────────────────────── */
function render_cards($items, $opts = []) {
    $tipo     = $opts['tipo']     ?? 'Item';
    $featured = $opts['featured'] ?? false;
    $dark     = $opts['dark']     ?? false;
    $excerpt  = $opts['excerpt']  ?? false;

    echo '<div class="row row-cards">';
    foreach ($items as $i => $m) {
        $is_feat  = false;
        $tem_foto = !empty($m['foto']);
        $col      = 'col-12 col-sm-6 col-md-4 col-lg-3';

        echo '<div class="' . $col . ' fade-in-up">';
        echo '<div class="card-noticia' . ($dark ? ' card-dark' : '') . '">';

        /* Imagem */
        echo '<div class="card-img-wrap' . ($tem_foto ? '' : ' no-photo') . '" data-tipo="' . htmlspecialchars($tipo) . '">';
        if ($tem_foto) {
            echo '<img src="/uploads/fotos/' . htmlspecialchars($m['foto']) . '"'
               . ' alt="' . htmlspecialchars($m['titulo']) . '"'
               . ' loading="' . ($i === 0 ? 'eager' : 'lazy') . '">';
        }
        echo '<span class="card-tipo">' . htmlspecialchars($tipo) . '</span>';
        echo '</div>';

        /* Corpo */
        echo '<div class="card-body">';
        if (!empty($m['data'])) {
            echo '<p class="card-meta">' . date('d M Y', strtotime($m['data'])) . '</p>';
        }
        echo '<h3 class="card-title">';
        echo '<a href="/index.php/materia/' . htmlspecialchars($m['slug']) . '">';
        echo htmlspecialchars($m['titulo']);
        echo '</a></h3>';
        if ($excerpt && !empty($m['resumo'])) {
            echo '<p class="card-excerpt">' . htmlspecialchars($m['resumo']) . '</p>';
        }
        echo '<a href="/index.php/materia/' . htmlspecialchars($m['slug']) . '" class="card-link">';
        echo 'Ler mais <span class="arrow">&#8594;</span></a>';
        echo '</div>'; /* card-body */
        echo '</div>'; /* card-noticia */
        echo '</div>'; /* col */
    }
    echo '</div>'; /* row row-cards */
}

/* ─────────────────────────────────────────────────────────────
   Helper: botão "carregar mais"
───────────────────────────────────────────────────────────── */
function render_mais($name, $value, $label, $dark = false) {
    echo '<div class="text-center mt-4">';
    echo '<form method="post" style="display:inline;">';
    echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
    echo '<button type="submit" class="btn-mais' . ($dark ? ' btn-mais-dark' : '') . '">';
    echo '<i class="material-icons" style="font-size:17px;vertical-align:middle;">expand_more</i> ';
    echo htmlspecialchars($label);
    echo '</button></form></div>';
}
?>


<!-- ══════════════════════════════════════════════════════════
     HERO — Editorial Split Layout
     Fundo sólido escuro + thumbnail contida (sem foto fullscreen).
══════════════════════════════════════════════════════════ -->
<?php
$destaques_arr = result_to_array(read_materia(['destaque' => 1]));
$total_dest    = count($destaques_arr);
?>
<?php if ($total_dest > 0) : ?>
<section class="hero-wrapper">
    <div class="hero-slider">
        <?php foreach ($destaques_arr as $idx => $d) :
            $tem_foto  = !empty($d['foto']);
            $num_fmt   = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
            $total_fmt = str_pad($total_dest,  2, '0', STR_PAD_LEFT);
            $palavras  = explode(' ', $d['titulo']);
            $titulo_h  = implode(' ', array_slice($palavras, 0, 13));
            if (count($palavras) > 13) $titulo_h .= '…';
        ?>
        <div class="hero-slide">
            <div class="hero-inner">

                <div class="hero-text">
                    <span class="hero-tag">Destaque</span>
                    <p class="hero-numero"><?= $num_fmt ?> / <?= $total_fmt ?></p>
                    <h1 class="hero-title">
                        <a href="/index.php/materia/<?= htmlspecialchars($d['slug']) ?>">
                            <?= htmlspecialchars($titulo_h) ?>
                        </a>
                    </h1>
                    <?php if (!empty($d['resumo'])) : ?>
                    <p class="hero-excerpt"><?= htmlspecialchars($d['resumo']) ?></p>
                    <?php endif; ?>
                    <a href="/index.php/materia/<?= htmlspecialchars($d['slug']) ?>" class="hero-cta">
                        Ler matéria &#8594;
                    </a>
                    <div class="hero-progress" style="margin-top:2rem;">
                        <div class="hero-progress-track">
                            <div class="hero-progress-fill" data-slide="<?= $idx ?>"></div>
                        </div>
                        <span class="hero-counter"><?= $num_fmt ?>&thinsp;/&thinsp;<?= $total_fmt ?></span>
                    </div>
                </div>

                <div class="hero-media">
                    <div class="hero-thumb <?= $tem_foto ? '' : 'no-photo' ?>">
                        <?php if ($tem_foto) : ?>
                        <img src="/uploads/fotos/<?= htmlspecialchars($d['foto']) ?>"
                             alt="<?= htmlspecialchars($d['titulo']) ?>"
                             loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>">
                        <?php endif; ?>
                    </div>

                </div>

            </div><!-- /hero-inner -->
        </div><!-- /hero-slide -->
        <?php endforeach; ?>
    </div><!-- /hero-slider -->
</section>
<?php endif; ?>


<!-- ══════════════════════════════════════════════════════════
     MATÉRIAS
══════════════════════════════════════════════════════════ -->
<?php
$count_mat = isset($_REQUEST['count_mat']) ? (int)$_REQUEST['count_mat'] + 4 : 4;
$mat_arr   = result_to_array(read_materia(['tipo' => 'materia'], $count_mat));
if (!empty($mat_arr)) :
?>
<section class="secao">
    <div class="container">
        <h2 class="titulo-categoria">Matérias</h2>
        <?php render_cards($mat_arr, ['tipo' => 'Matéria']); ?>
        <?php if (count($mat_arr) >= $count_mat) render_mais('count_mat', $count_mat, 'Carregar mais matérias'); ?>
    </div>
</section>
<?php endif; ?>


<!-- ══════════════════════════════════════════════════════════
     SEMINÁRIOS
══════════════════════════════════════════════════════════ -->
<?php
$count_sem = isset($_REQUEST['count_sem']) ? (int)$_REQUEST['count_sem'] + 8 : 8;
$sem_arr   = result_to_array(read_materia(['tipo' => 'seminario'], $count_sem));
?>
<section class="secao secao-warm">
    <div class="container">
        <h2 class="titulo-categoria">Seminários do LEEM</h2>
        <?php if (!empty($sem_arr)) : ?>
            <?php render_cards($sem_arr, ['tipo' => 'Seminário']); ?>
            <?php if (count($sem_arr) >= $count_sem) render_mais('count_sem', $count_sem, 'Mais seminários'); ?>
        <?php else : ?>
            <div class="text-center py-5">
                <p class="h5 text-muted">Muitos seminários em breve.</p>
            </div>
        <?php endif; ?>
    </div>
</section>


<!-- ══════════════════════════════════════════════════════════
     NOTÍCIAS
══════════════════════════════════════════════════════════ -->
<?php
$count_not = isset($_REQUEST['count_not']) ? (int)$_REQUEST['count_not'] + 4 : 4;
$not_arr   = result_to_array(read_materia(['tipo' => 'noticia'], $count_not));
if (!empty($not_arr)) :
?>
<section class="secao">
    <div class="container">
        <div class="row mb-0">
            <div class="col-12 text-right">
                <h2 class="titulo-categoria text-right">Notícias</h2>
            </div>
        </div>
        <?php render_cards($not_arr, ['tipo' => 'Notícia', 'excerpt' => true]); ?>
        <?php if (count($not_arr) >= $count_not) render_mais('count_not', $count_not, 'Mais notícias'); ?>
    </div>
</section>
<?php endif; ?>


<!-- ══════════════════════════════════════════════════════════
     EVENTOS  (fundo escuro)
══════════════════════════════════════════════════════════ -->
<?php
$count_eve = isset($_REQUEST['count_eve']) ? (int)$_REQUEST['count_eve'] + 4 : 4;
$eve_arr   = result_to_array(read_materia(['tipo' => 'evento'], $count_eve));
if (!empty($eve_arr)) :
?>
<section class="secao secao-dark">
    <div class="container">
        <h2 class="titulo-categoria" style="color:var(--white);">
            Eventos
            <small style="display:block;font-family:var(--font-body);font-size:.55em;
                          font-weight:400 !important;color:var(--teal);
                          text-transform:none;letter-spacing:.01em;margin-top:.2rem;">
                Agenda LEEM
            </small>
        </h2>
        <?php render_cards($eve_arr, ['tipo' => 'Evento', 'dark' => true]); ?>
        <?php if (count($eve_arr) >= $count_eve) render_mais('count_eve', $count_eve, 'Mais eventos', true); ?>
    </div>
</section>
<?php endif; ?>


<!-- ══════════════════════════════════════════════════════════
     VISITAS
══════════════════════════════════════════════════════════ -->
<?php
$count_vis = isset($_REQUEST['count_vis']) ? (int)$_REQUEST['count_vis'] + 4 : 4;
$vis_arr   = result_to_array(read_materia(['tipo' => 'visita'], $count_vis));
if (!empty($vis_arr)) :
?>
<section class="secao">
    <div class="container">
        <h2 class="titulo-categoria">Visitas</h2>
        <?php render_cards($vis_arr, ['tipo' => 'Visita']); ?>
        <?php if (count($vis_arr) >= $count_vis) render_mais('count_vis', $count_vis, 'Mais visitas'); ?>
    </div>
</section>
<?php endif; ?>


<?php
$pag = '
<script>
(function(){
    /* ── Hero Slider ─────────────────────────────────── */
    var autoplayMs  = 6000;
    var $slider     = $(".hero-slider");

    function resetProgress() {
        $(".hero-progress-fill").css({ transition: "none", width: "0%" });
    }
    function startProgress(idx) {
        resetProgress();
        setTimeout(function(){
            $(".hero-progress-fill[data-slide=\"" + idx + "\"]").css({
                transition: "width " + (autoplayMs / 1000) + "s linear",
                width: "100%"
            });
        }, 60);
    }

    $slider.slick({
        autoplay:       true,
        autoplaySpeed:  autoplayMs,
        speed:          650,
        fade:           false,
        dots:           false,
        arrows:         true,
        pauseOnHover:   true,
        infinite:       true,
        slidesToShow:   1,
        slidesToScroll: 1
    });

    $slider.on("init afterChange", function(e, slick, current){
        startProgress(current || 0);
    });
    $slider.on("beforeChange", resetProgress);
    startProgress(0);

    /* ── Outros sliders ──────────────────────────────── */
    $(".usuarios, .visitantes").slick({
        slidesToShow: 1, slidesToScroll: 1, dots: true, arrows: false
    });

    /* ── Nav ativa ───────────────────────────────────── */
    var $pag = $(".inicio");
    if (!$pag.hasClass("active")) $pag.addClass("active");

    /* ── Fade-in-up cards via IntersectionObserver ───── */
    if ("IntersectionObserver" in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.06 });
        document.querySelectorAll(".fade-in-up").forEach(function(el) {
            obs.observe(el);
        });
    } else {
        document.querySelectorAll(".fade-in-up").forEach(function(el) {
            el.classList.add("visible");
        });
    }
})();
</script>';

include_once("include/inc_rodape.php");
?>
