"use strict";

class Ad extends HTMLElement {
  constructor() {
    super();
    this.banners = [
      {
        desktop: "https://bitcoindata.science/img/bitlist-desktop.gif",
        mobile: "https://bitcoindata.science/img/bitlist-mobile.gif",
        link: "https://bitlist.co/",
        title: "Bilist, list of bitcoin mixers and exchanges",
        alt: "Bitlist"
      },
      {
        desktop: "https://bitcoindata.science/img/mixtum-desktop.gif",
        mobile: "https://bitcoindata.science/img/mixtum-mobile.gif",
        link: "https://mixtum.io/",
        title: "MixTum, your privacy matters, premium bitcoin mixer",
        alt: "MixTum"
      }
    ];
  }

  connectedCallback() {
    // Randomly select a banner
    //const selectedBanner = this.banners[Math.floor(Math.random() * this.banners.length)];

    //Just banner 1
    const selectedBanner = this.banners[1];

    const isDesktop = window.matchMedia('(min-width: 768px)').matches;
    const imgSrc = isDesktop ? selectedBanner.desktop : selectedBanner.mobile;
    const imgWidth = isDesktop ? 1000 : 320;
    const imgHeight = isDesktop ? 75 : 100;

    this.innerHTML = `
      <div class="container text-center my-3 mb-4" id="sp-content">
        <a href="${selectedBanner.link}" 
           title="${selectedBanner.title}" 
           target="_blank" 
           rel="noopener">
          <img class="border-1 border-dark img-fluid rounded-3" 
               alt="${selectedBanner.alt}" 
               src="${imgSrc}" 
               width="${imgWidth}" 
               height="${imgHeight}"
               fetchpriority="high"
               decoding="async" />
        </a>
        <div class="d-flex justify-content-center align-items-center">
          <p class="small mb-0">Sponsored Content</p>
          <button type="button" class="btn-close ms-2" aria-label="Close" title="Click to dismiss"></button>
        </div>
      </div>
    `;

    this.querySelector('.btn-close').addEventListener('click', () => {
      this.querySelector('#sp-content').style.display = 'none';
    });
  }
}

customElements.define('ad-component', Ad);
