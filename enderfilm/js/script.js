//fancybox
$(function() {
    $(".fancy").fancybox({
        maxWidth    : 800,
        maxHeight   : 600,
        fitToView   : false,
        width       : '70%',
        height      : '70%',
        autoSize    : false,
        closeClick  : false,
        openEffect  : 'elastic',
        closeEffect : 'fade',
        padding     : 0
    });
});
$(function() {
    $(".kayitYap").click(function(){
        $.fancybox({
            padding     : 0,
            content: $("#kayit"),
            openEffect  : 'none',
            closeEffect : 'none',
            beforeLoad:function(){
                $("label.error").hide();
                $(".error").html('');
                $("#kayit .alan input").val('');
                $("#kayit_hata").html('');
            }
        });
    });
});
$(function() {
    $(".girisYap").click(function(){
        $.fancybox({
            padding     : 0,
            content: $("#giris"),
            openEffect  : 'none',
            closeEffect : 'none',
            beforeLoad:function(){
                $("label.error").hide();
                $(".error").html('');
                $("#giris .alan input").val('');
                $("#giris_hata").html('');
            }
        });
    });
});
$(function() {
    $(".s_unuttum").click(function(){
        $.fancybox({
            padding     : 0,
            height      : 600,
            width       : 800,
            type: 'inline',
            content: $("#hatirla"),
            openEffect  : 'none',
            closeEffect : 'none',
            beforeLoad:function(){
                $("label.error").hide();
                $(".error").html('');
                $("#hatirla .alan input").val('');
                $("#hatirla_hata").html('');
            }
        });
    });
});
$(function() {
    $("#hataKutu").fancybox({
        padding     : 0,
        openEffect  : 'none',
        closeEffect : 'none'
    }).trigger("click").off('click');
});
$(function() {
    $("#y_sifre").fancybox({
        padding     : 0,
        openEffect  : 'none',
        closeEffect : 'none'
    }).trigger("click").off('click');
});
// slider
$(function() {
    $('#slider .slidermenu li').on('click', function() {
        var $panel = $(this).closest('#slider');
        $panel.find('.slidermenu li.aktif').removeClass('aktif');
        $(this).addClass('aktif');
        var panelToShow = $(this).attr('rel');
        $panel.find('.slider.aktif').fadeOut(200, showNextPanel);
        function showNextPanel() {
            $(this).removeClass('aktif');
            $('#'+panelToShow).fadeIn(200, function() {
                $(this).addClass('aktif');
            });
        }
    });
});
//List
$(function() {
  $('.slidericerik, .film').hover(function() {
    $("a .filmresim",this).fadeTo(100,0.4);
    $("a .play, .star, .fragman, .eye, .izlenme, .aciklama",this).css("display","block");
  }, function() {
    // on mouseout, reset the background colour
    $("a .filmresim",this).fadeTo(100,1);
    $("a .play, .star, .fragman, .eye, .izlenme, .aciklama",this).css("display","none");
  });
  $(".film .fragman").hover(function(){
    $(this).find("p").fadeToggle(100);
  });
});

