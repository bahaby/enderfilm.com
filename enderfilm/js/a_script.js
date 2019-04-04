$(function(){
    $("#bot_tus").click(function(){
        var film=$("#bot_film").val();
        var sinema=$("#bot_sinema").val();
        var imdb=$("#bot_imdb").val();
        if (film!=""&&sinema!=""){
            $.ajax({
                type : "POST",
                url : "/bot.php",
                data : {
                    film : film,
                    sinema : sinema,
                    imdb : imdb
                },
                dataType: "json",
                beforeSend: function(){
                    $("#bot_tus").html('bekle...').attr("disabled",true);
                },
                success : function(obj){
                    $("#bot_resim").val(obj.f_ayrinti.resim_link);
                    $("#film_adi").val(obj.f_ayrinti.film_adi);
                    if (obj.f_ayrinti.dil=="Dublaj") {
                        $("#film_dil").val("1");
                    }else if (obj.f_ayrinti.dil=="Altyazı") {
                        $("#film_dil").val("2");
                    }else if (obj.f_ayrinti.dil=="Multi") {
                        $("#film_dil").val("3");
                    }
                    if (obj.f_ayrinti.yapim=="Yerli") {
                        $("#yapim").val("1");
                    }else if (obj.f_ayrinti.yapim=="Yabancı") {
                        $("#yapim").val("2");
                    }
                    for (var i = 1; i < 6; i++) {
                        $("#film_tur"+i).val(obj.f_ayrinti.tur[(i-1)]);
                    }
                    $("#ulke").val(obj.f_ayrinti.ulke);
                    $("#vizyon").val(obj.f_ayrinti.vizyon);
                    $("#sure").val(obj.f_ayrinti.sure);
                    $("#imdb_puan").val(obj.f_ayrinti.imdb);
                    $("#meta_puan").val(obj.f_ayrinti.meta);
                    $("#tomato_puan").val(obj.f_ayrinti.tomato);
                    $("#film_konu").html(obj.f_ayrinti.konu);
                    $("#fragman").val(obj.fragman);
                    $("#bot_imdb").val(obj.f_ayrinti.imdb_id);
                    $("#tomato_link").val(obj.f_ayrinti.tomato_link);
                    $("#senaryo").val(obj.f_ayrinti.senaryo);
                    $("#yonetmen").val(obj.f_ayrinti.yonetmen);
                    $("#bot_tus").html('Veri Çek').removeAttr("disabled");
                    for (var i = 1; i < 6; i++) {
                        if (obj.altyazi!=null) {
                            $("#link_baslika"+i).val(obj.altyazi[(i-1)][0]);
                            $("#film_linka"+i).val(obj.altyazi[(i-1)][1]);
                        }
                        if (obj.dublaj!=null) {
                            $("#link_baslik"+i).val(obj.dublaj[(i-1)][0]);
                            $("#film_link"+i).val(obj.dublaj[(i-1)][1]);
                        }
                    }
                }
            });
        }
    });
    $('#ekle_form').validate({
        rules: {
            bot_imdb: {
                required: true,
                remote: {
                    url: "/onay.php",
                    type: "post",
                    data: {
                        bot_imdb: function(){
                            return $("#bot_imdb").val();
                        }
                    }
                }
            },
            film_adi: {
                required: true,
                remote: {
                    url: "/onay.php",
                    type: "post",
                    data: {
                        film_adi: function(){
                            return $("#film_adi").val();
                        }
                    }
                }
            },
            bot_sinema: {
                required: true
            },
            imdb_puan: {
                required: true
            },
            film_konu: {
                required: true
            },
            ulke: {
                required: true
            },
            vizyon: {
                required: true
            },
            sure: {
                required: true
            }
        },
        messages: {
            bot_imdb: {
                required: "Boş bırakma !",
                remote: "Bu film ekli zaten !"
            },
            film_adi: {
                required: "Boş bırakma !",
                remote: "Bu film ekli zaten !"
            },
            bot_sinema: {
                required: "Boş bırakma !"
            },
            imdb_puan: {
                required: "Boş bırakma !",
                min: "min 0",
                max: "max 99"
            },
            meta_puan: {
                min: "min 0",
                max: "max 99"
            },
            tomato_puan: {
                min: "min 0",
                max: "max 99"
            },
            film_konu: {
                required: "Boş bırakma !"
            },
            ulke: {
                required: "Boş bırakma !"
            },
            vizyon: {
                required: "Boş bırakma !",
                min: "min 1990",
                max: "max 2017"
            },
            sure: {
                required: "Boş bırakma !",
                min: "min 0",
                max: "max 999"
            },
        }
    });
});