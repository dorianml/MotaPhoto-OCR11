class Lightbox {
    static instances = [];

    static init() {
        const previews = document.querySelectorAll('.preview');
        previews.forEach(preview => preview.addEventListener('click', e => {
            preview.classList.add('hidden')
            e.preventDefault();
            console.log('Clicked on .preview');
            new Lightbox(e.currentTarget.getAttribute('href'));
        }));
    }
/*    
    @param {string} url (de l'image)
    */
    constructor(url) {
        Lightbox.instances.push(this);
        this.element = this.buildDOM(url);
        this.loadImage(url);
        this.onKeyUp = this.onKeyUp.bind(this);
        document.body.appendChild(this.element);
        document.addEventListener('keyup', this.onKeyUp);
    }

    loadImage(url) {
        const image = new Image();
        const container = this.element.querySelector('.lightbox__container');
        const loader = document.createElement('div');
        loader.classList.add('lightbox__loader');
        container.appendChild(loader);
        image.onload = () => {
            container.removeChild(loader);
            container.appendChild(image);
        };
        image.src = url;
    }

    /* Ferme la lightbox */
    close(e) {
        e.preventDefault();
        Lightbox.instances.forEach(instance => {
            instance.element.classList.add('fadeOut');
            window.setTimeout(() => {
                instance.element.parentElement.removeChild(instance.element);
            }, 500);
        });
        document.removeEventListener('keyup', this.onKeyUp);
        const previews = document.querySelectorAll('.preview');
        previews.forEach(preview => preview.classList.remove('hidden'));
    }

    onKeyUp(e) {
        if (e.key === 'Escape') {
            this.close(e);
            const previews = document.querySelectorAll('.preview');
        previews.forEach(preview => preview.classList.remove('hidden'));
        }
    }

    /*
    @param {string} url (de l'image)
    @return {HTMLElement} 
    */
    buildDOM(url) {
        const dom = document.createElement('div');
        dom.classList.add('lightbox');
        dom.innerHTML = `<div class="lightbox">
        <button class="lightbox__close"></button>
        <a href="<?php next_post_link('%link', '→'); ?>" class="lightbox__next">Suivant</a>
        <a href="<?php previous_post_link('%link', '←'); ?>" class="lightbox__prev">Précédent</a>
        <div class="lightbox__container">
          <div class="lightbox__loader">
            <img src="${url}" alt="">
          </div>
        </div>
      </div>`;
        dom.querySelector('.lightbox__close').addEventListener('click', this.close.bind(this));
        return dom;
    }
}

Lightbox.init();
