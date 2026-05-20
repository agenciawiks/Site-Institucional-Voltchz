/**
 * VoltchZ Brasil — Página Sobre
 * Mapa de presença (OpenStreetMap + Leaflet) e lista de cidades atendidas.
 */

import { CIDADES_PRESENCA } from '../data/cidades-presenca.js';

function initMapaPresenca() {
  const mapEl = document.getElementById('map-presenca');
  if (!mapEl || typeof L === 'undefined') return;

  const map = L.map(mapEl, {
    scrollWheelZoom: false,
    attributionControl: true
  });

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  const icon = L.divIcon({
    className: 'presenca-marker',
    html: '',
    iconSize: [14, 14],
    iconAnchor: [7, 7]
  });

  const bounds = L.latLngBounds();

  CIDADES_PRESENCA.forEach((cidade) => {
    const latLng = [cidade.lat, cidade.lng];
    bounds.extend(latLng);
    L.marker(latLng, { icon })
      .addTo(map)
      .bindPopup(`<strong>${cidade.nome}</strong><br>${cidade.uf}`);
  });

  map.fitBounds(bounds, { padding: [40, 40], maxZoom: 10 });

  const resizeObserver = new ResizeObserver(() => {
    map.invalidateSize();
  });
  resizeObserver.observe(mapEl);

  const sectionObserver = new IntersectionObserver(
    (entries) => {
      if (entries.some((e) => e.isIntersecting)) {
        map.invalidateSize();
        sectionObserver.disconnect();
      }
    },
    { threshold: 0.1 }
  );
  sectionObserver.observe(mapEl);
}

document.addEventListener('DOMContentLoaded', () => {
  initMapaPresenca();
});
