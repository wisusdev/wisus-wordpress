document.addEventListener("DOMContentLoaded", function () {
    let footer = document.getElementById("site-footer");
    let main = document.getElementById("primary");

    if (!footer) {
        console.error("Footer element with ID 'site-footer' not found.");
        return;
    }

    function ajustarAltura() {
        let footerHeight = footer.offsetHeight;
        main.style.minHeight = `calc(90.9vh - ${footerHeight}px)`;
    }

    ajustarAltura();
    window.addEventListener("resize", ajustarAltura);
});