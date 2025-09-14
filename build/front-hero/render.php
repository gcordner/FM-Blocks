<?php
$desktop = FM_BLOCKS_ASSETS_URL . 'front-hero/desktop.webp';
$mobile  = FM_BLOCKS_ASSETS_URL . 'front-hero/mobile.webp';
?>
<section class="fm-front-hero" style="--fh-desktop:6/4;--fh-mobile:4/6;">
  <picture class="fm-front-hero__media">
    <source media="(max-width: 767px)" srcset="<?php echo esc_url($mobile); ?>" sizes="100vw">
    <source media="(min-width: 768px)" srcset="<?php echo esc_url($desktop); ?>" sizes="100vw">
    <img src="<?php echo esc_url($desktop); ?>" alt="" loading="eager" fetchpriority="high" decoding="async">
  </picture>

  <!-- <style>
    .fm-front-hero__media {
      display: block;
      width: 100%;
      aspect-ratio: var(--fh-desktop, 6/4);
      overflow: hidden;
    }
    .fm-front-hero__media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    @media (max-width: 767px) {
      .fm-front-hero__media {
        aspect-ratio: var(--fh-mobile, 4/5);
      }
    }
  </style> -->

  <!-- <style>
    .fm-front-hero__media {
      display: block;
      width: 100%;
      aspect-ratio: var(--fh-desktop, 6/4);
      overflow: hidden;
    }
    .fm-front-hero__media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    @media (min-width: 768px) {
      .fm-front-hero__media {
        width: 100vw;
        margin-left: calc(50% - 50vw);
      }
    }
    @media (max-width: 767px) {
      .fm-front-hero__media {
        aspect-ratio: var(--fh-mobile, 4/5);
      }
    }
  </style> -->

  <!-- <style>
    .fm-front-hero__media {
      display: block;
      width: 100vw;
      margin-left: calc(50% - 50vw);
      overflow: hidden;
    }
    .fm-front-hero__media {
      aspect-ratio: var(--fh-desktop, 6/4);
    }
    .fm-front-hero__media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    @media (max-width: 767px) {
      .fm-front-hero__media {
        aspect-ratio: var(--fh-mobile, 4/5);
      }
    }
  </style> -->

  <style>
    .fm-front-hero__media {
      display: block;
      width: 100%;
      aspect-ratio: var(--fh-desktop, 6/4);
      overflow: hidden;
    }
    .fm-front-hero__media img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    @media (max-width: 767px) {
      .fm-front-hero__media {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        aspect-ratio: var(--fh-mobile, 4/5);
      }
    }
  </style>
</section>                                             
</section>