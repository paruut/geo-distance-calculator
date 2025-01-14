<script setup lang="ts">
import type { Coordinates } from '@/types/geo'

interface Props {
    label: string
    coordinates: Coordinates
}

const props = defineProps<Props>()
const emit = defineEmits(['update:coordinates'])

const updateCoordinate = (type: 'latitude' | 'longitude', value: string) => {
    const numValue = parseFloat(value)
    if (!isNaN(numValue)) {
        emit('update:coordinates', {
            ...props.coordinates,
            [type]: numValue
        })
    }
}

const isValidLatitude = (value: number) => value >= -90 && value <= 90
const isValidLongitude = (value: number) => value >= -180 && value <= 180
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ label }}</h3>

        <div class="space-y-4">
            <div class="space-y-2">
                <label class="block">
                    <span class="text-sm font-medium text-gray-700">Szerokość geograficzna:</span>
                    <input type="number" step="0.000001" :value="coordinates.latitude"
                        @input="updateCoordinate('latitude', ($event.target as HTMLInputElement).value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                   focus:border-blue-500 focus:ring-blue-500 bg-white"
                        :class="{ 'border-red-300 bg-red-50': !isValidLatitude(coordinates.latitude) }"
                        placeholder="-90 do 90" />
                    <span class="text-sm text-gray-500">(-90 do 90)</span>
                </label>
            </div>

            <div class="space-y-2">
                <label class="block">
                    <span class="text-sm font-medium text-gray-700">Długość geograficzna:</span>
                    <input type="number" step="0.000001" :value="coordinates.longitude"
                        @input="updateCoordinate('longitude', ($event.target as HTMLInputElement).value)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                   focus:border-blue-500 focus:ring-blue-500 bg-white"
                        :class="{ 'border-red-300 bg-red-50': !isValidLongitude(coordinates.longitude) }"
                        placeholder="-180 do 180" />
                    <span class="text-sm text-gray-500">(-180 do 180)</span>
                </label>
            </div>
        </div>
    </div>
</template>