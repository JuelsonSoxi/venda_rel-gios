import { Component, computed, signal, OnDestroy } from '@angular/core';
import { Cart, PRODUCTS, Product, kz } from './products';

@Component({
  selector: 'app-root',
  template: `
<header class="top">
  <a class="brand" href="#topo"><span class="mono">MLH</span><span>Store Angola</span></a>
  <nav><a href="#catalogo">Relógios</a><a href="#video">Em pulso</a><a href="#contacto">Contacto</a></nav>
  <button class="bag" (click)="cart.open.set(true)" aria-label="Abrir carrinho">Carrinho <b>{{ cart.count() }}</b></button>
</header>

<main id="topo">
  <section class="hero">
    <div class="hero-text">
      <h1>O detalhe<br>muda tudo.</h1>
      <p>Relógios masculinos com entrega em Luanda. Qualidade, estilo e confiança a partir de {{ kz(16000) }}.</p>
      <div class="cta"><a class="btn gold" href="#catalogo">Ver relógios</a>
        <a class="btn ghost" href="https://wa.me/244953468288" target="_blank" rel="noopener">Falar no WhatsApp</a></div>
    </div>
    <div class="clock" role="img" aria-label="Relógio analógico com a hora atual">
      <svg viewBox="-100 -100 200 200">
        <circle r="96" class="bezel"/><circle r="86" class="face"/>
        @for (t of ticks; track t) { <line x1="0" y1="-80" x2="0" [attr.y2]="t % 5 ? -76 : -70" [attr.transform]="'rotate(' + t * 6 + ')'" [class.major]="!(t % 5)"/> }
        <text y="-52" text-anchor="middle" class="brandtxt">MLH</text>
        <line class="h" y2="-45" [attr.transform]="'rotate(' + hDeg() + ')'"/>
        <line class="m" y2="-70" [attr.transform]="'rotate(' + mDeg() + ')'"/>
        <line class="s" y2="-78" y1="12" [attr.transform]="'rotate(' + sDeg() + ')'"/>
        <circle r="4" class="pin"/>
      </svg>
    </div>
  </section>

  <div class="strip"><span>Entrega em toda Luanda</span><span>Pagamento na entrega</span><span>Pulseiras em couro premium</span><span>Vidro endurecido</span></div>

  <section id="catalogo" class="wrap">
    <div class="head"><h2>A coleção</h2>
      <div class="chips">@for (f of filters; track f) {
        <button [class.on]="filter() === f" (click)="filter.set(f)">{{ f }}</button> }</div></div>
    <div class="grid">
      @for (p of shown(); track p.id) {
        <article class="card">
          <div class="ph"><img [src]="p.img" [alt]="p.name" loading="lazy">
            @if (p.tag) { <em>{{ p.tag }}</em> }</div>
          <div class="info">
            <small>{{ p.brand }} · Pulseira em {{ p.strap.toLowerCase() }}</small>
            <h3>{{ p.name }}</h3>
            <p class="price">{{ kz(p.price) }} @if (p.was) { <s>{{ kz(p.was) }}</s> }</p>
            <button class="link" (click)="view.set(p)">Ver detalhes</button>
            <button class="btn gold sm" (click)="cart.add(p)">Adicionar ao carrinho</button>
          </div>
        </article>
      }
    </div>
  </section>

  <section id="video" class="show">
    <div class="wrap two">
      <video src="hero.mp4" muted loop playsinline autoplay></video>
      <div><h2>Feito para ser visto no pulso.</h2>
        <p>Cada relógio é testado antes de sair da loja. O que vês nas fotos é o que chega às tuas mãos, com caixa de oferta incluída.</p>
        <video class="v2" src="showcase.mp4" muted loop playsinline autoplay></video></div>
    </div>
  </section>

  <section class="wrap steps">
    <h2>Encomendar é simples</h2>
    <ol><li><b>Escolhe</b> os relógios e junta ao carrinho.</li><li><b>Envia</b> o pedido pelo WhatsApp.</li><li><b>Recebe</b> em Luanda e paga na entrega.</li></ol>
  </section>
</main>

<footer id="contacto">
  <div class="wrap fgrid">
    <div><span class="mono">MLH</span><p>O teu estilo, a tua marca.</p></div>
    <div><h4>Ligações</h4><a href="tel:+244931993767">931 993 767</a></div>
    <div><h4>WhatsApp</h4><a href="https://wa.me/244953468288" target="_blank" rel="noopener">953 468 288</a></div>
    <div><h4>Loja</h4><p>Luanda, Bairro Popular, por trás do Cemitério da Santana.</p></div>
  </div>
</footer>

@if (view(); as p) {
  <div class="scrim" (click)="view.set(null)"></div>
  <div class="modal" role="dialog" aria-modal="true" [attr.aria-label]="p.name">
    <button class="x" (click)="view.set(null)" aria-label="Fechar">×</button>
    <img [src]="p.img" [alt]="p.name">
    <div><small>{{ p.brand }}</small><h3>{{ p.name }}</h3><p class="price">{{ kz(p.price) }}</p>
      <ul>@for (s of p.specs; track s) { <li>{{ s }}</li> }</ul>
      <button class="btn gold" (click)="cart.add(p); view.set(null)">Adicionar ao carrinho</button></div>
  </div>
}

@if (cart.open()) {
  <div class="scrim" (click)="cart.open.set(false)"></div>
  <aside class="drawer" aria-label="Carrinho">
    <div class="dh"><h3>O teu carrinho</h3><button class="x" (click)="cart.open.set(false)" aria-label="Fechar">×</button></div>
    @if (!cart.lines().length) { <p class="empty">Ainda não escolheste nenhum relógio. Vê a coleção e adiciona o que gostares.</p> }
    @for (l of cart.lines(); track l.p.id) {
      <div class="line"><img [src]="l.p.img" alt="">
        <div><b>{{ l.p.name }}</b><span>{{ kz(l.p.price * l.qty) }}</span></div>
        <div class="qty"><button (click)="cart.step(l.p.id, -1)" aria-label="Menos">−</button>{{ l.qty }}<button (click)="cart.step(l.p.id, 1)" aria-label="Mais">+</button></div></div>
    }
    @if (cart.lines().length) {
      <div class="form"><input placeholder="O teu nome" [value]="name()" (input)="name.set($any($event.target).value)">
        <input placeholder="Zona de entrega em Luanda" [value]="zone()" (input)="zone.set($any($event.target).value)"></div>
      <div class="total"><span>Total</span><b>{{ kz(cart.total()) }}</b></div>
      <a class="btn gold" [href]="cart.whatsappUrl(name(), zone())" target="_blank" rel="noopener">Enviar pedido no WhatsApp</a>
    }
  </aside>
}`,
})
export class App implements OnDestroy {
  kz = kz;
  readonly filters = ['Todos', 'Couro', 'Aço'];
  readonly filter = signal('Todos');
  readonly view = signal<Product | null>(null);
  readonly name = signal(''); readonly zone = signal('');
  readonly shown = computed(() => PRODUCTS.filter(p => this.filter() === 'Todos' || p.strap === this.filter()));
  readonly ticks = Array.from({ length: 60 }, (_, i) => i);
  private now = signal(new Date());
  private timer = setInterval(() => this.now.set(new Date()), 1000);
  sDeg = computed(() => this.now().getSeconds() * 6);
  mDeg = computed(() => this.now().getMinutes() * 6 + this.now().getSeconds() / 10);
  hDeg = computed(() => (this.now().getHours() % 12) * 30 + this.now().getMinutes() / 2);
  constructor(public cart: Cart) {}
  ngOnDestroy() { clearInterval(this.timer); }
}
