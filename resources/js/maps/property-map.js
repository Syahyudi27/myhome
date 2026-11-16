
import * as maplibregl from 'maplibre-gl';
import { setWorkerUrl } from 'maplibre-gl';
import workerUrl from 'maplibre-gl/dist/maplibre-gl-worker.mjs?worker&url';
import 'maplibre-gl/dist/maplibre-gl.css';

setWorkerUrl(workerUrl);

const facilityTypes = {
    school: {
        label: 'Sekolah',
        icon: '🏫',
        color: '#2563eb'
    },
    hospital: {
        label: 'Rumah Sakit',
        icon: '🏥',
        color: '#dc2626'
    },
    clinic: {
        label: 'Klinik',
        icon: '🩺',
        color: '#dc2626'
    },
    pharmacy: {
        label: 'Apotek',
        icon: '💊',
        color: '#16a34a'
    },
    supermarket: {
        label: 'Supermarket',
        icon: '🛒',
        color: '#d97706'
    },
    bank: {
        label: 'Bank',
        icon: '🏦',
        color: '#7c3aed'
    },
    atm: {
        label: 'ATM',
        icon: '💳',
        color: '#7c3aed'
    },
    station: {
        label: 'Stasiun',
        icon: '🚉',
        color: '#0891b2'
    },
    bus_station: {
        label: 'Halte / Terminal',
        icon: '🚌',
        color: '#0891b2'
    }
};

