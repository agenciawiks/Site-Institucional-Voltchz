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

  const searchChargers = async () => {
    const zoom = map.getZoom();
    
    // Permitir busca em níveis mais baixos para ver estados (zoom 6+)
    if (zoom < 6) {
      if (status) status.textContent = 'Aproxime um pouco mais para carregar os pontos.';
      return;
    }

    if (status) status.textContent = 'Buscando eletropostos na região...';
    
    try {
      const bounds = map.getBounds();
      const bbox = `${bounds.getSouth()},${bounds.getWest()},${bounds.getNorth()},${bounds.getEast()}`;
      
      // Query otimizada (apenas nodes em zoom muito baixo para evitar lentidão)
      let query;
      if (zoom < 8) {
        query = `[out:json][timeout:30];node["amenity"="charging_station"](${bbox});out;`;
      } else {
        query = `[out:json][timeout:30];(node["amenity"="charging_station"](${bbox});way["amenity"="charging_station"](${bbox});relation["amenity"="charging_station"](${bbox}););out center;`;
      }
      
      const response = await fetch(`${CONFIG.MAP.OVERPASS_URL}?data=${encodeURIComponent(query)}`);
      if (!response.ok) throw new Error(`Erro: ${response.status}`);
      
      const data = await response.json();
      
      markerGroup.clearLayers();
      
      if (!data.elements || data.elements.length === 0) {
        if (status) status.textContent = 'Nenhum eletroposto encontrado nesta área.';
        return;
      }

      if (status) status.textContent = `${data.elements.length} eletropostos localizados.`;
      
      data.elements.forEach(point => {
        const pLat = point.lat || (point.center && point.center.lat);
        const pLon = point.lon || (point.center && point.center.lon);
        if (!pLat || !pLon) return;

        const tags = point.tags || {};
        const marker = L.marker([pLat, pLon], { icon: chargerIcon }).addTo(markerGroup);
        
        const name = tags.name || tags.operator || 'Ponto de Recarga';
        const operator = tags.operator && tags.operator !== tags.name ? tags.operator : '';
        const capacity = tags.capacity || tags['socket:count'] || '';

        marker.bindPopup(`
          <div class="font-outfit p-1 min-w-[150px]">
            <strong class="text-brand-bg block border-b border-slate-100 pb-1 mb-1">${name}</strong>
            ${operator ? `<br><span class="text-xs text-slate-500">${operator}</span>` : ''}
            ${capacity ? `<br><span class="text-[10px] uppercase font-bold text-green-600">${capacity} conectores</span>` : ''}
            <a href="https://www.google.com/maps/search/?api=1&query=${pLat},${pLon}" target="_blank" class="block mt-2 text-[10px] font-bold text-blue-600 uppercase hover:underline">Abrir no Google Maps</a>
          </div>
        `);
      });
    } catch (err) {
      console.error('VoltchZ Map Error:', err);
      if (status) status.textContent = 'Erro ao buscar dados. Tente novamente em instantes.';
    }
  };

  const debouncedSearch = debounce(searchChargers, 1000);

  // Eventos do Mapa
  map.on('moveend', debouncedSearch);

  // Busca inicial
  map.whenReady(() => {
    setTimeout(searchChargers, 600);
  });

  // GPS
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
        (error) => {
          if (status) status.textContent = 'Permissão negada ou sinal indisponível.';
          findBtn.disabled = false;
        },
        { enableHighAccuracy: true, timeout: 8000 }
      );
    };
  }
};

