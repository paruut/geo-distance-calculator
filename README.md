
# Kalkulator Odległości Geograficznej 🌍

Aplikacja webowa umożliwiająca obliczanie odległości między dwoma punktami geograficznymi z wizualizacją na mapie.

![Geo App Screenshot](/geo-app.png)

## Funkcjonalności 🚀

- Obliczanie odległości między dwoma punktami geograficznymi
- Wyświetlanie wyniku w metrach i kilometrach
- Interaktywna mapa z markerami
- Możliwość przeciągania markerów na mapie
- Walidacja wprowadzanych współrzędnych
- Responsywny design
- Wizualizacja trasy między punktami

## Technologie 💻

### Frontend
- **Vue.js 3** z Composition API
- **TypeScript**
- **Tailwind CSS**
- **Leaflet** (mapy)
- **OpenStreetMap**
- **Axios**

### Backend
- **PHP**

## Wymagania systemowe 📋

- **Node.js** (v14 lub nowsza)
- **PHP** (v7.4 lub nowsza)
- Serwer HTTP (np. Apache)

## Instalacja i uruchomienie 🔧

### Backend

1. Skopiuj folder `backend` do katalogu serwera HTTP (np. `htdocs` w XAMPP):

   ```bash
   cp -r backend/ /path/to/htdocs/
   ```

### Frontend

1. Przejdź do katalogu `frontend`:
   ```bash
   cd frontend
   ```

2. Zainstaluj zależności:
   ```bash
   npm install
   ```

3. Uruchom aplikację w trybie deweloperskim:
   ```bash
   npm run dev
   ```

4. Aby zbudować aplikację na produkcję:
   ```bash
   npm run build
   ```

5. Opcjonalnie: uruchom lokalny serwer dla zbudowanej aplikacji:
   ```bash
   npm run preview
   ```

## Struktura projektu 📁

```bash
geo-distance-calculator/
├── backend/
│   └── calculate-distance.php
└── frontend/
    ├── src/
    │   ├── components/
    │   │   ├── CoordinateInput.vue
    │   │   ├── DistanceResult.vue
    │   │   ├── GeoForm.vue
    │   │   └── MapView.vue
    │   ├── services/
    │   │   └── api.ts
    │   ├── stores/
    │   │   └── geo.ts
    │   └── views/
    │       └── HomeView.vue
    └── public/
```

## API 📡

### Obliczanie odległości
**Endpoint:**  
`POST /backend/calculate-distance.php`

#### Request Body

```bash
{
  "point1": {
    "latitude": 52.237049,
    "longitude": 21.017532
  },
  "point2": {
    "latitude": 50.064650,
    "longitude": 19.944981
  }
}
```

#### Response

```bash
{
  "status": "success",
  "data": {
    "meters": 1500,
    "kilometers": 1.5
  }
}
```

## Funkcje 🛠

- Wprowadzanie współrzędnych geograficznych
- Walidacja danych wejściowych
- Interaktywna mapa z możliwością przeciągania punktów
- Automatyczne przeliczanie odległości
- Responsywny interfejs użytkownika
- Obsługa błędów
- Wizualizacja trasy

## Autor 👨‍💻

**Patryk Rutkowski**
