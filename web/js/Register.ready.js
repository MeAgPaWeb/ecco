
$(function() {
    updateAvatar();
    $("#fos_user_registration_form_gender").change(function() {
        updateAvatar();
    });
    
    $("#fos_user_registration_form_avatar").change(function() {
        var reader = new FileReader();
        reader.onload = function (e) {
            loadImage(e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    
    $("#avatar").hover(
        function() {
            if ($(this).hasClass("custom")) {
                $("#avatar #Custom").switchClass("opacity10", "opacity5", 0);
                $("#avatar-remove").removeClass("visibility-hidden");
            }
        }, function() {
            if ($(this).hasClass("custom")) {
                $("#avatar #Custom").switchClass("opacity5", "opacity10", 0);
                $("#avatar-remove").addClass("visibility-hidden");
            }
        }
    );
    
    $("#avatar").click(function() {
        if ($(this).hasClass("custom")) {
            removeImage();
        }
    });
});