function initPropertyMap() {
    const mapElement = document.getElementById('map');

    if (!mapElement) return;

    const latitude = parseFloat(mapElement.dataset.latitude);
    const longitude = parseFloat(mapElement.dataset.longitude);

    if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
        console.warn('Koordinat properti belum tersedia.');
        return;
    }

    const map = new maplibregl.Map({
        container: mapElement,
        style: 'https://tiles.openfreemap.org/styles/bright',
        center: [longitude, latitude],
        zoom: 14
    });

    map.addControl(
        new maplibregl.NavigationControl(),
        'top-right'
    );


    // Tombol kembali ke lokasi properti
    const locationControl = document.createElement('button');

    locationControl.type = 'button';
    locationControl.title = 'Kembali ke lokasi properti';
    locationControl.setAttribute('aria-label', 'Kembali ke lokasi properti');
    locationControl.innerHTML = `
    <svg width="20" height="20" viewBox="0 0 24 24"
        fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round">
        <path d="M12 21s7-5.5 7-12a7 7 0 1 0-14 0c0 6.5 7 12 7 12z"/>
        <circle cx="12" cy="9" r="2.5"/>
    </svg>
`;

    locationControl.style.width = '36px';
    locationControl.style.height = '36px';
    locationControl.style.display = 'flex';
    locationControl.style.alignItems = 'center';
    locationControl.style.justifyContent = 'center';
    locationControl.style.background = '#fff';
    locationControl.style.border = 'none';
    locationControl.style.borderRadius = '4px';
    locationControl.style.cursor = 'pointer';
    locationControl.style.boxShadow = '0 1px 4px rgba(0,0,0,.25)';
    locationControl.style.color = '#333';

    locationControl.addEventListener('click', () => {
        map.flyTo({
            center: [longitude, latitude],
            zoom: 15,
            duration: 1200,
            essential: true
        });
    });

    const locationControlContainer = document.createElement('div');
    locationControlContainer.className = 'maplibregl-ctrl maplibregl-ctrl-group';
    locationControlContainer.appendChild(locationControl);

    const navigationContainer = mapElement.querySelector(
        '.maplibregl-ctrl-top-right'
    );

    if (navigationContainer) {
        navigationContainer.appendChild(locationControlContainer);
    }


    // Marker properti
    new maplibregl.Marker({ color: '#2563eb' })
        .setLngLat([longitude, latitude])
        .setPopup(
            new maplibregl.Popup().setText('Lokasi Properti')
        )
        .addTo(map);

    let facilityMarkers = [];
    let selectedCategory = 'all';

    // Membuat tombol filter
    const filterContainer = document.createElement('div');

    filterContainer.style.position = 'absolute';
    filterContainer.style.top = '10px';
    filterContainer.style.left = '10px';
    filterContainer.style.zIndex = '2';
    filterContainer.style.display = 'flex';
    filterContainer.style.flexWrap = 'wrap';
    filterContainer.style.gap = '6px';
    filterContainer.style.maxWidth = 'calc(100% - 60px)';

    mapElement.style.position = 'relative';
    mapElement.appendChild(filterContainer);

    const categories = [
        { id: 'all', label: 'Semua' },
        { id: 'school', label: 'Sekolah' },
        { id: 'health', label: 'Kesehatan' },
        { id: 'pharmacy', label: 'Apotek' },
        { id: 'supermarket', label: 'Supermarket' },
        { id: 'transport', label: 'Transportasi' },
        { id: 'finance', label: 'Bank & ATM' }
    ];

    categories.forEach(category => {
        const button = document.createElement('button');

        button.textContent = category.label;
        button.type = 'button';
        button.style.padding = '7px 11px';
        button.style.borderRadius = '20px';
        button.style.border = '1px solid #ddd';
        button.style.background = category.id === 'all' ? '#2563eb' : '#fff';
        button.style.color = category.id === 'all' ? '#fff' : '#333';
        button.style.fontSize = '12px';
        button.style.fontWeight = '600';
        button.style.cursor = 'pointer';

        button.addEventListener('click', () => {
            selectedCategory = category.id;

            filterContainer.querySelectorAll('button').forEach(btn => {
                const active = btn === button;
                btn.style.background = active ? '#2563eb' : '#fff';
                btn.style.color = active ? '#fff' : '#333';
            });

            updateMarkers();
        });

        filterContainer.appendChild(button);
    });

    function getCategory(type) {
        if (type === 'school') return 'school';

        if (['hospital', 'clinic'].includes(type)) {
            return 'health';
        }

        if (type === 'pharmacy') return 'pharmacy';

        if (type === 'supermarket') return 'supermarket';

        if (['station', 'bus_station'].includes(type)) {
            return 'transport';
        }

        if (['bank', 'atm'].includes(type)) {
            return 'finance';
        }

        return null;
    }

    function updateMarkers() {
        facilityMarkers.forEach(marker => {
            const category = marker.category;

            const visible =
                selectedCategory === 'all' ||
                selectedCategory === category;

            marker.element.style.display = visible ? 'flex' : 'none';
        });
    }

    async function loadFacilities() {
        const query = `
            [out:json][timeout:25];
            (
                node(around:1500,${latitude},${longitude})["amenity"~"school|hospital|clinic|pharmacy|bank|atm|bus_station"];
                way(around:1500,${latitude},${longitude})["amenity"~"school|hospital|clinic|pharmacy|bank|atm|bus_station"];
                relation(around:1500,${latitude},${longitude})["amenity"~"school|hospital|clinic|pharmacy|bank|atm|bus_station"];

                node(around:1500,${latitude},${longitude})["shop"="supermarket"];
                way(around:1500,${latitude},${longitude})["shop"="supermarket"];
                relation(around:1500,${latitude},${longitude})["shop"="supermarket"];

                node(around:1500,${latitude},${longitude})["railway"="station"];
                way(around:1500,${latitude},${longitude})["railway"="station"];
                relation(around:1500,${latitude},${longitude})["railway"="station"];
            );
            out center tags;
        `;

        try {
            const response = await fetch(
                'https://overpass-api.de/api/interpreter',
                {
                    method: 'POST',
                    body: new URLSearchParams({ data: query })
                }
            );

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const result = await response.json();

            result.elements.forEach(place => {
                const lat = place.lat ?? place.center?.lat;
                const lon = place.lon ?? place.center?.lon;

                if (lat == null || lon == null) return;

                const tags = place.tags || {};

                const type =
                    tags.amenity === 'bus_station'
                        ? 'bus_station'
                        : tags.amenity || tags.shop ||
                        (tags.railway === 'station' ? 'station' : null);

                const facility = facilityTypes[type];

                if (!facility) return;

                const name = tags.name || facility.label;
                const category = getCategory(type);

                const markerElement = document.createElement('div');

                markerElement.textContent = facility.icon;
                markerElement.style.width = '34px';
                markerElement.style.height = '34px';
                markerElement.style.background = '#fff';
                markerElement.style.border = `2px solid ${facility.color}`;
                markerElement.style.borderRadius = '50%';
                markerElement.style.display = 'flex';
                markerElement.style.alignItems = 'center';
                markerElement.style.justifyContent = 'center';
                markerElement.style.fontSize = '17px';
                markerElement.style.cursor = 'pointer';
                markerElement.style.boxShadow = '0 2px 6px #0003';

                const popup = new maplibregl.Popup({
                    offset: 20
                }).setText(`${name} - ${facility.label}`);

                const marker = new maplibregl.Marker({
                    element: markerElement
                })
                    .setLngLat([lon, lat])
                    .setPopup(popup)
                    .addTo(map);

                facilityMarkers.push({
                    marker,
                    element: markerElement,
                    category
                });
            });

            updateMarkers();

            console.log(
                `${facilityMarkers.length} fasilitas berhasil ditemukan.`
            );

        } catch (error) {
            console.error('Gagal mengambil fasilitas umum:', error);
        }
    }

    map.on('load', () => {
        console.log('Peta properti berhasil dimuat!');
        loadFacilities();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPropertyMap);
} else {
    initPropertyMap();
}
