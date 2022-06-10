$(function() {


    /*   //redimensionamento do slide
	
	    var width = parseInt($('body').css('width'));
	    var height = parseInt((width/3));
	    var btns = parseInt((height-50)/2);
		
		
		$('.slider').css({'height':+height+'px'});
		$('.container-slid').css({'height':+height+'px'});

		$('.slider .slider-item').css({'height':+height+'px'});
		$('.slider-next,.slider-prev').css({'margin-top':+btns+'px'});
		
		$(window).resize(function() {
		  var width = parseInt($('body').css('width'));
	      var height = parseInt((width/3));
	      var btns = parseInt((height-50)/2);
		
		  $('.slider').css({'height':+height+'px'});
		  $('.container-slid').css({'height':+height+'px'});
		
		  $('.slider .slider-item').css({'height':+height+'px'});
		  $('.slider-next,.slider-prev').css({'margin-top':+btns+'px'});
		});*/




    // AVANÇA PARA O PRÓXIMO SLIDE
    var nextSlider = function() {
        if ($('.slider-item.active').next('.slider-item').size()) {
            $('.slider-item.active').each(function() {
                $(this).next('.slider-item').addClass('active');
                $(this).removeClass('active');
            });

        } else {
            $('.slider-item.active').each(function() {
                $('.slider-item').removeClass('active');
                $('.slider-item:eq(0)').addClass('active');
            });
        }
    };


    // VOLTA PARA O SLIDE ANTERIOR
    var prevSlider = function() {
        if ($('.slider-item.active').index() > 0) {
            $('.slider-item.active').each(function() {
                $(this).prev('.slider-item').addClass('active');
                $(this).removeClass('active');
            });

        } else {
            $('.slider-item.active').each(function() {
                $('.slider-item').removeClass('active');
                $('.slider-item:last-of-type').addClass('active');
            });
        }
    };


    // INICIALIZAÇÃO AUTOMÁTICA DO SLIDE
    var sliderAuto = setInterval(nextSlider, 5000);

    $('.content-slide,.slider-next, .slider-prev').hover(function() {
        clearInterval(sliderAuto);
    }, function() {
        sliderAuto = setInterval(nextSlider, 5000);
    });


    // REINICIALIZAÇÃO DO SLIDE
    $('.content-slide').click(function() {
        $('.slider-item.active').each(function() {
            $('.slider-item').removeClass('active');
            $('#reset-carrosel').addClass('active');
        });
    });


    //slider-prev
    //AÇÕES DE AVANÇAR E VOLTAR SLIDE
    $('.slider-next').click(function(event) {
        event.preventDefault();
        nextSlider();
    });

    $('.slider-prev').click(function(event) {
        event.preventDefault();
        prevSlider();
    });






});