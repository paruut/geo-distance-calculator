<script setup lang="ts">
import { useGeoStore } from '@/stores/geo'
import { storeToRefs } from 'pinia'
import CoordinateInput from './CoordinateInput.vue'
import DistanceResult from './DistanceResult.vue'
import MapView from './MapView.vue'

const geoStore = useGeoStore()
const { point1, point2, distance, loading, error } = storeToRefs(geoStore)

const handlePointUpdate = () => {
    geoStore.calculateDistance()
}
</script>

<template>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
            Kalkulator odległości geograficznej
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-6">
                <CoordinateInput label="Punkt początkowy" v-model:coordinates="point1"
                    @update:coordinates="handlePointUpdate" />

                <CoordinateInput label="Punkt końcowy" v-model:coordinates="point2"
                    @update:coordinates="handlePointUpdate" />

                <div v-if="error" class="bg-red-50 text-red-700 p-4 rounded-lg border border-red-200">
                    {{ error }}
                </div>

                <DistanceResult v-if="distance && !error" :distance="distance" :loading="loading" />
            </div>

            <MapView class="min-h-[400px] rounded-lg shadow-lg" :point1="point1" :point2="point2"
                @update:point1="point1 = $event" @update:point2="point2 = $event" @points-updated="handlePointUpdate" />
        </div>
    </div>
</template>