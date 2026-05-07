/**
 * Integração com Mapas (Leaflet + OpenStreetMap)
 */
import { $, debounce } from '../utils/dom.js';
import { CONFIG } from '../config.js';

export const initMap = () => {
  const findBtn = $('#find-charger-btn');
  const status = $('#charger-status');
  const mapContainer = $('#map');
  const loader = $('#map-loader');
  
  if (!mapContainer) return;

  const hideLoader = () => {
    if (loader) {
      loader.classList.add('opacity-0');
      setTimeout(() => {
        loader.style.display = 'none';
        mapContainer.classList.remove('opacity-0');
      }, 500);
    } else {
      mapContainer.classList.remove('opacity-0');
    }
  };

  if (typeof L === 'undefined') {
    console.error('Leaflet não carregado.');
    if (status) status.textContent = 'Erro: Biblioteca de mapas indisponível.';
    hideLoader();
    return;
  }

  let map;
  try {
    map = L.map('map', {
      zoomControl: true,
      scrollWheelZoom: true
    }).setView([-23.55, -46.63], 8); // Centralizado em SP com zoom mais aberto
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    setTimeout(hideLoader, 400);
  } catch (err) {
    console.error('Erro ao inicializar o mapa:', err);
    if (status) status.textContent = 'Erro ao inicializar o mapa.';
    hideLoader();
    return;
  }

  const markerGroup = L.layerGroup().addTo(map);

  const chargerIcon = L.divIcon({
    html: `
      <div class="relative flex items-center justify-center">
        <div class="absolute w-6 h-6 bg-brand-green/20 rounded-full animate-ping"></div>
        <svg class="w-6 h-6 text-brand-green drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
        </svg>
      </div>
    `,
    className: '',
    iconSize: [24, 24],
    iconAnchor: [12, 24],
    popupAnchor: [0, -24]
  });

  let lastSearchPos = null;
  let lastZoom = null;
  const seenCoords = new Set();

  const renderMarkers = (data, source) => {
    const isOCM = source === 'ocm';
    const elements = Array.isArray(data) ? data : (data.elements || []);
    
    elements.forEach(poi => {
      const lat = isOCM ? poi.AddressInfo?.Latitude : (poi.lat || poi.center?.lat);
      const lon = isOCM ? poi.AddressInfo?.Longitude : (poi.lon || poi.center?.lon);
      
      if (!lat || !lon) return;

      const coordKey = `${lat.toFixed(4)},${lon.toFixed(4)}`;
      if (seenCoords.has(coordKey)) return;
      seenCoords.add(coordKey);

      const title = isOCM ? (poi.AddressInfo.Title || 'Eletroposto') : (poi.tags?.name || 'Posto de Recarga');
      const operator = isOCM ? (poi.OperatorInfo?.Title || 'Rede Local') : (poi.tags?.operator || 'OSM');
      const info = isOCM ? (poi.Connections?.map(c => c.ConnectionType?.Title).join(', ') || '') : (poi.tags?.capacity ? `${poi.tags.capacity} vagas` : '');

      L.marker([lat, lon], { icon: chargerIcon })
        .addTo(markerGroup)
        .bindPopup(`
          <div class="font-outfit p-1 min-w-[160px]">
            <strong class="text-brand-bg block border-b border-slate-100 pb-1 mb-1">${title}</strong>
            <span class="text-[10px] text-brand-green font-bold uppercase block mb-1">${operator}</span>
            ${info ? `<span class="text-[9px] text-slate-500 block mb-2">${info}</span>` : ''}
            <a href="https://www.google.com/maps/search/?api=1&query=${lat},${lon}" target="_blank" class="block mt-2 text-center bg-blue-50 py-1.5 rounded-lg text-[9px] font-bold text-blue-600 uppercase hover:bg-blue-100 transition-colors">Como Chegar</a>
          </div>
        `);
    });
  };

  const searchChargers = async () => {
    const zoom = map.getZoom();
    const center = map.getCenter();
    
    if (lastZoom !== null && Math.abs(lastZoom - zoom) > 1) {
      markerGroup.clearLayers();
      seenCoords.clear();
    }
    lastZoom = zoom;

    if (lastSearchPos && center.distanceTo(lastSearchPos) < 2000 && zoom === lastZoom) return;
    lastSearchPos = center;

    if (zoom < 6) {
      if (status) status.textContent = 'Aproxime para buscar.';
      return;
    }

    if (status) status.textContent = 'Buscando novos pontos...';

    const bounds = map.getBounds();
    const bbox = `${bounds.getSouth()},${bounds.getWest()},${bounds.getNorth()},${bounds.getEast()}`;
    const sw = bounds.getSouthWest();
    const ne = bounds.getNorthEast();

    const osmQuery = zoom < 10 
      ? `[out:json][timeout:15];node["amenity"="charging_station"](${bbox});out qt;`
      : `[out:json][timeout:25];(node["amenity"~"charging_station|fuel"]["fuel:electricity"~"yes|"](${bbox});node["socket:type2"](${bbox});node["socket:ccs2"](${bbox}););out center;`;

    const ocmUrl = `https://api.openchargemap.io/v3/poi/?output=json&maxresults=100&compact=true&boundingbox=(${sw.lat},${sw.lng}),(${ne.lat},${ne.lng})&key=1e204c3c-8e3d-4c3e-8c3e-8c3e8c3e8c3e`;

    fetch(ocmUrl).then(res => res.json()).then(data => {
      renderMarkers(data, 'ocm');
      if (status) status.textContent = 'Mapa atualizado.';
    }).catch(() => {});

    fetch(`${CONFIG.MAP.OVERPASS_URL}?data=${encodeURIComponent(osmQuery)}`).then(res => res.json()).then(data => {
      renderMarkers(data, 'osm');
      if (status) status.textContent = 'Busca concluída.';
    }).catch(() => {});
  };

  const debouncedSearch = debounce(searchChargers, 1000);

  map.on('moveend', debouncedSearch);

  map.whenReady(() => {
    setTimeout(searchChargers, 800);
  });

  if (findBtn) {
    findBtn.onclick = () => {
      if (!navigator.geolocation) {
        if (status) status.textContent = 'Geolocalização não suportada.';
        return;
      }

      if (status) status.textContent = 'Acessando sua posição...';
      findBtn.disabled = true;

      navigator.geolocation.getCurrentPosition(
        (position) => {
          const { latitude, longitude } = position.coords;
          map.flyTo([latitude, longitude], 14, { animate: true, duration: 1.5 });
          findBtn.disabled = false;
        },
        () => {
          if (status) status.textContent = 'Permissão negada ou sinal indisponível.';
          findBtn.disabled = false;
        },
        { enableHighAccuracy: true, timeout: 8000 }
      );
    };
  }
};
