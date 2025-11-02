function animateFrom(element) {
  const { classList } = element;

  if (classList.contains("animation-1")) {
    runAnimation(element, "animate__fadeIn");
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInRight");
    runAnimation(element, "animate__fadeInRight");
  } else if (classList.contains("animation-2")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeIn");
    runAnimation(element, "animate__fadeInRight");
    runAnimation(element, "animate__fadeInUp");
  } else if (
    classList.contains("animation-3") ||
    classList.contains("animation-4")
  ) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeInUp");
    runAnimation(element, "animate__fadeIn");
  } else if (classList.contains("animation-5")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeIn");
    runAnimation(element, "animate__fadeInUp");
  } else if (classList.contains("animation-6")) {
    runAnimation(element, "animate__fadeInUp");
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeIn");
  } else if (classList.contains("animation-7")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInRight");
    runAnimation(element, "animate__fadeIn");
    runAnimation(element, "animate__fadeInUp");
  }
}

start(animateFrom);
