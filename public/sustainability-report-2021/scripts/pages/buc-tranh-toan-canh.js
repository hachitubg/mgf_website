function animateFrom(element) {
  const { classList } = element;

  if (classList.contains("animation-1")) {
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__zoomIn");
  } else if (classList.contains("animation-2")) {
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeIn");
    runAnimation(element, "animate__fadeInRight");
  } else if (classList.contains("animation-3")) {
    runAnimation(element, "animate__fadeInLeft");
    runAnimation(element, "animate__fadeInRight");
  } else if (classList.contains("animation-4")) {
    runAnimation(element, "animate__fadeInDown");
    counterUp();
  } else if (classList.contains("animation-5")) {
    runAnimation(element, "animate__fadeInDown");
    runAnimation(element, "animate__fadeInUp");
  }
}

start(animateFrom);

// gsap.registerPlugin(ScrollTrigger);

// gsap.utils.toArray(".gs_reveal").forEach(function (element) {
//   ScrollTrigger.create({
//     trigger: element,
//     // markers: true,
//     once: true,
//     start: "top 80%",
//     end: "bottom 10%",
//     onEnter: function () {
//       animateFrom(element);
//     },
//   });
// });
