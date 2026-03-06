<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/langs/pt_br.min.js"></script>
<!-- Editor de imagem -->
<!-- <script src="/public/libs/darkroomjs/fabric.js"></script>
<script src="/public/libs/darkroomjs/darkroom.js"></script> -->
<script src="/public/js/app.js?v=<?php echo date('Ymdhis');?>"></script>
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
