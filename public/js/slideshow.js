function plusSlides(n, id) {
    const container = document.getElementById(`slide-container-${id}`);
    const slides = container.querySelectorAll(`[data-slide-id="${id}"]`);
    let slideIndex = parseInt(container.getAttribute("data-slide-index")) || 1;

    slideIndex += n;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }
    if (slideIndex < 1) {
        slideIndex = slides.length;
    }

    container.setAttribute("data-slide-index", slideIndex);

    slides.forEach((slide) => (slide.style.display = "none"));
    slides[slideIndex - 1].style.display = "block";
}

document.querySelectorAll(".slide-container").forEach((container) => {
    container.setAttribute("data-slide-index", 1);
    const slides = container.querySelectorAll(`[data-slide-id]`);
    if (slides.length > 0) slides[0].style.display = "block";
    const prev = container.querySelector(".prev");
    const next = container.querySelector(".next");
    if (slides.length <= 1) {
        if (prev) prev.style.display = "none";
        if (next) next.style.display = "none";
    }
});
