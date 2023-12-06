class Lightbox {
  static init() {
      const apiUrl = '/wp-admin/admin-ajax.php';

      fetch(apiUrl, {
          method: 'POST',
          body: new URLSearchParams({ action: 'request_lightbox' }),
      })
          .then((response) => {
              if (!response.ok) {
                  throw new Error('Network response error.');
              }
              return response.json();
          })
          .then((data) => {
              if (data.posts) {
                  const category = data.category;
                  const reference = data.reference;
                  const gallery = data.posts.map((post) => post.post_thumbnail);

                  document.addEventListener('click', function (e) {
                      if (e.target && e.target.matches('.focusIcon')) {
                          const previews = document.querySelectorAll(".preview");
                          previews.forEach((preview) => {
                              preview.classList.add("hidden");
                          });

                          e.preventDefault();
                          const postPermalink = e.target.getAttribute('href');
                          new Lightbox(postPermalink, gallery, category, reference, data.posts);
                      }
                  });
              } else {
                  console.error('No posts found.');
              }
          })
          .catch((error) => {
              console.error('There was a problem with the fetch operation: ', error);
          });
  }

  constructor(url, images, category, reference, posts) {
      this.element = this.buildDOM(url, category, reference);
      this.images = images;
      this.posts = posts;
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

  buildDOM(url, category, reference) {
      const dom = document.createElement("div");
      dom.classList.add("lightbox");
      dom.innerHTML = `<div class="lightbox">
              <button class="lightbox__close"></button>
              <a class="lightbox__prev svgNavLeft">Précédent</a>
              <a class="lightbox__next svgNavRight">Suivant</a>
              <div class="lightbox__box">
              <div class="lightbox__container">
                <div class="lightbox__loader">
                  <img src="${url}" alt="">
                </div>
              </div>
              <div class="infosPhoto">
                <p>${category}</p>
                <p>${reference}</p>
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
          i = -1;
      }

      const nextImage = this.images[i + 1];
      this.loadImage(nextImage);

      // Update category and reference for the next image
      const nextIndex = this.posts.findIndex((post) => post.post_thumbnail === nextImage);
      const nextCategory = this.posts[nextIndex].post_category;
      const nextReference = this.posts[nextIndex].post_reference;
      this.updateInfo(nextCategory, nextReference);
  }

  prev(e) {
      e.preventDefault();
      let i = this.images.findIndex((image) => image === this.url);
      if (i === 0) {
          i = this.images.length;
      }

      const prevImage = this.images[i - 1];
      this.loadImage(prevImage);

      // Update category and reference for the previous image
      const prevIndex = this.posts.findIndex((post) => post.post_thumbnail === prevImage);
      const prevCategory = this.posts[prevIndex].post_category;
      const prevReference = this.posts[prevIndex].post_reference;
      this.updateInfo(prevCategory, prevReference);
  }

  updateInfo(category, reference) {
      const infoElement = this.element.querySelector('.infosPhoto');
      infoElement.innerHTML = `<p>${category}</p><p>${reference}</p>`;
  }
}

Lightbox.init();
