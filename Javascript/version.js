window.addEventListener('DOMContentLoaded', function () {
    const version = 'v=' + new Date().getTime();
    const links = document.querySelectorAll('link[rel="stylesheet"], script[src]');
    
    links.forEach((link) => {
      if (link.href) {
        link.href += '?' + version;
      }
      if (link.src) {
        link.src += '?' + version;
      }
    });
  });
  