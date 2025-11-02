//********** sticky header **********
const headerContent = document.querySelector(".header");
let lastScrollY = window.scrollY;
let timer = null;

window.addEventListener("scroll", function () {
  clearTimeout(timer);
  if (lastScrollY < window.scrollY || window.scrollY === 0) {
    headerContent.classList.remove("show");
  } else {
    timer = setTimeout(() => {
      headerContent.classList.add("show");
    }, 50);
  }

  lastScrollY = window.scrollY;
});

//********** counter-up **********

const counterUp = (classElement = ".counter-up") => {
  const isEN = window.location.pathname.indexOf("/en/") !== -1 ? true : false;

  if (isEN) {
    $(classElement).each(function () {
      let countTo = $(this).attr("data-count").replace(/\,/g, "");
      let decimal = 0;
      let isFloat = false;
      if (countTo.indexOf(".") > 0) {
        decimal = countTo.toString().split(".")[1].length;
        isFloat = true;
      }
      $(this).animate(
        {
          Counter: countTo,
        },
        {
          duration: 2000,
          easing: "linear",
          step: function (now) {
            if (isFloat) {
              $(this).text(
                parseFloat(now).toFixed(decimal).replace(/\,/g, ".")
              );
            } else {
              $(this).text(
                Math.floor(now).toLocaleString(undefined).replace(/\./g, ",")
              );
            }
          },
        }
      );
    });
  } else {
    $(classElement).each(function () {
      let countTo = $(this).attr("data-count").replace(/\./g, "");
      let decimal = 0;
      let isFloat = false;
      if (countTo.indexOf(",") > 0) {
        decimal = countTo.toString().split(",")[1].length;
        countTo = $(this).attr("data-count").replace(/\,/g, ".");
        isFloat = true;
      }
      $(this).animate(
        {
          Counter: countTo,
        },
        {
          duration: 2000,
          easing: "linear",
          step: function (now) {
            if (isFloat) {
              $(this).text(
                parseFloat(now).toFixed(decimal).replace(/\./g, ",")
              );
            } else {
              $(this).text(
                Math.floor(now).toLocaleString(undefined).replace(/\,/g, ".")
              );
            }
          },
        }
      );
    });
  }
};

// ********** animation **********

const animates = {
  animate__fadeIn: {
    from: { opacity: 0 },
    to: {
      duration: 1,
      opacity: 1,
    },
  },
  animate__fadeInRight: {
    from: {
      x: "100%",
      opacity: 0,
    },
    to: {
      duration: 1,
      x: 0,
      opacity: 1,
    },
  },
  animate__fadeInLeft: {
    from: {
      x: "-100%",
      opacity: 0,
    },
    to: {
      duration: 1,
      x: 0,
      opacity: 1,
    },
  },
  animate__fadeInDown: {
    from: {
      y: "-100%",
      opacity: 0,
    },
    to: {
      duration: 1,
      y: 0,
      opacity: 1,
    },
  },
  animate__fadeInUp: {
    from: {
      y: "100%",
      opacity: 0,
    },
    to: {
      duration: 1,
      y: 0,
      opacity: 1,
    },
  },
  animate__zoomIn: {
    from: {
      scale: 0.3,
      opacity: 0,
    },
    to: {
      scale: 1,
      opacity: 1,
      duration: 1,
    },
  },
  animate__chartBarTop: {
    from: {
      opacity: 0,
      scaleY: 0,
      transformOrigin: "top",
    },
    to: {
      opacity: 1,
      scaleY: 1,
      duration: 1,
    },
  },
  animate__chartBarBottom: {
    from: {
      opacity: 0,
      scaleY: 0,
      transformOrigin: "bottom",
    },
    to: {
      opacity: 1,
      scaleY: 1,
      duration: 1,
    },
  },
  animate__chartBarRight: {
    from: {
      opacity: 0,
      scaleX: 0,
      transformOrigin: "right",
    },
    to: {
      opacity: 1,
      scaleX: 1,
      duration: 1,
    },
  },
  animate__chartBarLeft: {
    from: {
      opacity: 0,
      scaleX: 0,
      transformOrigin: "left",
    },
    to: {
      opacity: 1,
      scaleX: 1,
      duration: 1,
    },
  },
  animate__draw: {
    from: {
      opacity: 0,
      drawSVG: 0,
    },
    to: {
      opacity: 1,
      drawSVG: true,
      duration: 1,
    },
  },
};

