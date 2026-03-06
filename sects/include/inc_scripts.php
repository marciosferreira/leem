<script src="/libs/js/jquery.min.js"></script>
<script src="/libs/js/mask.min.js"></script>
<script src="/libs/js/popper.min.js"></script>
<script src="/libs/js/bootstrap.min.js"></script>
<script src="/js/slick.min.js"></script>
<script src="/libs/editor/trumbowyg.min.js"></script>
<script src="/libs/editor/langs/pt_br.min.js"></script>
<!-- Editor de imagem -->
<!-- <script src="/libs/darkroomjs/fabric.js"></script>
<script src="/libs/darkroomjs/darkroom.js"></script> -->
<script src="/js/app.js?v=<?php echo date('Ymdhis');?>"></script>
<script>
    $(window).scroll(function(event) {
        var scroll = $(window).scrollTop();
        var menu = $(".header-menu");

        if (scroll > 100) {
            menu.addClass('fixed shadow');
        } else {
            menu.removeClass('fixed shadow');
        }
    });

    // var dkrm = new Darkroom('#fotoPerfil', {
    //   // Size options
    //   minWidth: 300,
    //   minHeight: 300,
    //   maxWidth: 300,
    //   maxHeight: 300,
    //   ratio: 4 / 4,
    //   backgroundColor: '#000',

    //   plugins: {
    //     //save: false,
    //     crop: {
    //       quickCropKey: 67, //key "c"
    //       minHeight: 50,
    //       minWidth: 50,
    //       ratio: 4 / 4
    //     }
    //   }
    // });
</script>