$(function(){
    $('#girisForm').validate({
        rules: {
            kullanici_adi_g: {
                required: true,
                rangelength: [4, 20],
                normalizer: function( value ) {
                    return $.trim( value );
                }
            },
            sifre_g: {
                required: true,
                rangelength: [6, 25]
            }
        },
        messages: {
            kullanici_adi_g: {
                required: "Lütfen bir kullanıcı adı giriniz",
                rangelength: "4 ile 20 karakter girebilirsiniz"
            },
            sifre_g: {
                required: "Bir şifre giriniz",
                rangelength: "6 ile 25 karakter girebilirsiniz"
            }
        },
        submitHandler: submitGiris
    });
    function submitGiris(){
        var data = $("#girisForm").serialize();
        $.ajax({
            type : "POST",
            url : "/user.php",
            data : data,
            beforeSend: function(){
                $("#giris_hata").html('');
                $("#girisTus").html('Kontrol ediliyor');
            },
            success : function(response){
                if (response=="ok") {
                    $("#girisTus").html('Giriş yapılıyor');
                    window.history.go(0);
                }else{
                    $("#giris_hata").html(response);
                    $("#girisTus").html('Giriş');
                    $("#giris .alan input").val('');
                }
            }
        });
        return false;
    }
    $('#kayitForm').validate({
        rules: {
            kullanici_adi: {
                required: true,
                rangelength: [4, 20],
                normalizer: function( value ) {
                    return $.trim( value );
                },
                remote: {
                    url: "/onay.php",
                    type: "post",
                    data: {
                        kullanici_adi: function(){
                            return $("#kullanici_adi_k").val();
                        }
                    }
                }
            },
            sifre: {
                required: true,
                rangelength: [6, 25]
            },
            sifre_tekrar: {
                required: true,
                rangelength: [6, 25],
                equalTo: "#sifre_k"
            },
            email: {
                required: true,
                email: true,
                normalizer: function( value ) {
                    return $.trim( value );
                },
                remote: {
                    url: "/onay.php",
                    type: "post",
                    data: {
                        email: function(){
                            return $("#email_k").val();
                        }
                    }
                }
            }
        },
        messages: {
            kullanici_adi: {
                required: "Lütfen bir kullanıcı adı giriniz",
                rangelength: "4 ile 20 karakter girebilirsiniz",
                remote: "Kullanıcı adı uygun değil"
            },
            sifre: {
                required: "Bir şifre giriniz",
                rangelength: "6 ile 25 karakter girebilirsiniz"
            },
            sifre_tekrar: {
                required: "Bir şifre giriniz",
                rangelength: "6 ile 25 karakter girebilirsiniz",
                equalTo: "Şifreler uyumsuz"
            },
            email: {
                required: "Email adresi giriniz",
                email: "Format yanlış",
                remote: "Email hesabı zaten kayıtlı"
            }
        },
        submitHandler: submitKayit
    });
    function submitKayit(){
        var data = $("#kayitForm").serialize();
        $.ajax({
            type : "POST",
            url : "/user.php",
            data : data,
            beforeSend: function(){
                $("#kayit_hata").html('');
                $("#kayitTus").html('yollanıyor');
            },
            success : function(response){
                if (response=="ok") {
                    $("#kayitForm").html('<div style="padding:30px; text-align:center; color:white;">Kayıt Başarılı<br>Hesabınızı aktif etmeyi unutmayın</div>');
                    setTimeout(function(){
                        window.history.go(0)
                    },1000);
                }else{
                    $("#kayit_hata").html(response);
                    $("#kayitTus").html('Kaydol');
                    $("#kayit .alan input").val('');
                }
            }
        });
        return false;
    }
    $('#hatirlaForm').validate({
        rules: {
            email: {
                required: true,
                email: true,
                normalizer: function( value ) {
                    return $.trim( value );
                }
            },
            kullanici_adi: {
                required: true,
                rangelength: [4, 20],
                normalizer: function( value ) {
                    return $.trim( value );
                }
            }
        },
        messages: {
            email: {
                required: "Email adresi giriniz",
                email: "Format yanlış"
            },
            kullanici_adi: {
                required: "Lütfen bir kullanıcı adı giriniz",
                rangelength: "4 ile 20 karakter girebilirsiniz"
            }
        },
        submitHandler: submitHatirla
    });
    function submitHatirla(){
        var data = $("#hatirlaForm").serialize();
        $.ajax({
            type : "POST",
            url : "/user.php",
            data : data,
            beforeSend: function(){
                $("#hatirla_hata").html('');
                $("#hatirlaTus").html('Kontrol ediliyor');
            },
            success : function(response){
                if (response=="ok") {
                    $("#hatirlaForm").html('<div style="padding:30px; text-align:center; color:white;">İşlem Başarılı<br>Şifrenizi değiştirmek için emailinizi kontrol ediniz</div>');
                    setTimeout(function(){
                        window.history.go(0)
                    },1000);
                }else{
                    $("#hatirla_hata").html(response);
                    $("#hatirlaTus").html('Onayla');
                    $("#hatirla .alan input").val('');
                }
            }
        });
        return false;
    }
    $('#y_sifreForm').validate({
        rules: {
            sifre: {
                required: true,
                rangelength: [6, 25]
            },
            sifre_t: {
                required: true,
                rangelength: [6, 25],
                equalTo: "#sifre_y"
            }
        },
        messages: {
            sifre: {
                required: "Bir şifre giriniz",
                rangelength: "6 ile 25 karakter girebilirsiniz"
            },
            sifre_t: {
                required: "Bir şifre giriniz",
                rangelength: "6 ile 25 karakter girebilirsiniz",
                equalTo: "Şifreler uyumsuz"
            }
        },
        submitHandler: submitY_sifre
    });
    function submitY_sifre(){
        var data = $("#y_sifreForm").serialize();
        $.ajax({
            type : "POST",
            url : "/user.php",
            data : data,
            beforeSend: function(){
                $("#y_sifre_hata").html('');
                $("#y_sifreTus").html('Kontrol ediliyor');
            },
            success : function(response){
                if (response=="ok") {
                    $("#y_sifreForm").html('<div style="padding:30px; text-align:center; color:white;">Şifreniz Değiştirildi</div>');
                    setTimeout(function(){
                        window.history.go(0)
                    },1000);
                }else{
                    $("#y_sifre_hata").html(response);
                    $("#y_sifreTus").html('Şifreni Değiştir');
                    $("#y_sifre .alan input").val('');
                }
            }
        });
        return false;
    }
});
$(function(){
    $(".videodugme li .link_i").click(function(){
        $(this).next().fadeToggle(100);
        $(this).parent().siblings().find(".secenek").hide();
    });
    $(".secenek li").click(function(){
        var id=window.location.pathname;
        var link=$(this).html();
        var dil=$(this).parent().prev().attr("id");
        $.ajax({
            type : "POST",
            url : "/onay.php",
            data : {
                id : id,
                link : link,
                dil : dil
            },
            success : function(response){
                $(".video iframe").attr("src",response);
            }
        });
        $(this).parent().hide();
    });
    $(".videodugme li .link_f").click(function(){
        var id=window.location.pathname;
        var link=$(this).html();
        $.ajax({
            type : "POST",
            url : "/onay.php",
            data : {
                id : id,
                link : link
            },
            success : function(response){
                $(".video iframe").attr("src",response);
            }
        });
        $(".videodugme li .secenek").hide();
    });
    $('html').on('click', function(evt) {
        var $tgt = $(evt.target);
        if ($tgt.is('.menu')) { 
            return;
        }else{
            $('.secenek').hide();
        }
    });
});

$(function(){
    var timeout = null;
    $("#ara_k").on('keyup', function () {
        var that = this;
        if (timeout !== null) {
            clearTimeout(timeout);
        }
        timeout = setTimeout(function () {
            var kelime = $(that).val();
            if (kelime.length>1) {
                $("#sonuc_k").show();
                $.ajax({
                    type : "GET",
                    url : "/onay.php",
                    data : {
                        ara : kelime
                    },
                    success : function(cevap){
                        $("#sonuc_k").html(cevap);
                    }
                });
            }else if (kelime.length<=1){
                $("#sonuc_k").html("");
            }
        }, 300);
    });
    $("#ara_k").focus(function(){
        var kelime = $(this).val();
        if (kelime.length>1) {
            $("#sonuc_k").show();
        }
    });
    $('html').on('click', function(e) {
        var t = $(e.target);
        if (t.is('#ara_k,#sonuc_k ul,#sonuc_k li')) { 
            return;
        }else{
            $('#sonuc_k').hide();
        }
    });
    $("#ara_form").on("click", "button,#ara_tus", function() {
        var url = $('#sonuc_k ul li:first a').attr('href');
        if (url!==undefined) {
            window.location.href = '/'+url;
        }
        $('#ara_k').blur();
    });
});