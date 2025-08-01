(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 40) {
            $('.navbar').addClass('sticky-top');
        } else {
            $('.navbar').removeClass('sticky-top');
        }
    });
    
    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    
    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Date and time picker
    $('.date').datetimepicker({
        format: 'L'
    });
    $('.time').datetimepicker({
        format: 'LT'
    });


    // Image comparison
    $(".twentytwenty-container").twentytwenty({});


    // Price carousel
    $(".price-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        margin: 45,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            }
        }
    });


   $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        items: 1,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
    });

    // Manejo del formulario de cita y WhatsApp
   $('#appointmentForm').on('submit', function(e) {
    e.preventDefault();

    var service = $('#service').val();
    var doctor = $('#doctor').val();
    var name = $('#name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var date = $('#date').val();
    var time = $('#time').val();
    var message = $('#message').val();

    // Verificar campos requeridos
    if (!service || !doctor || !name || !date || !time) {
        alert('Por favor completa todos los campos requeridos');
        return;
    }

    // Construir mensaje para WhatsApp
    var whatsappMessage = `Hola, quisiera solicitar una cita dental:\n\n`;
    whatsappMessage += `👨‍⚕️ Servicio: ${service}\n`;
    whatsappMessage += `🩺 Doctor: ${doctor}\n`;
    whatsappMessage += `👤 Nombre: ${name}\n`;
    
    if (phone) {
        whatsappMessage += `📱 Teléfono: ${phone}\n`;
    }
    if (email) {
        whatsappMessage += `📧 Email: ${email}\n`;
    }
    
    whatsappMessage += `📅 Fecha preferida: ${date}\n`;
    whatsappMessage += `🕐 Hora preferida: ${time}\n`;
    
    if (message) {
        whatsappMessage += `💬 Mensaje adicional: ${message}\n`;
    }
    
    whatsappMessage += `\n¡Espero su confirmación! 😊`;

    var encodedMessage = encodeURIComponent(whatsappMessage);
    var phoneNumber = "528441307881";
    var whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    window.open(whatsappURL, '_blank');
});

})(jQuery);