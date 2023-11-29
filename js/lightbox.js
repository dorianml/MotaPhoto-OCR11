class Lightbox {
  static init() {
// const apiUrl = 'http://localhost:10066/wp-json/wp/v2/photo';

/*Récupérer tout les post */ 
    const previews = Array.from(
      document.querySelectorAll(
        'a[href$="jpeg"], a[href$="png"], a[href$="jpg"]'
      )
    );

    const gallery = previews.map((preview) => preview.getAttribute('href'));
    previews.forEach((preview) =>
      preview.addEventListener("click", (e) => {
        preview.classList.add("hidden");
        e.preventDefault();
        console.log("Clicked on .preview");
        new Lightbox(e.currentTarget.getAttribute("href"), gallery);
      })
    );
  }


  constructor(url, images) {
    this.element = this.buildDOM(url);
    this.images = images;
    this.loadImage(url);
    this.onKeyUp = this.onKeyUp.bind(this);
    document.body.appendChild(this.element);
    document.addEventListener("keyup", this.onKeyUp);
  }

  loadImage(url) {
    this.url = null;
    const image = new Image();
    const container = this.element.querySelector(".lightbox__container");
    const loader = document.createElement("div");
    loader.classList.add("lightbox__loader");
    container.innerHTML = '';
    container.appendChild(loader);
    image.onload = () => {
      container.removeChild(loader);
      container.appendChild(image);
      this.url = url;
    };
    image.src = url;
  }


  /*
            @param {string} url (de l'image)
            @return {HTMLElement} 
            */
  buildDOM(url) {
    const dom = document.createElement("div");
    dom.classList.add("lightbox");
    dom.innerHTML = `<div class="lightbox">
                <button class="lightbox__close"></button>
                <a class="lightbox__prev">Précédent </a>
                <a class="lightbox__next">Suivant</a>
                <div class="lightbox__container">
                  <div class="lightbox__loader">
                    <img src="${url}" alt="">
                  </div>
                </div>
              </div>`;
    dom
      .querySelector(".lightbox__close")
      .addEventListener("click", this.close.bind(this));
    dom
      .querySelector(".lightbox__prev")
      .addEventListener("click", this.prev.bind(this));
    dom
      .querySelector(".lightbox__next")
      .addEventListener("click", this.next.bind(this));
    return dom;
  }

    /* Ferme et navigue dans la lightbox */
    close(e) {
      e.preventDefault();
      this.element.classList.add("fadeOut");
      window.setTimeout(() => {
        this.element.parentElement.removeChild(this.element);
      }, 500);
      document.removeEventListener("keyup", this.onKeyUp);
      const previews = document.querySelectorAll(".preview");
      previews.forEach((preview) => preview.classList.remove("hidden"));
    }
  
    onKeyUp(e) {
      if (e.key === "Escape") {
        this.close(e);
        const previews = document.querySelectorAll(".preview");
        previews.forEach((preview) => preview.classList.remove("hidden"));
      }
    }
  
    next(e) {
      e.preventDefault();
      let i = this.images.findIndex((image) => image === this.url);
      if (i === this.images.length - 1) {
          i = -1
      }
      this.loadImage(this.images[i + 1]);
    }
    prev(e) {
      e.preventDefault();
      let i = this.images.findIndex((image) => image === this.url);
      if (i === 0) {
          i = this.images.length;
      }
      this.loadImage(this.images[i - 1]);
  }

}

Lightbox.init();
