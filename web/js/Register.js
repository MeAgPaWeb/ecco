function updateAvatar() {
    var gender = $("#fos_user_registration_form_gender").val();
    console.log($("#avatar").hasClass("Female") || $("#avatar").hasClass("Male"));
    if ($("#Custom").hasClass("hidden")) {
        $("#Male").addClass("hidden");
        $("#Female").addClass("hidden");
        $("#"+gender).removeClass("hidden");
    }
}

function loadImage(url) {
    $("#avatar").addClass("custom");
    $("#Custom").removeClass("hidden");
    $("#Custom").attr("src", url);
    
    $("#Male").addClass("hidden");
    $("#Female").addClass("hidden");
}

function removeImage() {
    $("#avatar").removeClass("custom");
    $("#Custom").addClass("hidden");
    $("#Custom").attr("src", "");
    $("#fos_user_registration_form_avatar").val("");
    $("#avatar-remove").addClass("visibility-hidden");
    
    updateAvatar();
}

