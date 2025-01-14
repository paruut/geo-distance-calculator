<script setup lang="ts">
import { onMounted, watch, ref } from 'vue'
import 'leaflet/dist/leaflet.css'
import type { Coordinates } from '@/types/geo'
import L from 'leaflet'

interface Props {
    point1: Coordinates
    point2: Coordinates
}

const props = defineProps<Props>()
const emit = defineEmits(['update:point1', 'update:point2', 'points-updated'])

const mapContainer = ref<HTMLElement | null>(null)
let map: L.Map | null = null
let marker1: L.Marker | null = null
let marker2: L.Marker | null = null
let line: L.Polyline | null = null

const icon = L.icon({
    iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41]
})

onMounted(() => {
    if (mapContainer.value) {
        map = L.map(mapContainer.value).setView([52.237049, 21.017532], 6)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map)

        marker1 = L.marker([props.point1.latitude, props.point1.longitude], {
            draggable: true,
            icon
        }).addTo(map)

        marker2 = L.marker([props.point2.latitude, props.point2.longitude], {
            draggable: true,
            icon
        }).addTo(map)

        line = L.polyline(
            [[props.point1.latitude, props.point1.longitude],
            [props.point2.latitude, props.point2.longitude]],
            { color: 'blue', weight: 3 }
        ).addTo(map)

        marker1.on('dragend', (event) => {
            const latLng = event.target.getLatLng()
            emit('update:point1', {
                latitude: latLng.lat,
                longitude: latLng.lng
            })
            emit('points-updated')
        })

        marker2.on('dragend', (event) => {
            const latLng = event.target.getLatLng()
            emit('update:point2', {
                latitude: latLng.lat,
                longitude: latLng.lng
            })
            emit('points-updated')
        })

        map.on('click', (event) => {
            if (!marker1 || !marker2) return

            const clickedPoint = event.latlng
            const dist1 = map!.distance(clickedPoint, marker1.getLatLng())
            const dist2 = map!.distance(clickedPoint, marker2.getLatLng())

            if (dist1 < dist2) {
                marker1.setLatLng(clickedPoint)
                emit('update:point1', {
                    latitude: clickedPoint.lat,
                    longitude: clickedPoint.lng
                })
            } else {
                marker2.setLatLng(clickedPoint)
                emit('update:point2', {
                    latitude: clickedPoint.lat,
                    longitude: clickedPoint.lng
                })
            }
            emit('points-updated')
        })
    }
})

watch([() => props.point1, () => props.point2], () => {
    if (!marker1 || !marker2 || !line || !map) return

    marker1.setLatLng([props.point1.latitude, props.point1.longitude])
    marker2.setLatLng([props.point2.latitude, props.point2.longitude])

    line.setLatLngs([
        [props.point1.latitude, props.point1.longitude],
        [props.point2.latitude, props.point2.longitude]
    ])

    const bounds = L.latLngBounds(
        [props.point1.latitude, props.point1.longitude],
        [props.point2.latitude, props.point2.longitude]
    )
    map.fitBounds(bounds, { padding: [50, 50] })
}, { deep: true })
</script>

<template>
    <div ref="mapContainer" class="w-full h-[500px] rounded-lg overflow-hidden shadow-lg"></div>
</template>