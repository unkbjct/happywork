$(document).ready(() => {
    if (localStorage.getItem("message-success")) {
        showAlert([localStorage.getItem("message-success")], 'alert-success');
        localStorage.removeItem("message-success");
    }

    $(".catalog").on("mouseenter", function () {
        $("#catalog-parent-list").addClass("active");
        $(".background").addClass("active")
    })
    $(".catalog").on("mouseleave", function () {
        $("#catalog-parent-list").removeClass("active");
        $(".background").removeClass("active")
    })

    $(".nav-children-content").on("mouseenter", function(e){
        $(".children-list").removeClass("active")
        $(e.target).next().addClass("active")
    })

    $(".nav-children-content").on("mouseleave", function(e){
        $(".children-list").removeClass("active")
    })

})

async function showAlert(errors, classType) {

    if ($(".custom-alert").length) {
        await $(".custom-alert")[0].animate([
            { translate: "0 -50px", opacity: 0 },
        ], {
            duration: 400,
            easing: "cubic-bezier(0.51,-0.66, 0.27, 1.25)",
        }).finished.then(function () {
            $(".custom-alert")[0].remove();
        })
    }

    $(".custom-alert").remove();

    let customAlert = document.createElement("div");
    customAlert.classList.add("custom-alert");
    customAlert.classList.add(classType);

    let alertText = document.createElement("div");
    alertText.classList.add("alert-text");

    for (let key in errors) {
        // $("#" + key).addClass("is-invalid");
        // $("#" + key).parent().find('.invalid-feedback').remove();
        // $("#" + key).parent().append(
        // `<div class="invalid-feedback">${e.responseJSON.errors[key]}</div>`);
        let tmpDiv = document.createElement("div");
        tmpDiv.textContent = errors[key];
        alertText.append(tmpDiv)
    }
    customAlert.append(alertText)
    let alertProgress = document.createElement("div");
    alertProgress.classList.add("alert-progress");
    customAlert.append(alertProgress);
    document.getElementById("main").append(customAlert)

    customAlert.animate([
        { opacity: 1, translate: 0 },
    ], {
        duration: 400,
        fill: "forwards",
        easing: "cubic-bezier(0.27, 1.25, 0.27, 1.25)",
    }).finished.then(function () {
        // customAlert.style.translate = 0;
        alertProgressAnimation.play();
    })

    var alertProgressFrame = new KeyframeEffect(
        alertProgress,
        [
            { width: 0 },
        ],
        {
            duration: 5000,
            fill: "forwards",
            easing: "linear"
        }
    );

    alertProgressAnimation = new Animation(alertProgressFrame, document.timeline)

    alertProgressAnimation.finished.then(() => {
        customAlert.animate([
            { translate: "0 -50px", opacity: 0 },
        ], {
            duration: 400,
            easing: "cubic-bezier(0.51,-0.66, 0.27, 1.25)",
        }).finished.then(function () {
            customAlert.remove();
        })
    })

    customAlert.addEventListener("mouseenter", () => {
        alertProgressAnimation.cancel();
    }, false)

    customAlert.addEventListener("mouseleave", () => {
        alertProgressAnimation.play();
    }, false)

    customAlert.addEventListener("click", function () {
        this.animate([
            { translate: "0 -50px", opacity: 0 },
        ], {
            duration: 400,
            easing: "cubic-bezier(0.51,-0.66, 0.27, 1.25)",
        }).finished.then(function () {
            this.remove();
        }.bind(this))
    })



}