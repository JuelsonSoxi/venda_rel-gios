import { Injectable, computed, signal } from '@angular/core';

export interface Product {
  id: string; name: string; brand: string; price: number; was?: number;
  img: string; tag?: string; strap: 'Couro' | 'Aço'; specs: string[];
}

export const PRODUCTS: Product[] = [
  { id: 'p692', name: 'Poedagar 692 Cronógrafo', brand: 'Poedagar', price: 17000, was: 25000, img: 'img/poedagar-692.jpg', tag: 'Promoção', strap: 'Couro',
    specs: ['Cronógrafo desportivo', 'Ponteiros luminosos', 'Impermeável 30 m', 'Couro genuíno'] },
  { id: 'azul', name: 'Poedagar Azul Rosé', brand: 'Poedagar', price: 18000, img: 'img/poedagar-azul.jpg', tag: 'Mais pedido', strap: 'Couro',
    specs: ['Movimento de quartzo', 'À prova de água 3ATM', 'Vidro Hardlex', 'Calendário no mostrador'] },
  { id: 'aco', name: 'Poedagar Aço Clássico', brand: 'Poedagar', price: 18000, img: 'img/poedagar-aco.jpg', strap: 'Aço',
    specs: ['Pulseira em aço inoxidável', 'Mostrador preto texturado', 'Movimento de quartzo', 'Data no mostrador'] },
  { id: 'bin', name: 'Binbond Ouro e Prata', brand: 'Binbond', price: 18000, img: 'img/binbond.jpg', tag: 'Elegante', strap: 'Aço',
    specs: ['Dia e data', 'Mostrador com cristais', 'Resistente e durável', 'Movimento de quartzo'] },
  { id: 'dg', name: 'Dazzling Grafite', brand: 'Dazzling', price: 16000, img: 'img/dazzling-grafite.jpg', strap: 'Couro',
    specs: ['Movimento de quartzo', 'Vidro mineral endurecido', 'Caixa em liga metálica', 'Calendário'] },
  { id: 'da', name: 'Dazzling Areia', brand: 'Dazzling', price: 16000, img: 'img/dazzling-areia.jpg', strap: 'Couro',
    specs: ['Movimento de quartzo', 'Vidro mineral endurecido', 'Caixa em liga metálica', 'Calendário'] },
];

export interface Line { p: Product; qty: number }

@Injectable({ providedIn: 'root' })
export class Cart {
  readonly lines = signal<Line[]>([]);
  readonly open = signal(false);
  readonly count = computed(() => this.lines().reduce((n, l) => n + l.qty, 0));
  readonly total = computed(() => this.lines().reduce((n, l) => n + l.qty * l.p.price, 0));

  add(p: Product) {
    this.lines.update(ls => ls.some(l => l.p.id === p.id)
      ? ls.map(l => l.p.id === p.id ? { ...l, qty: l.qty + 1 } : l) : [...ls, { p, qty: 1 }]);
    this.open.set(true);
  }
  step(id: string, d: number) {
    this.lines.update(ls => ls.map(l => l.p.id === id ? { ...l, qty: l.qty + d } : l).filter(l => l.qty > 0));
  }
  whatsappUrl(name: string, zone: string) {
    const rows = this.lines().map(l => `• ${l.qty}x ${l.p.name} – ${kz(l.qty * l.p.price)}`).join('\n');
    const msg = `Olá MLH Store! Quero encomendar:\n${rows}\nTotal: ${kz(this.total())}\nNome: ${name || '-'}\nZona de entrega: ${zone || '-'}`;
    return `https://wa.me/244931993767?text=${encodeURIComponent(msg)}`;
  }
}

export const kz = (n: number) => n.toLocaleString('pt-PT').replace(/\u00a0/g, '.').replace(/\s/g, '.') + ' Kz';
