
$(document).ready(function () {
    setInterval(() => {
        changeDateTime()
    }, 1000);
})


function formatDate(element) {
    element = (String)(element);
    (element.length < 2)
        ? element = "0" + element
        : element = element;
    return element;
}

function changeDateTime() {
    var date = new Date();
    $("#hours").text(formatDate(date.getHours()))
    $("#minutes").text(formatDate(date.getMinutes()))

}