const setAnimationChartCirclePage5 = () => {
  gsap.set("#circle-1, #circle-2, #circle-3, #circle-4, #circle-5, #circle-6", {
    drawSVG: 0,
    opacity: 0,
    rotation: -120,
    transformOrigin: "center center",
  });
};

const toAnimationChartCirclePage5 = () => {
  gsap
    .timeline({
      defaults: { duration: 1 },
    })
    .to("#circle-1", { opacity: 1, drawSVG: "0% 4.26%" })
    .to("#circle-2", { opacity: 1, drawSVG: "4.26% 6.89%" }, 0)
    .to("#circle-3", { opacity: 1, drawSVG: "6.89% 18.02%" }, 0)
    .to("#circle-4", { opacity: 1, drawSVG: "18.02% 41.37%" }, 0)
    .to("#circle-5", { opacity: 1, drawSVG: "41.37% 86.33%" }, 0)
    .to("#circle-6", { opacity: 1, drawSVG: "86.33% 100%" }, 0);
};

const setAnimationChartCirclePage6_1 = () => {
  gsap.set("#circle-1, #circle-2, #circle-3, #circle-4", {
    drawSVG: 0,
    opacity: 0,
    rotation: -180,
    transformOrigin: "center center",
  });
};

const toAnimationChartCirclePage6_1 = () => {
  gsap
    .timeline({
      defaults: { duration: 1 },
    })
    .to("#circle-1", { opacity: 1, drawSVG: "0% 26.44%" })
    .to("#circle-2", { opacity: 1, drawSVG: "26.44% 70.86%" }, 0)
    .to("#circle-3", { opacity: 1, drawSVG: "70.86% 93.7%" }, 0)
    .to("#circle-4", { opacity: 1, drawSVG: "93.7% 100%" }, 0);
};

const setAnimationChartCirclePage6_2 = () => {
  gsap.set(
    "#circle-2-1, #circle-2-2, #circle-2-3, #circle-2-4, #circle-2-5, #circle-2-6",
    {
      drawSVG: 0,
      opacity: 0,
      rotation: -100,
      transformOrigin: "center center",
    }
  );
};

const toAnimationChartCirclePage6_2 = () => {
  gsap
    .timeline({
      defaults: { duration: 1 },
    })
    .to("#circle-2-1", { opacity: 1, drawSVG: "0% 2.74%" })
    .to("#circle-2-2", { opacity: 1, drawSVG: "2.74% 3.79%" }, 0)
    .to("#circle-2-3", { opacity: 1, drawSVG: "3.79% 4.49%" }, 0)
    .to("#circle-2-4", { opacity: 1, drawSVG: "4.49% 78.65%" }, 0)
    .to("#circle-2-5", { opacity: 1, drawSVG: "78.65% 88.08%" }, 0)
    .to("#circle-2-6", { opacity: 1, drawSVG: "88.08% 100%" }, 0);
};

const setAnimationChartCirclePage6_3 = () => {
  gsap.set("#circle-3-1, #circle-3-2, #circle-3-3, #circle-3-4", {
    drawSVG: 0,
    opacity: 0,
    rotation: -140,
    transformOrigin: "center center",
  });
};

