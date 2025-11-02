let isMobile = window.matchMedia("only screen and (max-width: 480px)").matches;

if (isMobile) {
  const pathname = window.location.pathname;
  const paths = pathname.split("/");
  const lang = pathname.split("/")[2];
  const page = pathname.split("/")[3];

  if (lang && page) {
    window.location.href = `/sustainability-report-2021/mobile/${lang}/${page}`;
  }
}
