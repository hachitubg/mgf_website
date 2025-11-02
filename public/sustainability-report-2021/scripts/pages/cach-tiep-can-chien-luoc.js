gsap.set(
  `.graphic-number-1, .graphic-number-2, .graphic-number-3, .graphic-number-4, .graphic-number-5`,
  {
    opacity: 0,
    y: -300,
  }
);

gsap.set("#road-line-1, #road-line-2, #road-line-3, #road-line-top", {
  drawSVG: "50% 50%",
  opacity: 0,
});

gsap.set(
  "#road-color-3, #road-line-bottom, #road-color-1, #road-color-2, #road-color-4, #gf-2021-hook, #gf-2022-hook, #gf-2023-hook, #gf-2024-hook, #gf-2025-hook, #gf-2030-hook, #gf-2050-hook",
  { opacity: 0 }
);

gsap.set(".gf-icon-prize", {
  opacity: 0,
});

gsap.set(
  "#gf-2021-line, #gf-2022-line, #gf-2023-line, #gf-2024-line, #gf-2025-line, #gf-2030-line, #gf-2050-line",
  { drawSVG: "0%", opacity: 0 }
);

gsap.set(
  "#gf-2021-text, #gf-2022-text, #gf-2023-text, #gf-2024-text, #gf-2025-text, #gf-2030-text, #gf-2050-text",
  {
    opacity: 0,
    x: -100,
  }
);

function animateFrom(element) {
  const { classList } = element;

  if (classList.contains("animation-1")) {
    runAnimation(element, "animate__fadeIn");
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInRight");
  } else if (classList.contains("animation-2")) {
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInRight");
    runAnimation(element, "animate__fadeInUp");
    runAnimation(element, "animate__fadeIn");
  } else if (classList.contains("animation-3")) {
    runAnimation(element, "animate__zoomIn");
    runAnimation(element, "animate__fadeInRight");
  } else if (classList.contains("animation-4")) {
    runAnimation(element, "animate__fadeInLeft");
    counterUp();
  } else if (classList.contains("animation-5")) {
    runAnimation(element, "animate__fadeInDown");
  } else if (classList.contains("animation-6")) {
    runAnimation(element, "animate__fadeInDown");

    gsap.from("text", { opacity: 0, duration: 1 });
    gsap.to(
      $(
        `.graphic-number-1, .graphic-number-2, .graphic-number-3, .graphic-number-4, .graphic-number-5`
      ),
      {
        opacity: 1,
        y: 0,
        duration: 2,
        ease: "bounce.out",
        stagger: 0.1,
      }
    );
  } else if (classList.contains("animation-7")) {
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInUp");
  } else if (classList.contains("animation-8")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__zoomIn");
    runAnimation(element, "animate__fadeInRight");
  } else if (classList.contains("animation-9")) {
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInRight");
  } else if (classList.contains("animation-10")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeInLeft");

    const targetOffset = $("#svg-section-8").offset().top - 100;
    $("html, body").animate({ scrollTop: targetOffset }, 1);

    gsap.to("#road-line-1, #road-line-2, #road-line-3, #road-line-top", {
      duration: 1,
      opacity: 1,
      drawSVG: true,
      delay: 0.5,
    });

    gsap.to("#road-color-1, #road-color-2, #road-color-4", {
      duration: 0.5,
      opacity: 1,
      delay: 1.5,
    });

    gsap.to(
      "#gf-2021-hook, #gf-2022-hook, #gf-2023-hook, #gf-2024-hook, #gf-2025-hook, #gf-2030-hook, #gf-2050-hook",
      { y: 0, duration: 1, opacity: 1, delay: 1.5, stagger: 0.1 }
    );

    gsap.to(".gf-icon-prize", {
      opacity: 1,
      duration: 1,
      delay: 2,
      stagger: 0.1,
    });

    gsap.to(
      "#gf-2021-line, #gf-2022-line, #gf-2023-line, #gf-2024-line, #gf-2025-line, #gf-2030-line, #gf-2050-line",
      { duration: 0.5, opacity: 1, delay: 3, drawSVG: "100%", stagger: 0.1 }
    );

    gsap.to(
      "#gf-2021-text, #gf-2022-text, #gf-2023-text, #gf-2024-text, #gf-2025-text, #gf-2030-text, #gf-2050-text",
      { opacity: 1, duration: 0.5, x: 0, delay: 3.5, stagger: 0.1 }
    );
  }
}

start(animateFrom);
