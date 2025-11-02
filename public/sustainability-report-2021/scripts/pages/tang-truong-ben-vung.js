function animateFrom(element) {
  const { classList } = element;

  if (classList.contains("animation-1")) {
    runAnimation(element, "animate__fadeIn");
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInRight");
  } else if (classList.contains("animation-2")) {
    runAnimation(element, "animate__fadeInDown");
  } else if (classList.contains("animation-3")) {
    gsap.fromTo(
      ".cls-8s, .cls-10",
      {
        opacity: 0,
        scaleY: 0,
        transformOrigin: "50% bottom",
      },
      {
        opacity: 1,
        scaleY: 1,
        duration: 1,
      }
    );

    gsap.from(".cls-9s, .cls-10s, .cls-11, .cls-12", {
      opacity: 0,
      duration: 0.5,
      delay: 1,
    });
  } else if (classList.contains("animation-4")) {
    runAnimation(element, "animate__fadeInUp");
  } else if (classList.contains("animation-5")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeInUp");
    runAnimation(element, "animate__fadeIn");
  } else if (classList.contains("animation-6")) {
    runAnimation(element, "animate__fadeInDown");
  } else if (classList.contains("animation-7")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeInUp");
    runAnimation(element, "animate__zoomIn");
  } else if (classList.contains("animation-8")) {
    runAnimation(element, "animate__fadeInDown");
  } else if (classList.contains("animation-9")) {
    runAnimation(element, "animate__fadeInUp");
  } else if (classList.contains("animation-10")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInUp");
  } else if (classList.contains("animation-11")) {
    runAnimation(element, "animate__fadeIn");
  } else if (classList.contains("animation-12")) {
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInUp");
  }
}

start(animateFrom);