const toAnimationChartCirclePage6_3 = () => {
  gsap
    .timeline({
      defaults: { duration: 1 },
    })
    .to("#circle-3-1", { opacity: 1, drawSVG: "0% 15%" })
    .to("#circle-3-2", { opacity: 1, drawSVG: "15% 36%" }, 0)
    .to("#circle-3-3", { opacity: 1, drawSVG: "36% 93%" }, 0)
    .to("#circle-3-4", { opacity: 1, drawSVG: "93% 100%" }, 0);
};

//
const runAnimation = (element, classAnimation) => {
  $(element)
    .find(`.${classAnimation}`)
    .each(function (index, ele) {
      const { from, to } = animates[classAnimation];
      const delay = $(this).data("delay") || 0;
      const duration = $(this).data("duration") || 0;
      gsap.fromTo(
        $(this),
        { ...from },
        { ...to, delay, duration: duration || to.duration }
      );
    });
};

const setAnimation = (element) => {
  if ($(element).hasClass("chart-circle")) {
    setAnimationChartCirclePage5();
  } else if ($(element).hasClass("chart-circle-page-6-1")) {
    setAnimationChartCirclePage6_1();
  } else if ($(element).hasClass("chart-circle-page-6-2")) {
    setAnimationChartCirclePage6_2();
  } else if ($(element).hasClass("chart-circle-page-6-3")) {
    setAnimationChartCirclePage6_3();
  }

  $(element)
    .find(".animation")
    .each(function () {
      const animate = $(this).data("animate");
      const from = $(this).data("from") || {};
      gsap.set(this, { ...animates[animate].from, ...from });
    });
};

const toAnimation = (element) => {
  if ($(element).hasClass("chart-circle")) {
    toAnimationChartCirclePage5();
  } else if ($(element).hasClass("chart-circle-page-6-1")) {
    toAnimationChartCirclePage6_1();
  } else if ($(element).hasClass("chart-circle-page-6-2")) {
    toAnimationChartCirclePage6_2();
  } else if ($(element).hasClass("chart-circle-page-6-3")) {
    toAnimationChartCirclePage6_3();
  }

  if ($(element).find(".counter-up").length) {
    counterUp();
  } else if ($(element).find(".counter-up-2").length) {
    counterUp(".counter-up-2");
  } else if ($(element).find(".counter-up-3").length) {
    counterUp(".counter-up-3");
  }

  $(element)
    .find(".animation")
    .each(function () {
      const animate = $(this).data("animate");
      const to = $(this).data("to") || {};

      const duration = $(this).data("duration") || 1;
      const delay = $(this).data("delay") || 0;
      gsap.to(this, {
        ...animates[animate].to,
        ...to,
        duration,
        delay,
      });
    });
};

// ********** start **********
const start = (animate) => {
  let options = {
    root: null,
    rootMargin: "-150px",
    threshold: 0,
  };

  const callback = (entries, observer) => {
    entries.forEach((entry) => {
      const { target, isIntersecting } = entry;
      if (isIntersecting && !target.classList.contains("animated")) {
        target.classList.add("animated");
        animate(target);
      }
    });
  };

  const observer = new IntersectionObserver(callback, options);

  const sections = [...document.querySelectorAll(".gs_reveal")];

  sections.forEach((section, index) => {
    observer.observe(section);
  });
};

$("#with-warrenty").on("change", function () {
  const url = $(this).data("url");

  if (url) {
    window.location.href = `/sustainability-report-2021/${url}.html`;
  }
});

$(".gs_reveal").each(function () {
  setAnimation(this);
});

//   start((element) => toAnimation(element));
//   // gsap.registerPlugin(ScrollTrigger);
//   // gsap.utils.toArray(".gs_reveal").forEach(function (element) {
//   //   ScrollTrigger.create({
//   //     trigger: element,
//   //     // markers: true,
//   //     once: true,
//   //     start: "top 80%",
//   //     end: "bottom 10%",
//   //     onEnter: function () {
//   //       toAnimation(element);
//   //     },
//   //   });
//   // });
