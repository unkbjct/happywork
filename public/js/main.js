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

    $(".nav-children-content").on("mouseenter", function (e) {
        $(".children-list").removeClass("active")
        $(e.target).next().addClass("active")
    })

    $(".nav-children-content").on("mouseleave", function (e) {
        $(".children-list").removeClass("active")
    })

    $(".btn-count-minus").click(function () {
        if ((Number)($(this).next().val()) <= 1) return;
        $(this).next().val((Number)($(this).next().val()) - 1)
    })

    $(".btn-count-plus").click(function () {
        $(this).prev().val((Number)($(this).prev().val()) + 1)
    })

    $("input.count-product").on("input", function () {
        $(this).val($(this).val().replace(/[A-Za-zА-Яа-яЁё]/, ''))
        // if (this.value <= 0) this.value = 1;
    })

    $("input.count-product").on("blur", function () {
        if (!this.value) this.value = 1;
    })

    $("button.add-to-cart").click(function () {
        $.ajax({
            url: `${window.location.protocol}//${window.location.host}/api/catalog/cart/add`,
            method: 'post',
            data: {
                product: this.dataset.productId,
                count: $(this).prev().find("input").val(),
            },
            success: (e) => {
                showAlert([e.message], 'alert-success')
                const cartModal = new bootstrap.Modal(document.getElementById('cart-modal'))
                $("#cart-modal-text").text(`Товар «${e.data.product.title}» успешно добавлен в вашу корзину`)
                $("#cart-modal-image").attr("src", e.data.image)
                cartModal.show();
                $("#cart-badge").text((Number)($("#cart-badge").text()) + (Number)($(this).prev().find("input").val()))
                $("#cart-badge").removeClass("visually-hidden")
            },
            error: (e) => {
                console.log(e)
            }
        })
    })

    $(".btn-favorite").click(function () {
        $.ajax({
            url: `${window.location.protocol}//${window.location.host}/api/catalog/favorite`,
            method: 'post',
            data: {
                product: this.dataset.productId,
            },
            success: (e) => {
                $("#favorites-badge").text(e.data.count);
                showAlert([e.message], 'alert-success');
                (e.data.count == 0) ? $("#favorites-badge").addClass("visually-hidden") : $("#favorites-badge").removeClass("visually-hidden");
                $(this).toggleClass("active");
            },
            error: (e) => {
                console.log(e)
                showAlert(e.responseJSON.data.errors, 'alert-danger')
            }
        })
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